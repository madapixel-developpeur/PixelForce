<?php

namespace App\Services;

use DateTime;
use Exception;
use DateInterval;
use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\AgentSecteur;
use App\Entity\ForgotPassword;
use App\Util\Search\Constants;
use App\Entity\AccountValidation;
use App\Exception\CustomException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AgentSecteurRepository;
use App\Repository\ForgotPasswordRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AccountValidationRepository;
use App\Repository\CategorieFormationRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService 
{
    private $entityManager;
    private $userRepository;
    private $forgotPasswordRepository;
    private $passwordHasher;
    private $validator;
    private $accountValidationRepository;
    private $mailerService;

    public function __construct(
        EntityManagerInterface $entityManager, 
        UserRepository $userRepository, 
        UserPasswordHasherInterface $passwordHasher, 
        ValidatorInterface $validator,
        AccountValidationRepository $accountValidationRepository,
        MailerService $mailerService,
        private CategorieFormationRepository $categorieFormationRepository,
        private AgentSecteurRepository $agentSecteurRepository,
        private HttpClientInterface $client,
        private SessionInterface $session,
        private TranslatorInterface $translator,
    )
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->validator = $validator;
        $this->accountValidationRepository = $accountValidationRepository;
        $this->mailerService = $mailerService;
    }

    public function getAccessibleFonctionnalites(User $user, $secteurId){
        if(!$user->getAccessibleFonctionnalites($secteurId)){
            $agentSecteur = $this->agentSecteurRepository->findOneBy(["agent" => $user, "secteur" => $secteurId]);
            if($agentSecteur) $user->setAccessibleFonctionnalites($secteurId, $this->categorieFormationRepository->getAccessibleFonctionnalites($agentSecteur->getCurrentFormationRank()));
        }
        return $user->getAccessibleFonctionnalites($secteurId);
    }

    public function checkNewAccount(User $user): User
    {
        $password = $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $user->setCreatedAt(new DateTime());
        $user->setActive(true);
        $user->setRoles(["ROLE_CLIENT"]);

        $errors = $this->validator->validate($user);

        if(count($errors) > 0){
            throw new Exception($errors->get(0)->getMessage());
        }

        
        $code =  $this->generateRandomNDigits(8);   
        $dateExpiration = new DateTime();
        $dateExpiration->add(new DateInterval('PT1H'));
        
        $accountValidation = new AccountValidation();
        $accountValidation->setMail($user->getEmail());
        $accountValidation->setVerifCode(sha1($code));
        $accountValidation->setDateExpiration($dateExpiration);
        $accountValidation->setStatus(1);
        
        $this->entityManager->persist($accountValidation);
        $this->entityManager->flush();

        $this->mailerService->sendVerifCodeToClient($user, $code, $dateExpiration);
        return $user;
    }

    public function validateAccount(User $user, $verifCode)
    {

        $accountValidation = $this->accountValidationRepository->getValidAccountValidation($user->getEmail(), $verifCode);
        if($accountValidation == null) 
            throw new Exception("Code de vérification invalide");

        $errors = $this->validator->validate($user);
        if(count($errors) > 0){
            throw new Exception($errors->get(0)->getMessage());
        }    

        $accountValidation->setStatus(0);
        
        $this->entityManager->persist($user);
        $this->entityManager->persist($accountValidation);
        $this->entityManager->flush();
    }


    public function generateRandomNDigits(int $n){
        $code = "";
        for($i=0; $i<$n; $i++){
            $code .= rand(0, 9);
        }
        return $code;
    }

    public function getLinkedAccountInfo(string $identifier){
        $LPN_BACK_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
        try{

            $response = $this->client->request(
                'GET',
                $LPN_BACK_URL . '/api/auth/check-existing-account',
                [
                    'json' =>   ['email' => $identifier ]
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (HttpExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === 422) {
                $content = json_decode($e->getResponse()->getContent(false), true);
                throw new CustomException($content['message']);
            }
            throw $e; 
        } catch (\Throwable $th) {
            throw $th;
        }
       
    }

    public function createLittlePonailsAccountFromApi(array $data){
        $LPN_BACK_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
        try{
            $formData = new FormDataPart($data);
            $response = $this->client->request(
                'POST',
                $LPN_BACK_URL . '/api/auth/register-end-point',
                [
                    'headers' => $formData->getPreparedHeaders()->toArray(),
                    'body' => $formData->bodyToIterable(),
                ]
            );

            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (HttpExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === 422 || $statusCode === 400) {
                $content = json_decode($e->getResponse()->getContent(false), true);
                throw new CustomException($content['message']);
            }
            throw $e; 
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function linkAccountInfo(User $user,Secteur $secteur,string $identifier){
        if($secteur->getId() != $_ENV['SECTEUR_LITTLE_PONAILS_ID']){
            throw new CustomException('Secteur non prise en charge');
        }
        $accountInfo = $this->getLinkedAccountInfo($identifier);
        if(empty($accountInfo)){
            throw new CustomException("Aucun compte avec l'identifiant \"$identifier\" n'a été identifié.");
        }
        return $accountInfo;
    }


    public function createLittlePonailsAccount(User $user,Secteur $secteur,array $data){
        if($secteur->getId() != $_ENV['SECTEUR_LITTLE_PONAILS_ID']){
            throw new CustomException('Secteur non prise en charge');
        }
        $accountInfo = $this->createLittlePonailsAccountFromApi($data);
        $agentSecteur = $user->getAgentSecteurById($secteur?->getId());
        $agentSecteur->setSectorPlatformAccountId($accountInfo['id']);
        $agentSecteur->setSectorPlatformUsername($accountInfo['identifier']);
        $agentSecteur->setSectorPlatformAgentUsername($accountInfo['agentUsername']);
        $this->entityManager->persist($agentSecteur);
        $this->entityManager->flush();
    }

    public function setUsernameFromLPN(AgentSecteur $agentSecteur){
        if($agentSecteur->getSecteur()?->getId() != $_ENV['SECTEUR_LITTLE_PONAILS_ID']){
            throw new CustomException('Secteur non prise en charge');
        }
        if($agentSecteur->getSectorPlatformAgentUsername()){
            return;
        }
        $accountInfo = $this->getLinkedAccountInfo($agentSecteur->getSectorPlatformUsername());
        if($accountInfo){
            $agentSecteur->setSectorPlatformAgentUsername($accountInfo['agentUsername']);
            $this->entityManager->persist($agentSecteur);
            $this->entityManager->flush();
        }
    }

    public function getUsernameOfSponsorInLpn(User $user){
        $parrain = $user->getParrain();
        $lpnAgentSecteurInfo = $parrain?->getAgentSecteurById($_ENV['SECTEUR_LITTLE_PONAILS_ID']);
        return (!$parrain || !$lpnAgentSecteurInfo || !$lpnAgentSecteurInfo->getSectorPlatformAgentUsername()) ? null : $lpnAgentSecteurInfo->getSectorPlatformAgentUsername();
    }


    public function updateAgentSponsorFromLpnApi(User $user,$data,$token){
        $LPN_BACK_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
        try{
            $response = $this->client->request(
                'POST',
                $LPN_BACK_URL . '/api/mlm/agent/update-children-sponsor',
                [
                    'headers' =>
                        ['Authorization' => 'Bearer ' . $token ]
                    ,
                    'json' => $data
                ]
            );

            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (HttpExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === 422 || $statusCode === 400) {
                $content = json_decode($e->getResponse()->getContent(false), true);
                throw new CustomException($content['message']);
            }
            if ($statusCode === 401) {
                $this->session->remove('lpn_token');
                throw new CustomException($this->translator->trans("Veuillez retaper votre mot de passe Little Ponails, s'il vous plaît."));
            }
            throw $e; 
        } catch (\Throwable $th) {
            throw $th;
        }      
    }


    public function updateDirectChildrenSponsorInLpn(User $user,$info){
        $this->entityManager->refresh($user); 
        $data=[];
        $lpnInfoOfDirectChildren = $this->agentSecteurRepository->getLpnInfoOfDirectChildrenByParrainId([$user->getId()]);
        $lpnIdentifications = array_map(function($data){
            return $data->getSectorPlatformUsername();
        }, $lpnInfoOfDirectChildren);
        $data['directChildrenIdentification'] = $lpnIdentifications ;
        $token = (isset($info['token'])) ? $info['token'] : $this->session->get('lpn_token','');
        $agentSecteurLpn = $user->getAgentSecteurById($_ENV['SECTEUR_LITTLE_PONAILS_ID']);

        $this->updateAgentSponsorFromLpnApi($user,$data,$token);
        $agentSecteurLpn->setChildrenSonporBeenChanged(true);
        $this->entityManager->persist($agentSecteurLpn);
        $this->entityManager->flush();
    }

    public function createLpnAccountFromPixelForceInfo(User $user){

        $data = [
            'firstnames' => $user->getPrenom(),
            'lastname'=> $user->getNom(),
            'username'=> $user->getUsername(),
            'email'=> $user->getEmail(),
            'legal_status'=> Constants::DEFAULT_LPN_LEGAL_STATUS,
            'sponsor'=> $_ENV['LITTLE_PONAILS_DEFAULT_SPONSOR'],
            'provider'=> Constants::LPN_PIXELFORCE_PROVIDER,
            'password'=> Constants::DEFAULT_LPN_PASSWORD 
        ];
        $usernameOfSponsorInLpn = $this->getUsernameOfSponsorInLpn($user);
        if($usernameOfSponsorInLpn){
            $data['sponsor'] = $usernameOfSponsorInLpn;
        }
        $info = $this->createLittlePonailsAccountFromApi($data);
        $this->updateDirectChildrenSponsorInLpn($user,$info);
        return $info;
        
    }

    public function checkAndCreateAccountLpn(User $user,?AgentSecteur $agentSecteur = null){
        try {
            $agentSecteur = $agentSecteur ??  $user->getAgentSecteurById($_ENV['SECTEUR_LITTLE_PONAILS_ID']);
            if(!$agentSecteur || $agentSecteur?->getSectorPlatformUsername()){
                return;
            }
            try {
                $accountInfo = $this->getLinkedAccountInfo($user->getEmail());   
            } catch (CustomException $th) {
                $accountInfo = $this->createLpnAccountFromPixelForceInfo($user);
            }catch (\Throwable $th) {
                throw $th;
            }
            
            if(!$accountInfo){
                throw new Exception();
            }
            $agentSecteur->setSectorPlatformAccountId($accountInfo['id']);
            $agentSecteur->setSectorPlatformUsername($accountInfo['identifier']);
            $agentSecteur->setSectorPlatformAgentUsername($accountInfo['agentUsername']);
            $this->entityManager->persist($agentSecteur);
            $this->entityManager->flush();
        }catch (\Throwable $th) {
            throw $th;
        }

    }

    public function getLoginToken(User $user,$data,$isBackgroundOperation = false){
        if($this->session->get('lpn_token')){
            return $this->session->get('lpn_token');
        }
        $LPN_BACK_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];

        if(!$isBackgroundOperation){
            $agentSecteur = $user->getAgentSecteurById($_ENV['SECTEUR_LITTLE_PONAILS_ID']);
            if(!$agentSecteur){
                throw new CustomException($this->translator->trans('Veuillez vous inscrire sur Little Ponails'));
            }

            if(!isset($data['password'])){
                throw new CustomException($this->translator->trans('Veuillez vous connecter à Little Ponails'));
            }

            $credentials =   [
                'password' => $data['password'],
                'username' => $agentSecteur->getSectorPlatformUsername(),
            ];
        }else{
              $credentials =   [
                'password' => $data['password'],
                'username' => $data['username'],
            ];
        }
        try{
            $response = $this->client->request(
                'GET',
                $LPN_BACK_URL . '/api/auth/login',
                [
                    'json' => $credentials
                ]
            );

            $content = json_decode($response->getContent(), true);
            $this->session->set('lpn_token', $content['token']);
            return $content['token'];
        } catch (HttpExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === Response::HTTP_UNAUTHORIZED ) {
                $content = json_decode($e->getResponse()->getContent(false), true);
                throw new CustomException($content['message']);
            }
            throw $e; 
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function sendSupportingDocumentsToLpn(User $user,$files,$token){
        $LPN_BACK_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
        try{
            $formData = new FormDataPart($files);
            $response = $this->client->request(
                'POST',
                $LPN_BACK_URL . '/api/mlm/supporting_documents',
                [
                    'headers' => array_merge(
                        $formData->getPreparedHeaders()->toArray(),
                        ['Authorization' => 'Bearer ' . $token]
                    ),
                    'body' => $formData->bodyToIterable(),
                ]
            );

            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (HttpExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === 422 || $statusCode === 400) {
                $content = json_decode($e->getResponse()->getContent(false), true);
                throw new CustomException($content['message']);
            }
            if ($statusCode === 401) {
                $this->session->remove('lpn_token');
                throw new CustomException($this->translator->trans("Veuillez retaper votre mot de passe Little Ponails, s'il vous plaît."));
            }
            throw $e; 
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function sendSupportingDocuments(User $user,$info,$documentArray){
        try {
            $token = $this->getLoginToken($user,$info);
            $allowedDocumentType = ['identity', 'kbis', 'carte_vitale' , 'siren_vdi'];
            foreach($documentArray as $key => $value){
                if(!in_array($key,$allowedDocumentType)){
                    throw new CustomException($this->translator->trans('Type de document non prise en charge'));
                } 
                $infoToSend = [
                    'supporting_document_file_type' =>  $key,
                    'supporting_documents' => $value
                ];
                $this->sendSupportingDocumentsToLpn($user,$infoToSend,$token);
            }
            $agentSecteur = $user->getAgentSecteurById($_ENV['SECTEUR_LITTLE_PONAILS_ID']);
            if($agentSecteur){
               $agentSecteur->setSectorPlatformDocumentState(AgentSecteur::DOCUMENT_SENT);
               $this->entityManager->persist($agentSecteur);
               $this->entityManager->flush();
            }
            // $this->session->remove('lpn_token');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAccessToLpn(User $user,$info){
        try {
            $token = $this->getLoginToken($user,$info);
            $littlePonailsAgentSecteur = $user->getAgentSecteurById($_ENV['SECTEUR_LITTLE_PONAILS_ID']);
            if(!$littlePonailsAgentSecteur->getChildrenSonporBeenChanged()){
                $this->updateDirectChildrenSponsorInLpn($user,['token' => $token]);
            }
            return $token; 
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function saveContractToLpn(User $user,$data,$token){
        $LPN_BACK_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
        try{
            $formData = new FormDataPart($data);
            $response = $this->client->request(
                'POST',
                $LPN_BACK_URL . '/api/mlm/agent/contracts',
                [
                    'headers' => array_merge(
                        $formData->getPreparedHeaders()->toArray(),
                        ['Authorization' => 'Bearer ' . $token]
                    ),
                    'body' => $formData->bodyToIterable(),
                ]
            );

            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (HttpExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === 422 || $statusCode === 400) {
                $content = json_decode($e->getResponse()->getContent(false), true);
                throw new CustomException($content['message']);
            }
            if ($statusCode === 401) {
                $this->session->remove('lpn_token');
                throw new CustomException($this->translator->trans("Veuillez retaper votre mot de passe Little Ponails, s'il vous plaît."));
            }
            throw $e; 
        } catch (\Throwable $th) {
            throw $th;
        }      
    }


    public function saveAgentContract(User $user,$data){
        $token = '';
        if($this->session->get('lpn_token')){
            $token = $this->session->get('lpn_token');
        }else{
            throw new CustomException($this->translator->trans("Veuillez retaper votre mot de passe Little Ponails, s'il vous plaît."));
        }
        $this->saveContractToLpn($user,$data,$token);
        $agentSecteurLpn = $user->getAgentSecteurById($_ENV['SECTEUR_LITTLE_PONAILS_ID']);
        $agentSecteurLpn->setAccountFromPlaformStatus(AgentSecteur::ACCOUNT_WAITING_FOR_VALIDATION);
        $this->entityManager->persist($agentSecteurLpn);
        $this->entityManager->flush();
    }

    public function getAgentInformationFromLpn($token){
        $LPN_BACK_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
        try{
            $response = $this->client->request(
                'GET',
                $LPN_BACK_URL . '/api/mlm/agent',
                [
                    'headers' =>  ['Authorization' => 'Bearer ' . $token]
                    
                ]
            );

            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (HttpExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === 422 || $statusCode === 400) {
                $content = json_decode($e->getResponse()->getContent(false), true);
                throw new CustomException($content['message']);
            }
            if ($statusCode === 401) {
                $this->session->remove('lpn_token');
                throw new CustomException($this->translator->trans("Veuillez retaper votre mot de passe Little Ponails, s'il vous plaît."));
            }
            throw $e; 
        } catch (\Throwable $th) {
            throw $th;
        } 
    }

    public function getAccountStatusFromLpn(AgentSecteur $lpnAgentSecteur){
        $token = '';
        if($this->session->get('lpn_token')){
            $token = $this->session->get('lpn_token');
        }else{
            throw new CustomException($this->translator->trans("Veuillez retaper votre mot de passe Little Ponails, s'il vous plaît."));
        }
        $agentInfo = $this->getAgentInformationFromLpn($token);
        if($agentInfo){
            $lpnAgentSecteur->setAccountFromPlaformStatus($agentInfo['status']);
            $this->entityManager->persist($lpnAgentSecteur);
            $this->entityManager->flush();
        }
        return $agentInfo;
    }

    public function updateLpnNetworkApi($data,$token){
        $LPN_BACK_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
        try{
            $response = $this->client->request(
                'POST',
                $LPN_BACK_URL . '/api/admin/agents/update-lpn-network',
                [
                    'headers' =>
                        ['Authorization' => 'Bearer ' . $token ]
                    ,
                    'json' => ['info' => $data ]
                ]
            );

            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (HttpExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === 422 || $statusCode === 400) {
                $content = json_decode($e->getResponse()->getContent(false), true);
                throw new CustomException($content['message']);
            }
            if ($statusCode === 401) {
                $this->session->remove('lpn_token');
                throw new CustomException($this->translator->trans("Veuillez retaper votre mot de passe Little Ponails, s'il vous plaît."));
            }
            throw $e; 
        } catch (\Throwable $th) {
            throw $th;
        }      
    }


    public function redesignLpnNetworkBasedOnPixelForceNetwork($credential){
        try {
            $this->entityManager->beginTransaction();
            $token = $this->getLoginToken(new User(),$credential,true);
            $data = [];
            $noneFixedNetwork = $this->agentSecteurRepository->getNoneFixedLpnNetwork();
            foreach ($noneFixedNetwork as $item) {
                $lpnInfoOfDirectChildren = $this->agentSecteurRepository->getLpnInfoOfDirectChildrenByParrainId([$item->getAgent()->getId()]);
                if(count($lpnInfoOfDirectChildren) == 0 ) continue;
                $lpnIdentifications = array_map(function($data){
                    return $data->getSectorPlatformUsername();
                }, $lpnInfoOfDirectChildren);

                $data[] = [
                    'userIdentification' => $item->getSectorPlatformUsername(),
                    'directChildrenIdentification' => $lpnIdentifications
                ];
            } 
            $this->updateLpnNetworkApi($data,$token);

            foreach ($noneFixedNetwork as $item) {
                $item->setChildrenSonporBeenChanged(true);
                $this->entityManager->persist($item);
            }

            $this->entityManager->flush();
            $this->entityManager->commit();
       } catch (\Throwable $th) {
            if ($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->rollback();
            }
            throw $th;
        }
    }

}
