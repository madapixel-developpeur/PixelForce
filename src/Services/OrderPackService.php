<?php
namespace App\Services;

use App\Entity\Devis;
use App\Entity\OrderPack;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;

class OrderPackService
{
    private $entityManager;
    private $stripeService;
    private $mailerService;
    private $wrapper;
    private $fileHandler;
    

    public function __construct(EntityManagerInterface $entityManager, StripeService $stripeService, MailerService $mailerService, DompdfWrapperInterface $wrapper, FileHandler $fileHandler)
    {
        $this->entityManager = $entityManager;
        $this->stripeService = $stripeService;
        $this->mailerService = $mailerService;
        $this->wrapper = $wrapper;
        $this->fileHandler = $fileHandler;
    }

    

    public function saveOrder(OrderPack $order, $stripeToken): ?OrderPack{
        try{
            $this->entityManager->beginTransaction();


            
            $this->entityManager->persist($order);

            $paymentIntent = $this->stripeService->paymentIntent($order->getAmount());
            $order->setStripeChargeId($paymentIntent->id);
            $userDatas = [
                "lastname"=>$order->getAgent()->getNom(),
                "mail"=>$order->getAgent()->getEmail()
            ];
            $this->stripeService->subscribe($stripeToken, $order->getAmount(), $userDatas);
            
            $order->getAgent()->setHasPaidSubscription(true);
            
            $this->entityManager->flush();
            $this->entityManager->commit();
            
            return $order;
        } 
        catch(\Exception $ex){
            if($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->rollback();
            }
            throw $ex;
        }
        finally {
            $this->entityManager->clear();
        }
    }

    public function payOrder(OrderPack $order){
        try{
            $this->entityManager->beginTransaction();
            $paymentIntent = $this->stripeService->getPaymentIntent($order->getStripeChargeId());
            if($paymentIntent->status != "succeeded") throw new Exception("Erreur rencontrée lors du paiement");
            $order->setStatut(OrderPack::PAIED);
            $order->getDevis()->setStatus(Devis::DEVIS_STATUS['PAID']);
            $order->getDevis()->setStatusInt(Devis::DEVIS_STATUS_INT['PAID']);
            $this->entityManager->persist($order);
            $this->entityManager->persist($order->getDevis());
            $this->entityManager->flush();
            $this->entityManager->commit();
            try{
                $this->saveInvoice($order);
                $this->mailerService->sendFactureOrderPack($order);
            } catch(Exception $ex){}
        } 
        catch(\Exception $ex){
            if($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->rollback();
            }
            throw $ex;
        }
        finally {
            $this->entityManager->clear();
        }
    }

    public function saveInvoice(OrderPack $order){
        $facturePdf = $this->mailerService->renderTwig('pdf/facture_devis_digital.html.twig', [
            'order' => $order
        ]);
        $binary = $this->wrapper->getPdf($facturePdf, ['isRemoteEnabled' => true, 'isHtml5ParserEnabled'=>true, 'defaultFont'=> 'Arial']);
        $directory = "factures/dd";
        $pj_filepath = $this->fileHandler->saveBinary($binary, "Facture Greenlife Ultimate-Commande n°".$order->getId()." du ".date('Y-m-d-H-i-s').'.pdf', $directory);
        $order->setInvoicePath($pj_filepath);
        $this->entityManager->flush();
    }
    
}
