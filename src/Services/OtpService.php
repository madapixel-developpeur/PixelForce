<?php

namespace App\Services;

use Exception;
use App\Entity\User;
use App\Entity\Retiros;
use App\Entity\UserOTP;
use App\Services\MailerService;
use App\Exception\CustomException;
use App\Repository\UserRepository;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LicenciasUserRepository;
use App\Repository\TypeIdentityDocRepository;
use App\Repository\KycVerificationStatusRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OtpService 
{
    private $entityManager;
    private $mailService;
    private $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        MailerService $mailService,
        UserRepository $userRepository,
        private SessionInterface $session,
    )
    {
        $this->entityManager = $entityManager;
        $this->mailService = $mailService;
        $this->userRepository = $userRepository;
    }

    public function sendOtp(User|null $user, string|null $email, int $type, $name = null, $surname = null){
        $this->entityManager->clear();

        if($user) $user = $this->userRepository->find($user->getId());
        $randomBytes = random_bytes(6); // You can adjust the length of the byte string
        $value = bin2hex($randomBytes); // Convert binary to hexadecimal

        $otp = new UserOTP();
        $otp->setCreatedAt(new \DateTimeImmutable());
        $otp->setStatus(UserOTP::STATUS_CREATED);
        $otp->setClearValue($value);
        $otp->setValue(sha1($value));
        $otp->setUser($user);
        $otp->setEmail($user?->getEmail()??$email);
        $otp->setOperationType($type);

        $this->entityManager->persist($otp);
        $this->entityManager->flush();
        $this->setEmailOtp($otp->getEmail());

        try{
        $this->mailService->sendMailOtp($otp, $name??$user?->getName(), $surname??$user?->getSurname() );
        } catch(\Exception $e){
            throw new CustomException('Une erreur est survenue au niveau de l’envoi d’un mail de vérification. Veuillez informer l’administrateur');
        }
    }

    public function getEmailOtp(){
        $result = $this->session->get('email-otp', null);
        return $result;
    }

    public function setEmailOtp($email){
        $this->session->set('email-otp', $email);
    }

    public function removeEmailOtp(){
        $this->session->remove('email-otp');
    }

    public function getLinkedAccountInfo(){
        $result = $this->session->get("linked-account-info", null);
        return $result;
    }

    public function setLinkedAccountInfo(array $data){
        
        $this->session->set('linked-account-info', ['data' => $data]);
    }

    public function removeLinkedAccountInfo(){
        $this->session->remove('linked-account-info');
    }

}