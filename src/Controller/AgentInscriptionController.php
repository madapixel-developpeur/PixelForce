<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\AgentSecteur;
use App\Entity\PlanAgentAccount;
use App\Entity\Secteur;
use App\Form\InscriptionAgentOldType;
use App\Form\InscriptionAgentType;
use App\Manager\EntityManager;
use App\Manager\StripeManager;
use App\Manager\UserManager;
use App\Repository\AgentSecteurRepository;
use App\Repository\PlanAgentAccountRepository;
use App\Repository\SecteurRepository;
use App\Repository\UserRepository;
use App\Services\AuthService;
use App\Services\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

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
    public function __construct(private AuthService $authService, EntityManager $entityManager, UserManager $userManager, StripeManager $stripeManager, SessionInterface $session, UserRepository $userRepository, AgentSecteurRepository $repoAgentSecteur, PlanAgentAccountRepository $repoPlanAgentAccount, SecteurRepository $secteurRepository)
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


    /**
     * @Route("/inscription/agent/index", name="agent_inscription")
     */
    public function inscriptionAgent(Request $request, SecteurRepository $secteurRepository)
    {
        $user = new User();
        $form = $this->createForm(InscriptionAgentType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $parrainUsername = $form->get('parrain')->getData();
            $parrain = $this->userRepository->findOneBy(['username' => $parrainUsername]);
            if(!isset($parrain)) $form->get('parrain')->addError(new FormError("Le parrain avec le nom d'utilisateur '".$parrainUsername."' n'existe pas."));
            else {
                $user->setParrain($parrain); // Assuming 'parrain' is a property in your entity
                $user->setHasPaidSubscription(false); // Par défaut l'agent n'a pas encore payé l'abonnement

                $this->userManager->setUserPasword($user, $request->request->get('inscription_agent')['password']['first'], '', false);
                $user->setRoles([ User::ROLE_AGENT ]);
                $user->setActive(1);
                
                // Pour savoir que l'agent est le n-ième inscrit
                $numAgent = $this->userRepository->countByRole(User::ROLE_AGENT);
                $user->setNumAgent($numAgent);
                
                // $user->setAccountStatus(User::ACCOUNT_STATUS['UNPAID']);
                $user->setAccountStatus(User::ACCOUNT_STATUS['ACTIVE']); // On met temporairement le statut comme ACTIVE
                $this->entityManager->save($user);
                $this->session->set('agentId', $user->getId());
                $this->addFlash(
                   'success',
                   'Votre inscription sur Greenlife Ultimate a été effectuée avec succès'
                );
                $this->authService->autoAuthenticate($user);
                return $this->redirectToRoute('client_pack_index');
            }
        }

            return $this->render('security/inscription/form.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/inscription/agent/index-old", name="agent_inscription_old")
     */
    public function inscriptionAgentOld(Request $request, SecteurRepository $secteurRepository)
    {
        $user = new User();
        $form = $this->createForm(InscriptionAgentOldType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->userManager->setUserPasword($user, $request->request->get('inscription_agent')['password']['first'], '', false);
            $user->setRoles([ User::ROLE_AGENT ]);
            $user->setActive(1);
            // $user->setAccountStatus(User::ACCOUNT_STATUS['UNPAID']);
            $user->setAccountStatus(User::ACCOUNT_STATUS['ACTIVE']); // On met temporairement le statut comme ACTIVE
            $this->entityManager->save($user);
            $this->session->set('agentId', $user->getId());
            $this->addFlash(
                'success',
                'Votre inscription sur Greenlife Ultimate a été effectuée avec succès'
            );
            return $this->redirectToRoute('app_login');
        }

            return $this->render('security/inscription/form-old.html.twig', [
            'form' => $form->createView()
        ]);

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

        $user->setRoles([ User::ROLE_AGENT ]);
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
        }else{
            /** @var User $agent */
            $sessionAgentId =  $this->session->get('agentId');
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
        $sessionAgentId =  $this->session->get('agentId');

        if ($request->getMethod() === "POST") {
            $sessionAgentId_Post = intval($_POST['sessionAgentId']);

            if ($sessionAgentId_Post === $sessionAgentId) {
                $user = $this->userRepository->find($sessionAgentId_Post);
                $this->stripeManager->persistPayment($user, $_POST);
            }else{
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

        $sessionAgentId =  $this->session->get('agentId');
        /** @var User $agent */
        $agent = $this->getUser();
        if ($agent) {
            $sessionAgentId = $agent->getId();
        }

        /** @var User */
        $user = $this->userRepository->find($sessionAgentId);
        
        $dataPostAjax = $request->getContent();
        $jsonToArray =  json_decode($dataPostAjax, true);
        $stripePriceId = $jsonToArray["data"]["stripePriceId"];
        $paymentMethodId = $jsonToArray["data"]["paymentMethodId"];
        $stripePriceName = $jsonToArray["data"]["stripePriceName"]; 
        $planSubscriptionId = $jsonToArray["data"]["planSubscriptionId"]; 

        if ($request->getMethod() === "POST") {
            $sessionAgentId_Post = intval($jsonToArray["data"]['sessionAgentId']);

            if ($sessionAgentId_Post === $sessionAgentId) {
                $user = $this->userRepository->find($sessionAgentId_Post);
                $this->stripeManager->persistAgentSubscriptionPlan($stripePriceId, $paymentMethodId, $stripePriceName, $planSubscriptionId, $user);
            }else{
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
