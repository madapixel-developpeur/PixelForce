<?php

namespace App\Controller;

use DateTime;
use Exception;
use App\Entity\Retiros;
use App\Entity\UserOTP;
use App\Form\OtpFormType;
use App\Entity\Parameters;
use App\Services\OtpService;
use App\Message\CloturerPack;
use App\Services\MailerService;
use App\Exception\CustomException;
use App\Repository\UserRepository;
use App\Repository\UserOTPRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/otp')]
class OtpController extends AbstractController
{
    private $entityManager;
    private $authService;


    public function __construct(
        EntityManagerInterface $entityManager, 
        private UserOTPRepository $userOtpRepository,
        private OtpService $otpService,
        private MailerService $mailService,
        private UserRepository $userRepository,
        private TranslatorInterface $translator,
        private SessionInterface $session,
    )
    {
        $this->entityManager = $entityManager;
    }

    
    #[Route('/{operationType}', name: 'app_otp_home')]
    public function index(int $operationType, Request $request): Response
    {
        $email = null;
        if ($operationType == UserOTP::LINKED_ACCOUNT_CONFIRMATION ) {
            $email = $this->otpService->getEmailOtp();
        }

        $user = (object)$this->getUser();
        if(!$this->isGranted('ROLE_USER')) $user = null;
        $email = $request->getSession()->get('email-otp');

        $form = $this->createForm(OtpFormType::class);
        $form->handleRequest($request);
        


        if ($form->isSubmitted() && $form->isValid()) {

            try{
                
                $userOtp = $this->userOtpRepository->findOtp($operationType, $form->get('otpValue')->getData(), $user, $email);
                if(!$userOtp) throw new CustomException('Code de sécurité invalide');
                
                $userOtp->setStatus(UserOTP::STATUS_INVALID);
                $this->entityManager->persist($userOtp);
                $this->entityManager->flush();

                $response = $this->performOtpOperation($operationType);
                
                return $response;
            } catch (CustomException $ex) {
                $this->addFlash(
                    'danger',
                    $ex->getMessage()
                );
            } catch (Exception $ex) {
                // Gérer toutes les autres exceptions
                $this->addFlash(
                    'danger',
                   $_ENV['CUSTOM_ERROR_MESSAGE']
                );
            }
            
        }


        return $this->render('otp/otp.html.twig',[
            'form' => $form->createView(),
            'operationType' => $operationType
        ]);
    }

    private function performOtpOperation($operationType){
        $user = (object)$this->getUser();
        if($operationType == UserOTP::LINKED_ACCOUNT_CONFIRMATION){
            $secteurId = $this->session->get('secteurId');
            try {
                $linkedAccountInfo = $this->otpService->getLinkedAccountInfo()['data'];
                $agentSecteur = $user->getAgentSecteurById($secteurId);
                $agentSecteur->setSectorPlatformAccountId($linkedAccountInfo['id']);
                $agentSecteur->setSectorPlatformUsername($linkedAccountInfo['identifier']);
                $agentSecteur->setSectorPlatformAgentUsername($linkedAccountInfo['agentUsername']);
                $this->entityManager->persist($agentSecteur);
                $this->entityManager->flush();
    
                $this->otpService->removeEmailOtp();
                $this->addFlash('success', 'Compte relié avec succès.'); 
            } catch (\Throwable $th) {
                //throw $th;
                $this->addFlash('danger',$_ENV['CUSTOM_ERROR_MESSAGE']); 

            }
            return $this->redirectToRoute('agent_dashboard_secteur', ['id' =>  $secteurId]);
           

        } 

        return $this->redirectToRoute('app_otp_home', ['operationType' => $operationType]);
    }
    
    #[Route('/{operationType}/resend', name: 'app_otp_resend_code',methods: ['POST'])]
    public function resendCode(int $operationType, Request $request): Response
    {
        $email = null;
        try{
            if ($operationType == UserOTP::LINKED_ACCOUNT_CONFIRMATION ) {
                $email = $this->otpService->getEmailOtp();
            }
            $user = (object)$this->getUser();
            $this->otpService->sendOtp($email ? null : $user, $email, $operationType);
            $this->addFlash(
                'success',
                $this->translator->trans('Code renvoyé')
            ); 
        } 
        catch (CustomException $ex) {
            $this->addFlash(
                'danger',
                $this->translator->trans($ex->getMessage())
            );
        } catch (Exception $ex) {
            // Gérer toutes les autres exceptions
            $this->addFlash(
                'danger',
                $this->translator->trans($_ENV['CUSTOM_ERROR_MESSAGE'])
            );
        }
        return $this->redirectToRoute('app_otp_home', ['operationType' => $operationType]);
    }
}