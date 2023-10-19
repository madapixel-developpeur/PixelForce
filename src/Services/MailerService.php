<?php


namespace App\Services;

use App\Entity\DevisCompany;
use Twig\Environment as Twig_Environment;
use App\Entity\DocumentRecipient;
use App\Entity\Formation;
use App\Entity\Order;
use App\Entity\OrderAroma;
use App\Entity\OrderDigital;
use App\Entity\OrderSecu;
use App\Entity\User;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerService
{

    /**
     * @var Mailer
     */
    private $mailer;
    private $from;
    private $from_name;
    private $parameterBag;
    private $twig;
    private $wrapper;
    private $fileHandler;

    public function __construct(MailerInterface $mailer, ParameterBagInterface $parameterBag, Twig_Environment $twig, DompdfWrapperInterface $wrapper, FileHandler $fileHandler)
    {
        $this->mailer = $mailer;
        $this->from =  $_ENV['MAILER_SEND_FROM'];
        $this->from_name = $_ENV['MAILER_SEND_FROM_NAME'];
        $this->parameterBag = $parameterBag;
        $this->twig = $twig;
        $this->wrapper = $wrapper;
        $this->fileHandler = $fileHandler;
    }

    public function sendMailInscriptionUser($email)
    {
        $this->sendMail([
            'subject' => 'Code de vérification',
            'to' => [
                $email
            ],
            'template' => 'inscription/lien_page_inscription.html.twig',
            'template_vars' => [
                'encodedMail' => base64_encode($email),
            ]
        ]);
    }

    public function sendMailRegenerationCode(User $user)
    {
        $this->sendMail([
            'subject' => 'Code de vérification',
            'to' => [
                $user->getEmail()
            ],
            'template' => 'security/sixDigitKey.html.twig',
            'template_vars' => [
                'sixDigitKey' => $user->getSixDigitCode()
            ]
        ]);
    }

    public function sendMailAfterDoneFormation(User $sender, User $recipient, Formation $formation)
    {
        $this->sendMail([
            'subject' => 'Formation terminée',
            //'from' => $sender->getEmail(),
            //'from_name' => $sender->getNom(),
            'to' => [
                $recipient->getEmail()
            ],
            'template' => 'formation/formation_done.html.twig',
            'template_vars' => [
                'formation' => $formation,
                'agent' => $sender
            ]
        ]);
    }

    public function sendVerifCodeToClient($recipient, $code, $dateExpiration)
    {
        $this->sendMail([
            'subject' => 'Validation du nouveau compte',
            'to' => [
                $recipient->getEmail()
            ],
            'template' => 'inscription/code_verification_client.html.twig',
            'template_vars' => [
                'code' => $code,
                'dateExpiration' => $dateExpiration
            ]
        ]);       
    }

    public function SendDevisToCompany($recipient, $devisCompany, $pj_pathname)
    {
        $email = (new TemplatedEmail())
        ->from(new Address($this->from, $this->from_name))
        ->to($recipient)
        ->subject('Devis')
        ->htmlTemplate('emails/devis/devis_entreprise.html.twig')
        ->context([
            'devisCompany' => $devisCompany
        ])
        ->attachFromPath($this->parameterBag->get('kernel.project_dir')."/public/files/".$pj_pathname, null);
        $this->mailer->send($email);
    }


    public function sendDocument(DocumentRecipient $rec, $link, $recipient)
    {
        $email = (new TemplatedEmail())
            ->from(new Address($this->from, $this->from_name))
            ->to($recipient->getEmail())
            ->subject("Signature du document << ".$rec->getDocument()->getNom()." >>")
            ->htmlTemplate('emails/document.html.twig')
            ->context([
                'link' => $link,
                'conseiller' => $rec->getConseiller()
            ])
            ->embedFromPath($this->parameterBag->get('kernel.project_dir').'/public/assets/img/securitas.png', 'logoSecuritas', 'image/png');
        $this->mailer->send($email);
    }


    public function sendMail($parameters)
    {
        $email = (new TemplatedEmail())
            //->from(new Address($parameters['from'], isset($parameters['from_name']) ? $parameters['from_name'] : ''))
            ->from(new Address($this->from, $this->from_name))
            ->subject($parameters['subject'])
        ;

        // email des recepteurs
        foreach($parameters['to'] as $to) {
           $email = $email->addTo($to);
        }

        // eamil en copie
        if(isset($parameters['cc'])){
            foreach($parameters['cc'] as $cc) {
                $email = $email->addcc($cc);
            }
        }


        // template
        $email = $email->htmlTemplate('emails/'.$parameters['template']);

        // passez les variables
        $email = $email->context(isset($parameters['template_vars']) ? $parameters['template_vars'] : []);

        // piece_jointe
        // $email = $email->attachFromPath(  $this->parameterBag->get('kernel.project_dir')."/public/files/piece-jointe/livret_d_accueil_formation_officielle_entreprendre_en_2022.pdf", null)  


        //try{
            $this->mailer->send($email);
        //} catch (TransportExceptionInterface $e) {
            // some error prevented the email sending; display an
            // error message or try to resend the message
        //     echo 'erreur : '.$e->getMessage();
        //}


    }

    //    private $exempleParametre = [
//        'from' => 'xx@gmail.com',
//        'from_name' => 'nomena',
//        'to' => [
//            'qdsf@dsf',
//            'qdsk@qsdf'
//        ],
//        'cc' => [
//            'qsmldkfj@qdsf'
//        ],
//        'template' => 'qkdjfmdsjf.html.twig',
//        'template_vars' => [
//            'variable1' => 'valeur'
//        ]
//
//    ];

    public function mySendMail(array $mail, array $attachmentsPath = [], ?string $to = null, array $embeddedImages = [])
    {
        $email = (new Email())
            ->from(new Address($this->from, $this->from_name))
            ->subject($mail['subject'])
            ->html($mail['body']);

        $to = $to === null ? $mail['to'] : $to;    
        if(gettype($to) == "array"){
            $email = $email->to(...$to);
        } else {
            $email = $email->to($to);
        }

        foreach($attachmentsPath as $path){
            $email->attachFromPath($this->parameterBag->get('kernel.project_dir')."/public/files/".$path);
        }

        foreach($embeddedImages as $key => $value){
            $email->embedFromPath($this->parameterBag->get('kernel.project_dir')."/public/".$value, $key);
        }
        $this->mailer->send($email);
    }

    public function renderTwig($filePath, $options = []){
        return $this->twig->render($filePath, $options);
    }

    public function sendFactureProduit(Order $order){
        
        $body = $this->renderTwig('emails/commande.html.twig', [
            'nomClient' => $order->getAddress()->getNom(),
            'prenomClient' => $order->getAddress()->getPrenom(),
            'order' => $order
        ]);

        $attachmentsPath = [$order->getInvoicePath()];
        $embeddedImages = ['logo' => 'assets/img/logo/greenlife/greenlife.png'];
        $this->mySendMail([
            'subject' => 'Confirmation de commande '.$order->getId(),
            'to' => $order->getAddress()->getEmail(),
            'body' => $body
        ], $attachmentsPath, null, $embeddedImages);

        $bodyMailToAdmin = $this->renderTwig('emails/commande_details.html.twig', [
            'order' => $order
        ]);
        $MailToAdmin = [
            'body' => $bodyMailToAdmin,
            'subject' => "Commande coffret  n°{$order->getId()}",
            'to' => $order->getAgent()->getEmail()
        ];

        $this->mySendMail($MailToAdmin, $attachmentsPath, null, $embeddedImages);

    }

    public function sendFactureSecu(OrderSecu $order){
        
        $body = $this->renderTwig('emails/commande_secu.html.twig', [
            'nomClient' => $order->getClient()->getNom(),
            'prenomClient' => $order->getClient()->getPrenom(),
            'order' => $order
        ]);

        $attachmentsPath = [$order->getInvoicePath(), $order->getContratSigned()];
        $embeddedImages = ['logo' => 'assets/img/logo/greenlife/greenlife.png'];
        $this->mySendMail([
            'subject' => 'Confirmation de commande '.$order->getId(),
            'to' => $order->getClient()->getEmail(),
            'body' => $body
        ], $attachmentsPath, null, $embeddedImages);

        $bodyMailToAdmin = $this->renderTwig('emails/commande_details_secu.html.twig', [
            'order' => $order
        ]);
        $MailToAdmin = [
            'body' => $bodyMailToAdmin,
            'subject' => "Commande n°{$order->getId()}",
            'to' => $order->getAgent()->getEmail()
        ];

        $this->mySendMail($MailToAdmin, $attachmentsPath, null, $embeddedImages);

    }

    public function sendFactureAroma(OrderAroma $order){
        
        $body = $this->renderTwig('emails/commande_aroma.html.twig', [
            'nomClient' => $order->getAddress()->getLastname(),
            'prenomClient' => $order->getAddress()->getFirstname(),
            'order' => $order
        ]);

        $attachmentsPath = [$order->getInvoicePath()];
        $embeddedImages = ['logo' => 'assets/img/home/af_logo_d2-min.png'];
        $this->mySendMail([
            'subject' => 'Confirmation de commande '.$order->getId(),
            'to' => $order->getAddress()->getMail(),
            'body' => $body
        ], $attachmentsPath, null, $embeddedImages);

        $bodyMailToAdmin = $this->renderTwig('emails/commande_details_aroma.html.twig', [
            'order' => $order
        ]);
        $MailToAdmin = [
            'body' => $bodyMailToAdmin,
            'subject' => "Commande n°{$order->getId()}",
            'to' => $order->getAgent()->getEmail()
        ];

        $this->mySendMail($MailToAdmin, $attachmentsPath, null, $embeddedImages);

    }

    public function sendDeliveryOrder(OrderAroma $order){

        $body = $this->renderTwig('emails/livraison_aroma.html.twig', [
            'nomClient' => $order->getAddress()->getLastname(),
            'prenomClient' => $order->getAddress()->getFirstname(),
            'order' => $order
        ]);

        $attachmentsPath = [$order->getDeliveryOrderPath()];
        $embeddedImages = ['logo' => 'assets/img/home/af_logo_d2-min.png'];
        $this->mySendMail([
            'subject' => 'Livraison de commande '.$order->getId(),
            'to' => $order->getAddress()->getMail(),
            'body' => $body
        ], $attachmentsPath, null, $embeddedImages);

    }

    public function sendFactureDevisCompanyDigital(DevisCompany $devisCompany){
        
        $body = $this->renderTwig('emails/commande_devis_company_digital.html.twig', [
            'prenomClient' => $devisCompany->getClientLastname(),
            'devisCompany' => $devisCompany
        ]);

        $attachmentsPath = [$devisCompany->getPjFilename()];
        $embeddedImages = ['logo' => 'assets/img/logo/greenlife/greenlife.png'];
        $this->mySendMail([
            'subject' => 'Confirmation du devis '.$devisCompany->getId(),
            'to' => $devisCompany->getClientMail(),
            'body' => $body
        ], $attachmentsPath, null, $embeddedImages);

        $bodyMailToAdmin = $this->renderTwig('emails/commande_details_devis_company_digital.html.twig', [
            'devisCompany' => $devisCompany
        ]);
        $MailToAdmin = [
            'body' => $bodyMailToAdmin,
            'subject' => "Devis n°{$devisCompany->getId()}",
            'to' => $devisCompany->getAgent()->getEmail()
        ];

        $this->mySendMail($MailToAdmin, $attachmentsPath, null, $embeddedImages);

    }

    public function sendFactureOrderDigital(OrderDigital $order){
        
        $body = $this->renderTwig('emails/commande_digital.html.twig', [
            'prenomClient' => $order->getDevis()->getDemandeDevis()->getPrenom(),
            'order' => $order
        ]);

        $attachmentsPath = [$order->getInvoicePath(), $order->getDevis()->getContratFileName()];
        $embeddedImages = ['logo' => 'assets/img/logo/greenlife/greenlife.png'];
        $this->mySendMail([
            'subject' => 'Confirmation de la commande '.$order->getId(),
            'to' => $order->getDevis()->getDemandeDevis()->getEmail(),
            'body' => $body
        ], $attachmentsPath, null, $embeddedImages);

        $bodyMailToAdmin = $this->renderTwig('emails/commande_details_digital.html.twig', [
            'order' => $order
        ]);
        $MailToAdmin = [
            'body' => $bodyMailToAdmin,
            'subject' => "Commande n°{$order->getId()}",
            'to' => $order->getAgent()->getEmail()
        ];

        $this->mySendMail($MailToAdmin, $attachmentsPath, null, $embeddedImages);

    }

}
