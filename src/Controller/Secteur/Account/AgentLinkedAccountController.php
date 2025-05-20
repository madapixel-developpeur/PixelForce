<?php


namespace App\Controller\Secteur\Account;

use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\UserOTP;
use App\Entity\AgentSecteur;
use App\Services\LpnService;
use App\Services\OtpService;
use App\Services\AuthService;
use App\Util\Search\Constants;
use App\Exception\CustomException;
use App\Repository\SecteurRepository;
use App\Form\LpnSupportDocumentFormType;
use App\Form\LpnResellerContractFormType;
use App\Form\SignUpLittlePonailsFormType;
use App\Form\SingUpLittlePonailsFormType;
use App\Form\UpdateLittlePonailsFormType;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
        private LpnService $LpnService
    ) {}

    #[Route('/verifier-compte', name: 'agent_check_platform_secteur_account')]
    public function check(Request $request): Response
    {
        $user = $this->getUser();
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
                $linkedAccountInfo = $this->authService->linkAccountInfo($user, $secteur, $identifier);
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
        return $this->render('user_category/agent/secteur/check_existing_account.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/nouveau-compte', name: 'agent_create_platform_secteur_account')]
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

                $files = $this->getFilesDataToSendApi($request, [
                    'supporting_documents',
                    'kbis',
                    'carte_vitale',
                    'siren_vdi',
                ]);
                $data['sponsor'] =  $_ENV['LITTLE_PONAILS_DEFAULT_SPONSOR'];
                $data['provider'] = Constants::LPN_PIXELFORCE_PROVIDER;
                $multipart = array_merge($data, $files);

                $this->authService->createLittlePonailsAccount($this->getUser(), $secteur, $multipart);
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

        return $this->render('user_category/agent/secteur/create_account.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/little-ponails/modifier-compte', name: 'agent_update_platform_secteur_account')]
    public function updateAccount(Request $request): Response
    {
        $user = $this->getUser();
        $needCredentials = $this->session->get('lpn_token') ? false : true;


        $form = $this->createForm(UpdateLittlePonailsFormType::class, [], [
            'need_credentials' =>  $needCredentials
        ]);
        $secteur_id = $this->session->get('secteurId');
        $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);
        $littlePonailsAgentSecteur = $user->getAgentSecteurById($secteur_id);
        $agentInfoFromLpn = $this->authService->getAccountStatusFromLpn($littlePonailsAgentSecteur);

        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {
            try {
                $data = $form->getData();
                $files = $this->getFilesDataToSendApi($request, [
                    'identity',
                    'kbis'
                ], 'update_little_ponails_form');
                $this->authService->sendSupportingDocuments($this->getUser(), $data, $files);
                $this->addFlash(
                    'success',
                    $this->translator->trans("Vos documents ont été envoyés avec succès.")
                );
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

        return $this->render('user_category/agent/secteur/LPN/update_account.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(),
            'needCredentials' => $needCredentials,
            'littlePonailsAgentSecteur' => $littlePonailsAgentSecteur,
            'agentInfoFromLpn' => $agentInfoFromLpn
        ]);
    }

    #[Route('/little-ponails/contrat-revendeur', name: 'agent_lpn_sign_reseller_contract')]
    public function signLpnContract(Request $request): Response
    {
        $user = $this->getUser();
        $secteur_id = $this->session->get('secteurId');
        try {
            $lpnBoxs = $this->LpnService->getBoxList();
        } catch (CustomException $e) {
            $this->addFlash(
                'danger',
                $e->getMessage()
            );
            return $this->redirectToRoute('agent_lpn_get_access',['nextStep' => 1 ]);
        } catch (\Exception $e) {
            $this->addFlash(
                'danger',
                $_ENV['CUSTOM_ERROR_MESSAGE']
            );
            return $this->redirectToRoute('agent_update_platform_secteur_account');
        }


        $form = $this->createForm(LpnResellerContractFormType::class, [], [
            'user' => $user,
            'lpnBoxs' => $lpnBoxs
        ]);

        $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);
        $form->handleRequest($request);

        if ($form->isSubmitted()  && $form->isValid()) {
            $tempFilePath = '';
            try {
                $data = $form->getData();
                $data['legal_status'] =  Constants::DEFAULT_LPN_LEGAL_STATUS;
                $data['box'] = (string) $data['box'];
                $result = $this->getPreparedSignatureToSendToApi($request->request->get('signatureData'));
                $data = array_merge($data,$result['signatureData']);
                $tempFilePath = $result['tempFilePath'];
                $this->authService->saveAgentContract($this->getUser(),$data);
                $this->addFlash(
                    'success',
                    $this->translator->trans("Votre signature et vos informations ont été envoyées avec succès.")
                );
                return $this->redirectToRoute('agent_update_platform_secteur_account');
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
            }finally{
                if($tempFilePath){
                    @unlink($tempFilePath);
                }
            }
        }

        return $this->render('user_category/agent/secteur/LPN/sign_contract.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }

    #[Route('/little-ponails/verification/{nextStep}', name: 'agent_lpn_get_access')]
    public function getLpnCredential(Request $request, int $nextStep = 0)
    {
        $user = $this->getUser();
        $littlePonailsAgentSecteur = $user->getAgentSecteurById($_ENV['SECTEUR_LITTLE_PONAILS_ID']);
        $form = $this->createFormBuilder()
            ->add('username', TextType::class, [
                'label' => $this->translator->trans('Nom d’utilisateur'),
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => true,
                ],
                'data' => $littlePonailsAgentSecteur->getSectorPlatformUsername()
            ])
            ->add('password', PasswordType::class, [
                'label' => $this->translator->trans('Mot de passe'),
                'attr' => ['class' => 'form-control']
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $data = $form->getData();
                $this->authService->getAccessToLpn($user, $data);
                $this->addFlash(
                    'success',
                    $this->translator->trans('Accès Little Ponails vérifier avec succès')
                );
                if($nextStep == 0){
                    return $this->redirectToRoute('agent_update_platform_secteur_account');
                }
                if($nextStep == 1){
                    return $this->redirectToRoute('agent_lpn_supporting_documents_add');
                }else{
                    return $this->redirectToRoute('agent_lpn_sign_reseller_contract');
                }

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

        return $this->render('security/LPN/lpn_access_credentials.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/little-ponails/supporting-documents/delete/{id}', name: 'agent_lpn_supporting_documents_delete', methods:['POST'])]
    public function deleteSupportingDocuments(Request $request,string $id): Response
    {
        try{
            $this->LpnService->deleteSupportingDocument($id);
            $this->addFlash(
                'success',
                $this->translator->trans('Document supprimé avec succès')
            );
        }
        catch(\Exception $ex){
            $this->addFlash(
                'danger',
                $_ENV['CUSTOM_ERROR_MESSAGE']
            );
        }
        return $this->redirectToRoute('agent_update_platform_secteur_account');
    }

    #[Route('/little-ponails/supporting-documents/details/{id}', name: 'agent_lpn_supporting_documents_details')]
    public function viewSupportingDocuments(Request $request,string $id): Response
    {
        try{
            $this->LpnService->deleteSupportingDocument($id);
            $this->addFlash(
                'success',
                $this->translator->trans('Document supprimé avec succès')
            );
        }
        catch(\Exception $ex){
            $this->addFlash(
                'danger',
                $_ENV['CUSTOM_ERROR_MESSAGE']
            );
        }
        return $this->redirectToRoute('agent_update_platform_secteur_account');
    }

    #[Route('/little-ponails/supporting-documents/ajout', name: 'agent_lpn_supporting_documents_add')]
    public function sendSupportingDocuments(Request $request): Response
    {
        $form = $this->createForm(LpnSupportDocumentFormType::class, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $data = $form->getData();
                $files = $this->getFilesDataToSendApi($request, [
                    'file_support',
                ], 'lpn_support_document_form');
                $dataFiles = [];
                $dataFiles[$data['document_type']] = $files['file_support'];
                $this->authService->sendSupportingDocuments($this->getUser(), [], $dataFiles);
                $this->addFlash(
                    'success',
                    $this->translator->trans('Document envoyé avec succès')
                );
                return $this->redirectToRoute('agent_update_platform_secteur_account');
          
            } catch (CustomException $e) {
                $this->addFlash(
                    'danger',
                    $e->getMessage()
                );
             } catch(\Exception $ex){
                $this->addFlash(
                    'danger',
                    $_ENV['CUSTOM_ERROR_MESSAGE']
                );
            }
        }
        return $this->render('user_category/agent/secteur/LPN/add_support_document.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }


    public function getFilesDataToSendApi(Request $request, array $keys, $form_name = 'sign_up_little_ponails_form')
    {
        $multipart = [];
        $filesData = $request->files->all()[$form_name];
        foreach ($keys as $key) {
            $documents = $filesData[$key];
            if (!$documents) continue;

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


    public function getPreparedSignatureToSendToApi($signatureData)
    {
        $tempFilePath = '';
        try {
            if ($signatureData && str_starts_with($signatureData, 'data:image')) {
                [$meta, $data] = explode(',', $signatureData);
                $decoded = base64_decode($data);

                // Extract MIME type and extension
                preg_match('/data:image\/(.*?);base64/', $meta, $matches);
                $extension = $matches[1] ?? 'png';
                $mimeType = 'image/' . $extension;

                // Save to temp file
                $tempPath = tempnam(sys_get_temp_dir(), 'sig_');
                file_put_contents($tempPath, $decoded);
                $tempFiles[] = $tempPath;

                // Create DataPart
                $signaturePart = new DataPart(
                    fopen($tempPath, 'r'),
                    'signature.' . $extension,
                    $mimeType
                );

                $parts['signature'] = $signaturePart;
                return [
                    'tempFilePath' => $tempFilePath,
                    'signatureData' => $parts
                ];
            } else {
                throw new CustomException($this->translator->trans('Veuillez fournir une signature'));
            }
        } catch (\Throwable $th) {
            throw $th;
        } finally { 
            if(!empty($tempFilePath)){
                @unlink($tempFilePath);
            }
        }
    }


   
}
