<?php

namespace App\Controller;

use App\Entity\User;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Services\GenerateKey;
use App\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var MailerService
     */
    private $mailerService;
    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(UserRepository $userRepository, MailerService $mailerService, UserManager $userManager)
    {
        $this->userRepository = $userRepository;
        $this->mailerService = $mailerService;
        $this->userManager = $userManager;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $agentToken = $request->get('agentToken');

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'agentToken' => $agentToken]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/forgetPassword", name="app_forgetPassword")
     *
     * @param Request $request
     * @return Response
     */
    public function forgetPassword(Request $request, MailerInterface $mailer)
    {
        if($email = $request->request->get('email')) {
           return $this->redirectToRoute('app_regenerCode', [
               'email' => $email,
           ]);
        }
        return $this->render('security/forgetPassword/forgetPassword.html.twig', [
            'error' => $request->query->get('error')
        ]);
    }

    /**
     * @Route("/forgetPassword/regenerCode", name="app_regenerCode")
     */
    public function regenerCode(Request $request)
    {
        if($email = $request->query->get('email')) {
            $user =  $this->userManager->generateSixDigitKey($email);
            if($user) {
                // envoie du code par mail
                $this->mailerService->sendMailRegenerationCode($user);
                $this->addFlash('success', 'Un code vous a été envoyé');
                return $this->redirectToRoute('app_forgetPassword_getCode', [
                    'id' => $user->getId(),
                    'forgotenPassToken' => $user->getForgottenPassToken()
                ]);
            }
        }

        return $this->redirectToRoute('app_forgetPassword', [
            'error' => true
        ]);

    }


    /**
     * @route("/forgetPassword/getCode/{id}", name="app_forgetPassword_getCode")
     * @param User $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function forgetPasswordGetCode(User $user, Request $request)
    {
        $passToken = $request->query->get('forgotenPassToken');
        if($passToken != $user->getForgottenPassToken()) {
            $this->addFlash('danger', 'la page que vous demandez n\'est plus valide ');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/forgetPassword/forgetPassword_getCode.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @route("/forgetPassword/validateCode/{id}", name="app_forgetPassword_validateCode")
     */
    public function forgetPasswordValidateCode(User $user, Request $request)
    {
        if($user->validateSixDigitCode($request->request->get('sixDigitCode'))) {
            // supprime tout les codes/token
            if($password = $request->request->get('password')) {
               $repeatedPass = $request->request->get('repeat_password');
               $set = $this->userManager->setUserPasword($user, $password, $repeatedPass);
               if($set) {
                   $this->userManager->clearAllForgottenPassCode($user);
                   $this->addFlash('success', 'Votre mot de passe a été modifié avec succès');
                   return $this->redirectToRoute('app_login');
               }
               $this->addFlash('danger', 'Veuillez bien confirmer votre mot de passe');

            }

            return $this->render('security/forgetPassword/forgetPassword_changePasswordForm.html.twig', [
                'sixDigitCode' => $request->request->get('sixDigitCode')
            ]);
        }

        $this->addFlash('danger', 'Le code que vous avez entré est invalide');
       return $this->redirectToRoute('app_forgetPassword_getCode', [
           'id' => $user->getId()
       ]);
    }

}
