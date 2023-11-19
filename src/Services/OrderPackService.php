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


    public function exportOrdersPackToCsv($ordersPack){
 
        $headers = [
            "N° commande", "Identifiant client", "Mode d'expédition", "Code point relais", "Type point relais", "Prix du frais de port",
            "Champ 1", "Champ 2", "Date d’expédition prévue (départ entrepôt)", "Civilité du client livré", "Nom du client livré",
            "Prénom du client livré", "Marque / entreprise", "Contact", "Adresse 1 livraison", "Adresse 2 livraison",
            "Adresse 3 livraison", "Adresse 4 livraison", "Code postal livraison", "Ville livraison", "Code pays livraison", "Pays livraison", "Tél fixe livraison",
            "Portable livraison", "Fax livraison", "Email livraison", "Nom et Prénom du client facturé", "Adresse 1 facturation", "Adresse 2 facturation", 
            "Adresse 3 facturation", "Adresse 4 facturation", "Code postal facturation", "Ville facturation", "Code pays facturation", "Pays facturation",
            "Contact facturation", "Tél facturation", "Port facturation", "Fax facturation", "Email facturation", "Référence article", "Quantité commandée",
            "Numéro commande B2B ", "Référence fournisseur", "Prise de rendez-vous obligatoire", "Commentaires livraison", "Prix de vente de l'article"
        ];
        $fields = [
            "id", "agent.id", null, null, null, null,
            null, null, null, null, "agent.nom",
            "agent.prenom", null, null, null, null,
            null, null, "agent.codePostal", "agent.ville", null, null, null,
            "agent.telephone", null, "agent.email", "agent.fullName", null,null,
            null, null,null,null, null, null,
            null, null, "agent.telephone", null, "agent.email", "pack", "minimumNumberOfPack",
            null, null, null, null, "pack.cost"
        ];


        $options = [
            'convert_string_to_numeric' => ['fields' => ['itemsAmount']],
            'repeat_row' => ['field' => 'productsInOrder']
        ];
       return $this->spreadsheetService->exportOrderPack($ordersPack, $fields, $headers, $options);
    }

    public function sendOrderPackToSogec(OrderPack $orderPack){
        $remotePath = $_ENV['FTP_FOLDER_PATH']."/".ToolKit::generateFileName("csv") ;       
        $file = $this->exportOrdersPackToCsv([$orderPack]);
        ToolKit::uploadFileViaSftp($_ENV['FTP_SERVER_NAME'],$_ENV['FTP_SERVER_PORT'],$_ENV['FTP_USER_NAME'],$_ENV['FTP_USER_PASSWORD'],$file,$remotePath);
    }
    
}
