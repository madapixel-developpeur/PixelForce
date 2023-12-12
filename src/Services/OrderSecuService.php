<?php
namespace App\Services;

use App\Entity\BasketItem;
use App\Entity\OrderSecu;
use App\Entity\Secteur;
use App\Entity\User;
use App\Repository\CodePromoSecuRepository;
use App\Repository\OrderSecuRepository;
use App\Repository\TypeAbonnementSecuRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
class OrderSecuService
{
    private $session;
    private $codePromoSecuRepository;
    private $orderSecuRepository;
    private $entityManager;
    private $stripeService;
    const PREFIX = 'order-secu-';
    private $mailerService;
    private $wrapper;
    private $fileHandler;

    public function __construct(SessionInterface $session, CodePromoSecuRepository $codePromoSecuRepository, EntityManagerInterface $entityManager, StripeService $stripeService, OrderSecuRepository $orderSecuRepository, MailerService $mailerService, DompdfWrapperInterface $wrapper, FileHandler $fileHandler)
    {
        $this->session = $session;
        $this->codePromoSecuRepository = $codePromoSecuRepository;
        $this->entityManager = $entityManager;
        $this->stripeService = $stripeService;
        $this->orderSecuRepository = $orderSecuRepository;
        $this->mailerService = $mailerService;
        $this->wrapper = $wrapper;
        $this->fileHandler = $fileHandler;
    }

    public function setOrderSecu(OrderSecu $order){
        $this->session->set(OrderSecuService::PREFIX.$order->getSessionKey(), $order);
    }

    public function getOrderSecu($sessionKey): ?OrderSecu 
    {
        return $this->session->get(OrderSecuService::PREFIX.$sessionKey);
    }

    public function getOrderSecuOrDefault($sessionKey): OrderSecu
    {
        $order = $this->getOrderSecu($sessionKey);
        return $order ? $order : new OrderSecu();
    }

    public function removeOrderSecu($sessionKey){
        $this->session->remove(OrderSecuService::PREFIX.$sessionKey);
    }


    public function calculerPrixProduit(OrderSecu $order, $secteurId){
        $order->setPrixProduit($order->getKitbase()->getPrix());
        if($order->getCodePromo()){
            $codePromoSecu = $this->codePromoSecuRepository->findValid($order->getCodePromo(), $secteurId);
            if($codePromoSecu) $order->setPrixProduit($codePromoSecu->getPrix());
        }
    }

    public function saveOrder(OrderSecu $orderSecu): ?OrderSecu{
        try{
            $this->entityManager->beginTransaction();

            $orderSecu->refresh($this->entityManager);
            $orderSecu->getKitbase()->checkValid();
            $orderSecu->setDateCommande(new DateTime());
            $orderSecu->setStatut(OrderSecu::CREATED);
            $orderSecu->setAccompMontant(0);
            $orderSecu->setTvaPourcentage($orderSecu->getTva()->getValeur());
            //$orderSecu->setInstallationFrais($orderSecu->getFraisInstallation());

            $this->entityManager->persist($orderSecu);

            $montantAccomp = 0;
            foreach($orderSecu->getAccompsSession() as $accomp){
                $accomp->refresh($this->entityManager);
                $accomp->getProduit()->checkValid();

                $accomp->setPrix($accomp->getProduit()->getPrix());
                $orderSecu->addAccomp($accomp);
                $this->entityManager->persist($accomp);

                $montantAccomp += $accomp->getProduit()->getPrix() * $accomp->getQte();
            }
            $orderSecu->setAccompMontant($montantAccomp); 
            
            $paymentIntent = $this->stripeService->paymentIntent($orderSecu->getTotalTtc());
            $orderSecu->setChargeId($paymentIntent->id);   

            $this->entityManager->flush();
            $this->entityManager->commit();
            return $orderSecu;
        } catch(\Exception $ex){
            if($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->rollback();
            }
            throw $ex;
        } finally {
            $this->entityManager->clear();
        }
    }

    public function payOrder(OrderSecu $order){
        $paymentIntent = $this->stripeService->getPaymentIntent($order->getChargeId());
        if($paymentIntent->status != "succeeded") throw new Exception("Erreur rencontrée lors du paiement");
        $order->setStatut(OrderSecu::PAIED);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        try{
            $this->saveInvoice($order);
            $this->mailerService->sendFactureSecu($order);
        } catch(Exception $ex){}
    }


    public function changeStatus(int $orderId, int $status)
    {
        $order = $this->orderSecuRepository->find($orderId);
        if(!$order)  {
            throw new Exception("La commande n°".$orderId." n'existe pas");
        }
        $order->setStatut($status);
        $this->entityManager->flush();
    }

    public function saveInvoice(OrderSecu $order){
        $facturePdf = $this->mailerService->renderTwig('pdf/facture_secu.html.twig', [
            'order' => $order
        ]);
        $binary = $this->wrapper->getPdf($facturePdf, ['isRemoteEnabled' => true, 'isHtml5ParserEnabled'=>true, 'defaultFont'=> 'Arial']);
        $directory = "factures/secu";
        $pj_filepath = $this->fileHandler->saveBinary($binary, "Facture Greenlife Ultimate-Commande n°".$order->getId()." du ".date('Y-m-d-H-i-s').'.pdf', $directory);
        $order->setInvoicePath($pj_filepath);
        $this->entityManager->flush();
    }
}