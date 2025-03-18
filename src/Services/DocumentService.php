<?php

namespace App\Services;

use DateTime;
use Exception;
use DateInterval;
use App\Entity\User;
use setasign\Fpdi\Fpdi;
use mikehaertl\pdftk\Pdf;
use App\Entity\ForgotPassword;
use App\Entity\AccountValidation;
use App\Entity\DocumentRecipient;
use App\Repository\UserRepository;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment as Twig_Environment;
use App\Repository\ForgotPasswordRepository;
use App\Repository\AccountValidationRepository;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DocumentService 
{
    private $entityManager;
    private $documentRepository;
    private $filesDirectory;
    private $baseUrl;
    private $stripeService;
    private $twig;
    public const FIELDS_SEPA = [
        ['field' => 'nom_prenom_raison_sociale', 'debut' => 97, 'fin' => 97],
        ['field' => 'adresse_nom_rue', 'debut' => 98, 'fin' => 98],
        ['field' => 'ville', 'debut' => 99, 'fin' => 99],
        ['field' => 'pays', 'debut' => 100, 'fin' => 100],
        ['field' => 'code_postal', 'debut' => 105, 'fin' => 109],
        ['field' => 'lieu_signature', 'debut' => 102, 'fin' => 102],
        ['field' => 'date_signature', 'debut' => 103, 'fin' => 103],
        ['field' => 'creancier_n_client', 'debut' => 101, 'fin' => 101],
        ['field' => 'creancier_code_rum', 'debut' => 104, 'fin' => 104],
        ['field' => 'coordonnees_compte', 'debut' => 110, 'fin' => 136],
        ['field' => 'code_bic', 'debut' => 137, 'fin' => 147],
        ['field' => 'paiement', 'debut' => 148, 'fin' => 148],
    ];
    
    private $mailerService;

    public function __construct(
        $filesDirectory,
        $baseUrl,
        EntityManagerInterface $entityManager, 
        DocumentRepository $documentRepository, 
        StripeService $stripeService,
        Twig_Environment $twig ,
        MailerService $mailerService,
        private KernelInterface $kernel
    )
    {
        $this->entityManager = $entityManager;
        $this->documentRepository = $documentRepository;
        $this->filesDirectory = $filesDirectory;
        $this->baseUrl = $baseUrl;
        $this->stripeService = $stripeService;
        $this->twig = $twig;
        $this->mailerService = $mailerService;
    }

    public function sendDocument(DocumentRecipient $rec)
    {
        
        $rec->setPaid(false);
        $rec->setStatut(1);
        $rec->setDateSend(new DateTime());
        
        $this->entityManager->persist($rec);
        $this->entityManager->flush();

        $link = $this->baseUrl.'/dc/'.sha1($rec->getId());

        $this->mailerService->sendDocument($rec, $link, $rec);
    }

    public function signDocument(DocumentRecipient $rec, $signature){
        try{
            if($rec->getSignedFile() == null) throw new \Exception("Vous devez importer le document déjà rempli avant de signer le document.");
            $source = $this->filesDirectory.'/'.$rec->getSignedFile();
            
            // Flatten form datas of pdf :
            $this->flattenDocument($source, $source, null);

            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($source);

            for($i=1; $i<=$pageCount; $i++){
                $pdf->AddPage();
                $tplId = $pdf->importPage($i);
                $pdf->useTemplate($tplId);
                if($i == 4){
                    $pdf->Image($signature, 0, 180, 120);
                }
            }
            
            $pdf->Output($source, 'F');
            $rec->setDateSigned(new DateTime());
            $this->entityManager->flush(); 
        } finally{
            $this->entityManager->clear();
        }
    }

    public function flattenDocument($inputFilepath, $outputFilepath, $datas = null){
        // if inputFilepath = outputFilepath , the file will be replaced by the new one
        $pdf = new Pdf($inputFilepath);
        if($datas != null){
            $pdf->fillForm($datas);
        }
        $result = $pdf->allow('AllFeatures')      // Change permissions
            ->needAppearances()
            ->flatten()
            ->saveAs($outputFilepath);
        // Always check for errors
        if ($result === false) {
            $error = $pdf->getError();
            throw new \Exception($error);
        }
    }

    public function pay(DocumentRecipient $rec){
        try{
            $paymentIntent = $this->stripeService->getPaymentIntent($rec->getPaymentIntentId());
            if($paymentIntent->status != "succeeded") throw new Exception("Erreur rencontrée lors du paiement");
            $rec->setPaid(true);        
            $this->entityManager->flush();
        } finally {
            $this->entityManager->clear();
        }
    }


    public function getData($filepath){
        $pdf = new Pdf( $this->filesDirectory.'/'.$filepath);
        $result = $pdf->getDataFields();
        if ($result === false) {
            $error = $pdf->getError();
            throw new \Exception($error);
        }

        return $result->__toArray();
        /* $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($this->filesDirectory.'/'.$filepath);
        $metaData = $pdf->getDetails();
        return $metaData; */
    }

    public function getDataSepa($tab){
        $result = [];
        for($i=0; $i<count(DocumentService::FIELDS_SEPA); $i++){
            $field = DocumentService::FIELDS_SEPA[$i];
            $val = '';
            for($j=$field['debut']; $j<=$field['fin']; $j++){
                if(isset($tab[$j]['FieldValue'])){
                    $val .= $tab[$j]['FieldValue'];
                }
            }
            $result[$field['field']] = $val;
        }
        return $result;
    }

    public function signContrat($contrat, $output, $signature){
        try{
            $source = $this->filesDirectory.'/'.$contrat;
            $outputPath = $this->filesDirectory.'/'.$output;

            // Flatten form datas of pdf :
            $this->flattenDocument($source, $outputPath, null);

            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($outputPath);

            for($i=1; $i<=$pageCount; $i++){
                $pdf->AddPage();
                $tplId = $pdf->importPage($i);
                $pdf->useTemplate($tplId);
                if($i == 4){
                    $pdf->Image($signature, 0, 180, 120);
                }
            }
            
            $pdf->Output($outputPath, 'F');
            return $output;
        } finally{
            $this->entityManager->clear();
        }
    }

    public function getFileDocument($type)
    {
        $document_array = [
           "CGU" =>  "/contrat-template/CGU_Pixelforce.pdf",
           "CGV" =>  "/contrat-template/CGV_Pixelforce.pdf",
        ];
       

        $filePath = $document_array[$type];

        $filePath = $this->kernel->getProjectDir(). $filePath;


        if (!file_exists($filePath)) {
            throw new Exception('Fichier introuvable');
        }
        return [
            'filePath' => $filePath,
            'filename' => basename($document_array[$type]),
            'typeName' => $type
        ];
    }
}
