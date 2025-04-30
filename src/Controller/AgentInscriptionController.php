<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\AgentSecteur;
use App\Manager\UserManager;
use App\Manager\EntityManager;
use App\Manager\StripeManager;
use App\Services\MailerService;
use App\Services\StripeService;
use App\Entity\PlanAgentAccount;
use App\Exception\CustomException;
use App\Form\InscriptionAgentType;
use App\Repository\UserRepository;
use App\Repository\SecteurRepository;
use App\Services\Stat\StatAgentService;
use App\Repository\AgentSecteurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use App\Repository\PlanAgentAccountRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AgentInscriptionController extends AbstractController
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var UserManager
     */
    private $userManager;

    private $stripeManager;

    /** @var SessionInterface $session */
    private $session;

    /** @var UserRepository $userRepository */
    private $userRepository;

    /** @var AgentSecteurRepository $repoAgentSecteur */
    private $repoAgentSecteur;

    /** @var PlanAgentAccountRepository $repoPlanAgentAccount */
    protected $repoPlanAgentAccount;
    private $secteurRepository;
    public function __construct(EntityManager $entityManager, UserManager $userManager, StripeManager $stripeManager, SessionInterface $session, UserRepository $userRepository, AgentSecteurRepository $repoAgentSecteur, PlanAgentAccountRepository $repoPlanAgentAccount, SecteurRepository $secteurRepository, private MailerService $mailerService,
        private TokenStorageInterface $tokenStorage,
        private Security $security)
    {
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->stripeManager = $stripeManager;
        $this->session = $session;
        $this->userRepository = $userRepository;
        $this->repoAgentSecteur = $repoAgentSecteur;
        $this->repoPlanAgentAccount = $repoPlanAgentAccount;
        $this->secteurRepository = $secteurRepository;
    }

    public function getStepWithError($fields){
        $stepWithError = 99;
        foreach ($fields as $field) {
            $config = $field->getConfig();

            if ($config->getType()->getInnerType() instanceof RepeatedType) {
                foreach ($field->all() as $childField) {  // Loop through both password fields
                    if ($childField->getErrors()->count() > 0) {  // Check errors on children
                        $step = $childField->getConfig()->getOption('attr')['step'] ?? null;
                        if ($step !== null) {
                            $stepWithError = min($step, $stepWithError);
                        }
                    }
                }
            } else {
                if ($field->getErrors()->count() > 0) {
                    $step = $config->getOption('attr')['step'] ?? null;
                    if ($step !== null) {
                        $stepWithError = min($step, $stepWithError);
                    }
                }
            }

        }
        return $stepWithError == 99 ? 0 : $stepWithError ;
    }

    /**
     * @Route("/inscription/agent/index/{ambassador_username?}", name="agent_inscription")
     */
    public function inscriptionAgent(Request $request, SecteurRepository $secteurRepository, StatAgentService $statAgentService, $ambassador_username = null)
    {
        $ref = $request->get('ref', null);
        if ($ref) {
            $userInova = $statAgentService->getInovaUserByRef($ref);
            if ($userInova) {
                $parrain = $this->userRepository->getUserByEmail($userInova["authentication"]["email"]["email"]);
                if ($parrain)
                    $ambassador_username = $parrain->getUsername();
            }
        }
        $user = new User();
        if ($ambassador_username != null) {
            $user->setAmbassadorUsername($ambassador_username);
        }
        $parrain = null;
        $form = $this->createForm(InscriptionAgentType::class, $user, [
            'attr' => ['id' => 'sign-up-form']
        ]);
        $form->handleRequest($request);
        $currentStep = $request->request->getInt('currentStep', 0);
        try {
            if (!$parrain) {
                $parrain = $this->getParainByUsername($ambassador_username);
            }
            if ($form->isSubmitted() ) {
                if($form->isValid()){
                    $roles = [user::ROLE_REVENDEUR];
                    // if (empty($roles)) {
                    //     throw new CustomException('Vous devez sélectionner au moins un type de compte.');
                    // }
                    // if(in_array(User::ROLE_PROFESSIONNEL, $roles) && $user->getPays() == 'FR'){
                    //     throw new CustomException("À ce jour, la plateforme ".$_ENV['PLATFORM_NAME']." n'est pas ouverte aux professionnels basés en France.");
                    // }
                    $this->userManager->setUserPasword($user, $request->request->get('inscription_agent')['password']['first'], '', false);
                    array_unshift($roles, User::ROLE_AGENT);
                    $user->setRoles($roles);
                    $user->setActive(1);
                    $user->setParrain($parrain);
                    // $user->setAccountStatus(User::ACCOUNT_STATUS['UNPAID']);
                    $user->setAccountStatus(User::ACCOUNT_STATUS['ACTIVE']); // On met temporairement le statut comme ACTIVE
                    $this->entityManager->save($user);
                    $this->mailerService->sendUserWelcome($user);
                    $this->session->set('agentId', $user->getId());

                    
                    $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                    $this->tokenStorage->setToken($token);

                    $this->addFlash(
                        'success',
                        'Votre inscription sur '.$_ENV['PLATFORM_NAME'].' a été effectuée avec succès'
                    );
                    return $this->redirectToRoute('agent_home');
                }else{
                    $currentStep = $this->getStepWithError($form->all());
                }
            }

        } catch (CustomException $e) {
            $this->addFlash(
                'danger',
                $e->getMessage()
            );
        } catch (\Exception $e) {
            dd($e);
            $this->addFlash(
                'danger',
                $_ENV['CUSTOM_ERROR_MESSAGE']
            );
        }
       

        //dd($user);

        return $this->render('security/signin.html.twig', [
            'form' => $form->createView(),
            'currentStep' =>  $currentStep
        ]);

    }
    public function getParainByUsername($username)
    {
        if ($username != null && $username != "") {

            $parrain = $this->userRepository->findOneBy(['username' => $username]);
            if ($parrain) {
                return $parrain;
            }
            throw new \Exception("Le nom d'utilisateur inscrit en haut n'existe pas ou n'est pas valide.");
        }
        return null;
    }


    /**
     * @Route("/inscription/agent/api", name="agent_inscription_api")
     */
    public function inscriptionAgentAPI(Request $request)
    {

        // Parse the JSON body from the request
        $data = json_decode($request->getContent(), true);
        $user = new User();
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $user->setTelephone($data['telephone']);
        $user->setCodePostal($data['codePostal']);
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setVille($data['ville']);

        $secteurPBB = $this->secteurRepository->find(Secteur::PBB);
        $userSecteur = (new AgentSecteur())
            ->setAgent($user)
            ->setSecteur($secteurPBB)
            ->setStatut(true)
            ->setDateValidation(new \DateTime())
        ;

        // $user->removeAllAgentSecteur();
        $user->addAgentSecteur($userSecteur);

        $user->setRoles([User::ROLE_AGENT]);
        $user->setActive(1);
        $user->setAccountStatus(User::ACCOUNT_STATUS['ACTIVE']);

        $this->entityManager->save($user);

        // Return a success response
        return $this->json([
            'message' => 'User created successfully',
            'userId' => $user->getId(),
            'data' => $data,

        ]);
    }
    /**
     * @Route("/inscription/agent/payement/intent", name="agent_register_payment_intent")
     */
    public function agent_register_payment_intent(Request $request, StripeService $stripeService)
    {
        $stripe_publishable_key = $_ENV['STRIPE_PUBLIC_KEY'];

        if ($request->query->get('stripe_checkout') && $request->query->get('stripe_checkout') === 'successfully') {
            // Si la transaction est faite, $stripeIntentSecret doit être vide ou null
            $stripeIntentSecret = '';
        } else {
            /** @var User $agent */
            $sessionAgentId = $this->session->get('agentId');
            if (!$sessionAgentId) {
                $this->addFlash(
                    'warning',
                    'Vous avez été rediriger vers cette page car une erreur s\'est produite !'
                );
                return $this->redirectToRoute('app_login');
            }

            $agent = $this->userRepository->find($sessionAgentId);
            $agentSecteurs = $this->repoAgentSecteur->findBy(['agent' => $agent]);
            $planAgentAccountType = $agent->typePlanAccountBySecteurChoice($agentSecteurs);
            /** @var PlanAgentAccount */
            $planAgentAccount = $this->repoPlanAgentAccount->findOneBy(['status' => 'active', 'stripePriceName' => $planAgentAccountType, 'statusChange' => StripeService::STATUS_CHANGE['ACTIVE']]);

            // Gestion exeption
            if (is_null($planAgentAccount)) {
                return throw new \Exception("Plan d'abonnement null, n'oublie pas de créer des plans d'abonnement pour les agents dans l'espace Admin", 1);
            }

            $planPrice = $planAgentAccount->getAmount();
            $stripeIntentSecret = $stripeService->intentSecret($planPrice);
        }

        return $this->render('security/inscription/agent_register_payment.html.twig', [
            'stripeIntentSecret' => $stripeIntentSecret,
            'stripe_publishable_key' => $stripe_publishable_key,
            'sessionAgentId' => $sessionAgentId,
            'agent_accountStatus' => USER::ACCOUNT_STATUS['UNPAID'],
            'repoAgentSecteur' => $this->repoAgentSecteur,
            'repoUser' => $this->userRepository,
            'plan' => $planAgentAccount,
            'planPrice' => $planPrice,
            'planAgentAccountType' => $planAgentAccountType
        ]);
    }

    /**
     * @Route("/inscription/agent/payement/execute", name="agent_register_payment_execute")
     */
    public function agent_register_payment_execute(Request $request)
    {
        $sessionAgentId = $this->session->get('agentId');

        if ($request->getMethod() === "POST") {
            $sessionAgentId_Post = intval($_POST['sessionAgentId']);

            if ($sessionAgentId_Post === $sessionAgentId) {
                $user = $this->userRepository->find($sessionAgentId_Post);
                $this->stripeManager->persistPayment($user, $_POST);
            } else {
                return $this->json(
                    [
                        'stripe_checkout' => 'error',
                        'cause' => 'different_agentId'
                    ],
                    200
                );
            }
        }

        return $this->json(
            ['stripe_checkout' => 'successfully'],
            200
        );
    }


    /**
     * @Route("/inscription/agent/stripe/subscription/plan/check", name="agent_stripe_subscription_plan_account_execute")
     */
    public function agent_stripe_subscription_plan_account_execute(Request $request)
    {

        $sessionAgentId = $this->session->get('agentId');
        /** @var User $agent */
        $agent = $this->getUser();
        if ($agent) {
            $sessionAgentId = $agent->getId();
        }

        /** @var User */
        $user = $this->userRepository->find($sessionAgentId);

        $dataPostAjax = $request->getContent();
        $jsonToArray = json_decode($dataPostAjax, true);
        $stripePriceId = $jsonToArray["data"]["stripePriceId"];
        $paymentMethodId = $jsonToArray["data"]["paymentMethodId"];
        $stripePriceName = $jsonToArray["data"]["stripePriceName"];
        $planSubscriptionId = $jsonToArray["data"]["planSubscriptionId"];

        if ($request->getMethod() === "POST") {
            $sessionAgentId_Post = intval($jsonToArray["data"]['sessionAgentId']);

            if ($sessionAgentId_Post === $sessionAgentId) {
                $user = $this->userRepository->find($sessionAgentId_Post);
                $this->stripeManager->persistAgentSubscriptionPlan($stripePriceId, $paymentMethodId, $stripePriceName, $planSubscriptionId, $user);
            } else {
                return $this->json(
                    [
                        'stripe_subscription_plan' => 'error',
                        'cause' => 'different_agentId'
                    ],
                    200
                );
            }
        }
        return $this->json([
            'stripe_subscription_plan' => 'successfully'
        ]);
    }
}
