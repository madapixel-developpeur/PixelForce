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


    public function exportOrderPackToCsv(OrderPack $orderPack){
         $headers = [
            "N° produit", "Nom du produit", "Prix Unitaire", "Quantité commandée", "Prix Total" 
        ];
        $fields = [
            "product.id", "product.nom", "product.prix", "qty", "price" 
        ];


        $options = [
            'convert_string_to_numeric' => ['fields' => ['product.prix', 'price']]
        ];

        $headers = [
            "N° commande", "Identifiant client", "Mode d'expédition", "Code point relais", "Type point relais", "Lot acheminement",
            "Distribution sort", "Version Plan de tri", "Date d’expédition prévue (départ entrepôt)", "Civilité du client livré", "Nom du client livré",
            "Prénom du client livré", "Raison Sociale du client livré", "Contact du client de livraison", "Adresse 1 livraison", "Adresse 2 livraison",
            "Adresse 3 livraison", "Adresse 4 livraison", "Code postal livraison", "Ville livraison", "Code pays livraison", "Pays livraison", "Tél fixe livraison",
            "Port livraison", "Fax livraison", "Email livraison", "Nom et Prénom du client facturé", "Adresse 1 facturation", "Adresse 2 facturation", 
            "Adresse 3 facturation", "Adresse 4 facturation", "Code postal facturation", "Ville facturation", "Code pays facturation", "Pays facturation",
            "Contact facturation", "Tél facturation", "Port facturation", "Fax facturation", "Email facturation", "Référence article", "Quantité commandée",
            "Numéro commande B2B ", "Référence fournisseur", "Prise de rendez-vous obligatoire", "Commentaires livraison", "Prix de vente de l'article"
        ];
        $fields = [
            "id", "agent.id", "ModeExpedition", null, null, null,
            null, null, null, null, "agent.nom",
            "agent.prenom", null, null, "agent.adresse", "agent.numeroRue", // deliveryAddress3 => Adresse 1 livraison (correct)
            "agent.adresse", null, "agent.codePostal", "agent.ville", null, null, null,
            null, null, null, null, null, null, // billingAddress3 => Adresse 1 facturation (correct)
            null, null, null, null, null, null,
            null, null, null, null, null, "productsInOrder", "orderProductsQuantity",
            null, null, null, null, "itemsAmount"
        ];
        $options = [
            'convert_string_to_numeric' => ['fields' => ['itemsAmount']],
            'repeat_row' => ['field' => 'productsInOrder']
        ];
        // dd($orderPack->getProductsInOrder());
        //$orderPackProducts = $orderPack->getPack()->getProducts()->toArray()
       return $this->spreadsheetService->exportOrderPack([$orderPack], $fields, $headers, $options);
    }

    public function sendOrderPackToSogec(OrderPack $orderPack){
        $remotePath = $_ENV['FTP_FOLDER_PATH']."/".ToolKit::generateFileName("csv") ;       
        $file = $this->exportOrderPackToCsv($orderPack);
        ToolKit::uploadFileViaSftp($_ENV['FTP_SERVER_NAME'],$_ENV['FTP_SERVER_PORT'],$_ENV['FTP_USER_NAME'],$_ENV['FTP_USER_PASSWORD'],$file,$remotePath);
    }
    
    
}
