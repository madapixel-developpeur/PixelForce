<?php
namespace App\Services;

use Exception;
use App\Entity\User;
use App\Entity\Devis;
use App\Util\ToolKit;
use App\Entity\OrderPack;
use App\Services\SpreadsheetService;
use Doctrine\ORM\EntityManagerInterface;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;

class OrderPackService
{
    private $entityManager;
    private $stripeService;
    private $mailerService;
    private $wrapper;
    private $fileHandler;
    private $spreadsheetService;


    
    

    public function __construct(EntityManagerInterface $entityManager, StripeService $stripeService, MailerService $mailerService, DompdfWrapperInterface $wrapper, FileHandler $fileHandler,  SpreadsheetService $spreadsheetService)
    {
        $this->entityManager = $entityManager;
        $this->stripeService = $stripeService;
        $this->mailerService = $mailerService;
        $this->wrapper = $wrapper;
        $this->fileHandler = $fileHandler;
        $this->spreadsheetService = $spreadsheetService;
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
            $this->saveInvoice($order);
            // $this->mailerService->sendFactureOrderPack($order);

            if(!$order->getAgent()->getHasPaidSubscription()) $order->getAgent()->setHasPaidSubscription(true);
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


    public function saveInvoice(OrderPack $order){
        // Achat du pack
        $facturePdf = $this->mailerService->renderTwig('pdf/facture_pack.html.twig', [
            'order' => $order,
            'subscriptionAmount'=> OrderPack::SUBSCRIPTION_AMOUNT
        ]);
        // dd($facturePdf);
        // $facturePdf = mb_convert_encoding($facturePdf, 'UTF-8');
        $binary = $this->wrapper->getPdf($facturePdf, ['isRemoteEnabled' => true, 'isHtml5ParserEnabled'=>true, 'defaultFont'=> 'Arial']);
        $directory = "factures/dd";
        $pj_filepath = $this->fileHandler->saveBinary($binary, "Facture Greenlife Ultimate-Commande n°".$order->getId()." du ".date('Y-m-d-H-i-s').'.pdf', $directory);
        

        // Souscription
        // $facturePdf = $this->mailerService->renderTwig('pdf/facture_register_subscription.html.twig', [
        //     'order' => $order
        // ]);
        // $binary = $this->wrapper->getPdf($facturePdf, ['isRemoteEnabled' => true, 'isHtml5ParserEnabled'=>true, 'defaultFont'=> 'Arial']);
        // $directory = "factures/dd";
        // $pj_filepath_register_subscription = $this->fileHandler->saveBinary($binary, "Facture Souscription Greenlife Ultimate-Commande n°".$order->getId()." du ".date('Y-m-d-H-i-s').'.pdf', $directory);
        // $invoicePath = implode(";", [$pj_filepath, $pj_filepath_register_subscription]);

        $order->setInvoicePath($pj_filepath);
        $this->entityManager->flush();
    }


    public function exportOrderPackProductsToCsv(array $orderPackProducts){
         $headers = [
            "N° produit", "Nom du produit", "Prix Unitaire", "Quantité commandée", "Prix Total" 
        ];
        $fields = [
            "product.id", "product.nom", "product.prix", "qty", "price" 
        ];


        $options = [
            'convert_string_to_numeric' => ['fields' => ['product.prix', 'price']]
        ];
       return $this->spreadsheetService->exportPackProduct($orderPackProducts, $fields, $headers, $options);
    }

    public function sendOrderPackProductsToSogec(array $orderPackProducts){
        $remotePath = $_ENV['FTP_FOLDER_PATH']."/".ToolKit::generateFileName("csv") ;       
        $file = $this->exportOrderPackProductsToCsv($orderPackProducts);
        ToolKit::uploadFileViaSftp($_ENV['FTP_SERVER_NAME'],$_ENV['FTP_SERVER_PORT'],$_ENV['FTP_USER_NAME'],$_ENV['FTP_USER_PASSWORD'],$file,$remotePath);
    }
    
    
}
