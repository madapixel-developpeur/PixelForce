<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;

class SecurityService
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $em,
        private MailerService $mailService,
        private Security $security,
        private TokenStorageInterface $tokenStorage,
        private UserRepository $userRepository
    )
    {
    }


    public function generateCredentialsForAnonymous($informations): User
    {
        $existingUser = $this->userRepository->findOneBy(["email"=>$informations['email']]);
        if($existingUser != null) return $existingUser;

        $user = new User();
        $plainPassword = uniqid();

        $password = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($password);
        $user->setPlainPassword($plainPassword);
        $user->setNom($informations['nom'] ?? "Indéfini");
        $user->setPrenom($informations['prenom'] ?? "Indéfini");
        $user->setTelephone($informations['telephone'] ?? "Indéfini");
        $user->setUsername($informations['email']);
        $user->setEmail($informations['email']);
        $user->setCreatedAt(new DateTime());
        $user->setRoles(["ROLE_CLIENT"]);
        
        

        $this->em->persist($user);
        $this->em->flush();


        $mail = [
            'to' => $user->getEmail(),
            'subject' => "Informations d'authentification",
            'body' => $this->mailService->renderTwig('emails/new_user.html.twig', ['user' => $user])
        ];
        $this->mailService->mySendMail($mail);
    
        return $user;
    }

    public function autoAuthenticate(User $user)
    {
        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
        $token = $this->tokenStorage->setToken($token);
    }
}

