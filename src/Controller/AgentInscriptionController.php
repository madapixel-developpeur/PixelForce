<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\AgentSecteur;
use App\Manager\UserManager;
use App\Manager\EntityManager;
use App\Manager\StripeManager;
use App\Services\StripeService;
use App\Entity\PlanAgentAccount;
use App\Form\InscriptionAgentType;
use App\Repository\UserRepository;
use App\Services\User\AgentService;
use App\Repository\SecteurRepository;
use App\Repository\AgentSecteurRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PlanAgentAccountRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    private $agentService;
    public function __construct(EntityManager $entityManager, UserManager $userManager, StripeManager $stripeManager, SessionInterface $session, UserRepository $userRepository, AgentSecteurRepository $repoAgentSecteur, PlanAgentAccountRepository $repoPlanAgentAccount, SecteurRepository $secteurRepository,AgentService $agentService)
    {
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->stripeManager = $stripeManager;
        $this->session = $session;
        $this->userRepository = $userRepository;
        $this->repoAgentSecteur = $repoAgentSecteur;
        $this->repoPlanAgentAccount = $repoPlanAgentAccount;
        $this->secteurRepository = $secteurRepository;
        $this->agentService = $agentService;
    }


    /**
     * @Route("/inscription/agent/index/{ambassador_username?}", name="agent_inscription")
     */
    public function inscriptionAgent(Request $request, SecteurRepository $secteurRepository, $ambassador_username = null)
    {
        $user = new User();
        if($ambassador_username != null){
            $user->setAmbassadorUsername($ambassador_username);
        }
        $parrain=null;
        $form = $this->createForm(InscriptionAgentType::class, $user);
        $form->handleRequest($request);
        try{   
           $parrain=$this->getParainByUsername($ambassador_username);
           if($form->isSubmitted() && $form->isValid()) {
                $this->userManager->setUserPasword($user, $request->request->get('inscription_agent')['password']['first'], '', false);
                $user->setRoles([ User::ROLE_AGENT ]);
                $user->setActive(1);
                $user->setParrain($parrain);
                $this->agentService->saveAgent($user,$request->request->get('inscription_agent')['password']['first']);
                $this->addFlash(
                    'success',
                    'Votre inscription sur '.$_ENV['PLATFORME_NAME'].' a été effectuée avec succès'
                );
                return $this->redirectToRoute('app_login');
            }
        }
        catch(\Exception $e){
            $this->addFlash(
                'danger',
                $e->getMessage()
            );
        } 
        return $this->render('security/inscription/form.html.twig', [
            'form' => $form->createView()
        ]);

    }
    public function getParainByUsername($username){
        if($username != null && $username !=""){
           
            $parrain =$this->userRepository->findOneBy(['username' => $username]);
            if($parrain){
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

      /**
     * @Route("/agent/inscription/back-office/{ambassador_username?}", name="agent_inscription_backoffice")
     */
    public function inscriptionAgentBackOffice(Request $request, SecteurRepository $secteurRepository, $ambassador_username = null)
    {
        $user = new User();
        $parrain = $this->getUser();
        if($ambassador_username != null){
            $user->setAmbassadorUsername($ambassador_username);
            $parrain=$this->getParainByUsername($ambassador_username);
        }
        $form = $this->createForm(InscriptionAgentType::class, $user);
        $form->handleRequest($request);
        try{   
            if($form->isSubmitted() && $form->isValid()) {
                
                $this->userManager->setUserPasword($user, $request->request->get('inscription_agent')['password']['first'], '', false);
                $user->setRoles([ User::ROLE_AGENT ]);
                $user->setActive(1);
                $user->setParrain($parrain);
                $this->agentService->saveAgent($user,$request->request->get('inscription_agent')['password']['first']);
                $this->addFlash(
                    'success',
                    'Inscription effectuée avec succès'
                );
                if(!is_null($ambassador_username))
                {
                    return $this->redirectToRoute('agent_view');
                }
            }
        }
        catch(\Exception $e){
            $this->addFlash(
                'danger',
                $e->getMessage()
            );
        } 
        return $this->render('user_category/agent/inscription/form.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
