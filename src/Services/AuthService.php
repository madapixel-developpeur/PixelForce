<?php

namespace App\Services;

use DateTime;
use Exception;
use DateInterval;
use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\ForgotPassword;
use App\Entity\AccountValidation;
use App\Exception\CustomException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AgentSecteurRepository;
use App\Repository\ForgotPasswordRepository;
use App\Repository\AccountValidationRepository;
use App\Repository\CategorieFormationRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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

            $response = $this->client->request(
                'POST',
                $LPN_BACK_URL . '/api/auth/register-end-point',
                [
                    'multipart' =>   $data
                ]
            );
            $content = json_decode($response->getContent(), true);
            dd($content);
            return $content;
        } catch (HttpExceptionInterface $e) {
            dd($e);
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === 422) {
                $content = json_decode($e->getResponse()->getContent(false), true);
                throw new CustomException($content['message']);
            }
            throw $e; 
        } catch (\Throwable $th) {
            dd($th);
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
        $this->entityManager->persist($agentSecteur);
        $this->entityManager->flush();
    }


}
