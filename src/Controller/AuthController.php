<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ClientSignUpType;
use App\Repository\UserRepository;
use App\Services\AuthService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class AuthController extends AbstractController
{
    private $entityManager;
    private $userRepository;
    private $authService;

    public function __construct(EntityManagerInterface $entityManager, 
        UserRepository $userRepository,
        AuthService $authService)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->authService = $authService;
    }

    
    /**
     * @Route("/inscription/client/{token}", name="signup_client")
     */
    public function signup($token, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $agent = $this->userRepository->findAgentByToken($token);
        $error = null;
        $user = new User();
        $form = $this->createForm(ClientSignUpType::class, $user, ['signup' => true]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $user = $this->authService->checkNewAccount($user);
                $request->getSession()->set('new_user', $user);
                return $this->redirectToRoute('check_account', ['token' => $token]);
                
            } catch(Exception $ex){
                $error = $ex->getMessage();
            }

        }

        return $this->render('user_category/client/auth/signup.html.twig',[
            'form' => $form->createView(),
            'error' => $error
        ]);
    
    }

    /**
     * @Route("/checkAccount/client/{token}", name="check_account")
     */
    public function checkAccount($token, Request $request): Response
    {
        
        $user = $request->getSession()->get('new_user', null);
        if($user == null){
            return $this->redirectToRoute('signup');
        }

        $agent = $this->userRepository->findAgentByToken($token);
        $error = null;
        
        $form = $this->createFormBuilder()
            ->add('verifCode', TextType::class, ["label"=>"Code de vérification", "trim" => true, "required" => true])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $data = $form->getData();
                $user->setClientAgent($agent);
                $this->authService->validateAccount($user, $data['verifCode']);
                $request->getSession()->remove('new_user');
                
                return $this->redirect($this->generateUrl('app_login', ['agentToken' => $token]));
            } catch(Exception $ex){
                $error = $ex->getMessage();
            }

        }

        return $this->render('user_category/client/auth/validate_account.html.twig',[
            'form' => $form->createView(),
            'error' => $error,
            'token' => $token
        ]);
    
    }

    
}
