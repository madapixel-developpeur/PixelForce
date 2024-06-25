<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\AccountAgentType;
use App\Form\ResetPasswordType;
use App\Manager\EntityManager;
use App\Manager\UserManager;
use App\Repository\CoachAgentRepository;
use App\Repository\UserRepository;
use App\Services\DirectoryManagement;
use App\Services\FileUploader;
use App\Services\User\UserNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\b;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var CoachAgentRepository
     */
    private $coachAgentRepository;
    /**
     * @var UserNormalizer
     */
    private $userNormalizer;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var FileUploader
     */
    private $fileUploader;
    /**
     * @var DirectoryManagement
     */
    private $directoryManagement;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher,
                                UserManager $userManager,
                                EntityManager $entityManager,
                                FileUploader $fileUploader,
                                DirectoryManagement $directoryManagement,
                                UserRepository $userRepository,
                                CoachAgentRepository $coachAgentRepository,
                                UserNormalizer $userNormalizer)
    {
        $this->userRepository = $userRepository;
        $this->coachAgentRepository = $coachAgentRepository;
        $this->userNormalizer = $userNormalizer;
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
        $this->directoryManagement = $directoryManagement;
        $this->userManager = $userManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Normalement on affiche les users correspondant au secteur d'activité de l'user en_cours
     * Les admins peuvent voir toute la liste des utilisateurs
     * Pour le moment, on affiche tout, car aucun secteur n'est présent
     *
     * @Route("/users/list", name="user_list")
     */
    public function list()
    {
        $relationCoachAgent = $this->coachAgentRepository->findBy(['coach'=> $this->getUser()]);

        return $this->render('users/list.html.twig', [
            'relationCoachAgent' => $relationCoachAgent
        ]);
    }

    /**
     * @Route("/user/addAgent", name="user_addAgent")
     * @Route("/user/addClient", name="user_addClient")
     */
    public function addAgent(Request $request)
    {
        switch($request->attributes->get('_route')){
            case 'user_addAgent': return $this->render('users/form_addAgent.html.twig', ['role' => User::ROLE_AGENT]); break;
            case 'user_addClient': return $this->render('users/form_addClient.html.twig', ['role' => User::ROLE_CLIENT]);break;
        }
        return new Response(null, 404);
    }

    /**
     * @Route("/user/findDest", name="user_findDest", options={"expose"=true})
     */
    public function findDestinataire(Request $request)
    {
        $finder = $request->query->get('finder');
        $currentUser = $this->getUser();
        $users = $this->userRepository->findDestinaire($finder, $currentUser);
        $normalizedUser = $this->userNormalizer->normalizeArrayUsers($users);
        return $this->json($normalizedUser);
    }


    /**
     * @Route("/user/compte/parametre/{id}", name="user_accountSetting")
     */
    public function accountSettingTemplate(User $user, Request $request)
    {
        $form = $this->createForm(AccountAgentType::class, $user)->remove('secteur')->add('id');
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // upload profil
            $fileName = $this->fileUploader->upload($request->files->get('user_avatar'), $this->directoryManagement->getMediaFolder_UserAvatars(), $user->getPhoto());
            $user->setPhoto($fileName);
            $this->entityManager->save($user);
            $this->addFlash('success', 'Informations modifiées avec succès');
        }

        return $this->render('users/account_setting.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/user/avatar/{id}", name="user_avatar")
     */
    public function UserAvatar(User $user)
    {
        $file = $this->directoryManagement->getMediaFolder_UserAvatars().DIRECTORY_SEPARATOR.$user->getPhoto();
        if(is_file($file)) {
            return new BinaryFileResponse($file);
        }

        $file = $this->directoryManagement->getPublicDir().DIRECTORY_SEPARATOR.'assets/vuexy/images/portrait/small/avatar-s-11.jpg';

        return new BinaryFileResponse($file);
    }

    /**
     * @Route("/user/compte/password/{id}", name="user_passwordSetting")
     */
    public function UserPassowrdSet(User $user, Request $request)
    {
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() && $this->passwordHasher->isPasswordValid($user, $request->request->get('password'))) {
         $this->userManager->setUserPasword($user, $request->request->get('reset_password')['password']['first'],'',false);
         $this->addFlash('success', 'Changement de mot de passe effectué');
        } elseif($form->isSubmitted() && empty($request->request->get('password'))) {
            $emptyPass = true;
        } elseif($form->isSubmitted() && !$this->passwordHasher->isPasswordValid($user, $request->request->get('password'))) {
            $error_password = true;
        }

        return $this->render('users/password_setting.html.twig', [
            'form' => $form->createView(),
            'error_password' => isset($error_password),
            'emptyPass' => isset($emptyPass),
            'border_error' => isset($error_password) || isset($emptyPass)
        ]);
    }

    /**
     * @Route("/api/user/{id}", name="find_user")
     */
    public function findUser($id)
    {
        $user = $this->userRepository->find($id);
        if($user==null) return $this->json(null, 404);
        return $this->json($user, 200);
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function index(): Response
    {
        return $this->json($this->getUser());
    }
}
