<?php


namespace App\Controller\Secteur\Account;

use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\UserOTP;
use App\Services\OtpService;
use App\Services\AuthService;
use App\Util\Search\Constants;
use App\Exception\CustomException;
use App\Repository\SecteurRepository;
use App\Form\SignUpLittlePonailsFormType;
use App\Form\SingUpLittlePonailsFormType;
use App\Form\UpdateLittlePonailsFormType;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/agent/compte-associe')]
class AgentLinkedAccountController extends AbstractController
{

    public function __construct(
        private SecteurRepository $secteurRepository,
        private SessionInterface $session,
        private AuthService $authService,
        private OtpService $otpService,
        private TranslatorInterface $translator,
    ) {

    }

    #[Route('/verifier-compte',name : 'agent_check_platform_secteur_account')]
    public function check(Request $request): Response
    {   
        $user =$this->getUser();
        $secteur_id = $this->session->get('secteurId');
        $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);

        $form = $this->createFormBuilder()
            ->add('identifier', EmailType::class, [
                'label' => 'Email',
                'required' => true,
            ])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $identifier = $form->get('identifier')->getData();
                if (!$identifier) {
                    throw new CUstomException($this->translator->trans('Identifiant obligatoire.'));
                }
                // $this->authService->linkAccount($user,$secteur,$identifier);
                $linkedAccountInfo = $this->authService->linkAccountInfo($user,$secteur,$identifier);
                $this->otpService->setLinkedAccountInfo($linkedAccountInfo);
                $this->otpService->sendOtp(null, $identifier, UserOTP::LINKED_ACCOUNT_CONFIRMATION);
                return $this->redirectToRoute('app_otp_home', ['operationType' => UserOTP::LINKED_ACCOUNT_CONFIRMATION]);

                $this->addFlash('success', $this->translator->trans('Compte relié avec succès.')); 
                return $this->redirectToRoute('agent_dashboard_secteur', ['id' =>  $secteur_id]);
            } catch (CustomException $e) {
                $this->addFlash(
                    'danger',
                    $e->getMessage()
                );
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    $_ENV['CUSTOM_ERROR_MESSAGE']
                );
            }
        }
        return $this->render('user_category/agent/secteur/check_existing_account.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    #[Route('/nouveau-compte',name : 'agent_create_platform_secteur_account')]
    public function createAccount(Request $request): Response
    {   
        $form = $this->createForm(SignUpLittlePonailsFormType::class, []);
        $secteur_id = $this->session->get('secteurId');
        $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);


        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {
            try {
                $data = $form->getData();
                $data = array_map(fn($v) => $v === null ? '' : $v, $data);
                $multipart = [];
                foreach ($data as $key => $value) {
                    $multipart[] = 
                    [
                        'name' => $key,
                        'contents' => $value ?? ''
                    ];
                }

                $files = $this->getFilesDataToSendApi($request,[
                    'supporting_documents',
                    'kbis',
                    'carte_vitale',
                    'siren_vdi',
                ]);
                $data['sponsor'] =  $_ENV['LITTLE_PONAILS_DEFAULT_SPONSOR'];
                $data['provider'] = Constants::LPN_PIXELFORCE_PROVIDER;
                $multipart = array_merge($data,$files);
                
                $this->authService->createLittlePonailsAccount($this->getUser(),$secteur,$multipart);
                $this->addFlash('success', $this->translator->trans('Compte relié avec succès.'));
                return $this->redirectToRoute('agent_dashboard_secteur', ['id' =>  $secteur_id]);
            } catch (CustomException $e) {
                $this->addFlash(
                    'danger',
                    $e->getMessage()
                );
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    $_ENV['CUSTOM_ERROR_MESSAGE']
                );
            }
            
        }

        return $this->render('user_category/agent/secteur/create_account.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    #[Route('/modifier-compte',name : 'agent_update_platform_secteur_account')]
    public function updateAccount(Request $request): Response
    {   
        $form = $this->createForm(UpdateLittlePonailsFormType::class, []);
        $secteur_id = $this->session->get('secteurId');
        $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);


        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {
            try {
               
            } catch (CustomException $e) {
                $this->addFlash(
                    'danger',
                    $e->getMessage()
                );
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    $_ENV['CUSTOM_ERROR_MESSAGE']
                );
            }
            
        }

        return $this->render('user_category/agent/secteur/LPN/update_account.html.twig',[
            'form' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }

    public function getFilesDataToSendApi(Request $request , array $keys){
        $multipart = [];
        $filesData = $request->files->all()['sign_up_little_ponails_form'];
        foreach ($keys as $key) {
            $documents = $filesData[$key];
            if(!$documents) continue;
            
            $temp = [];
            foreach ($documents as $index => $doc) {
                $temp[] =   
                new DataPart(
                    fopen($doc->getRealPath(), 'r'),
                    $doc->getClientOriginalName(),
                    $doc->getMimeType()
                );
            }
            $multipart[$key] = $temp;
        }
        return $multipart;
    }

}