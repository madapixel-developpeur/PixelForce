<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\TypeSecteur;
use App\Entity\AgentSecteur;
use App\Manager\EntityManager;
use App\Manager\StripeManager;
use App\Services\StripeService;
use App\Entity\CategorieFormation;
use App\Repository\UserRepository;
use App\Services\User\AgentService;
use App\Repository\ContactRepository;
use App\Repository\SecteurRepository;
use App\Services\AgentSecteurService;
use App\Entity\SearchEntity\UserSearch;
use App\Repository\FormationRepository;
use App\Services\FormationAgentService;
use App\Services\Stat\StatAgentService;
use App\Repository\AgentSecteurRepository;
use App\Repository\CalendarEventRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\FormationAgentRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PlanAgentAccountRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieFormationRepository;
use App\Services\CategorieFormationAgentService;
use App\Repository\RFormationCategorieRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserTransactionRepository;

class AgentAccountController extends AbstractController
{
    private $repoSecteur;
    private $repoAgentSecteur;
    private $repoFormation;
    private $session;
    private $repoContact;
    private $repoFormationAgent;
    private $repoCatFormation;
    private $repoRelationFormationCategorie;
    private $categorieFormationAgentService;
    private $calendarEventRepository;
    private $stripeService;
    private $stripeManager;
    private $agentService;
    private $repoPlanAgentAccount;
    protected $repoUser;

    public function __construct(SecteurRepository $repoSecteur, AgentSecteurRepository $repoAgentSecteur, FormationRepository $repoFormation,SessionInterface $session, ContactRepository $repoContact, FormationAgentRepository $repoFormationAgent, CategorieFormationRepository $repoCatFormation, RFormationCategorieRepository $repoRelationFormationCategorie, CategorieFormationAgentService $categorieFormationAgentService, CalendarEventRepository $calendarEventRepository, StripeService $stripeService, StripeManager $stripeManager, AgentService $agentService, PlanAgentAccountRepository $repoPlanAgentAccount, UserRepository $repoUser,
    private EntityManager $entityManager)
    {
        $this->repoSecteur = $repoSecteur;
        $this->repoAgentSecteur = $repoAgentSecteur;
        $this->repoFormation = $repoFormation;
        $this->session = $session;
        $this->repoContact = $repoContact;
        $this->repoFormationAgent = $repoFormationAgent;
        $this->repoCatFormation = $repoCatFormation;
        $this->repoRelationFormationCategorie = $repoRelationFormationCategorie;
        $this->categorieFormationAgentService = $categorieFormationAgentService;
        $this->calendarEventRepository = $calendarEventRepository;
        $this->stripeService = $stripeService;
        $this->stripeManager = $stripeManager;
        $this->agentService = $agentService;
        $this->repoPlanAgentAccount = $repoPlanAgentAccount;
        $this->repoUser = $repoUser;
    }

    /**
     * Page d'accueil pour agent, qui sert de selection d'un secteur
     * 
     * @Route("/agent/accueil", name="agent_home")
     */
    public function agent_home(AgentSecteurService $agentSecteurService)
    {
        /** @var User $agent */
        $agent = $this->getUser();
        
        $this->session->remove('secteurId');
        $this->agentService->setSesssionEnabledContent($agent);

        $allSecteurs = $this->repoSecteur->findAllActive();

        // On vérifie le statut de compte de l'utilisateur 
        $accountStatus = $agent->getAccountStatus();
        $expiredAccount = ($this->agentService->isAccountExpired($agent)) ? true : false;
        $planAgentAccount = [];

        if ($this->agentService->isActivableContent($agent)) {
            $stripe_publishable_key = '';
            $stripeIntentSecret = '';
            $planPrice  = 0.0;
        }else {
            $agentSecteurs = $this->repoAgentSecteur->findBy(['agent' => $agent]);
            $planAgentAccountType = $agent->typePlanAccountBySecteurChoice($agentSecteurs);
            /** @var PlanAgentAccount */
            $planAgentAccount = $this->repoPlanAgentAccount->findOneBy(['status' => 'active', 'stripePriceName' => $planAgentAccountType, 'statusChange' => StripeService::STATUS_CHANGE['ACTIVE']]);
            
            // Gestion exeption
            if (is_null($planAgentAccount)) {
                return throw new \Exception("Plan d'abonnement null, n'oublie pas de créer des plans d'abonnement pour les agents dans l'espace Admin", 1);
            }
            
            $planPrice = $planAgentAccount->getAmount();
            $stripeIntentSecret = $this->stripeService->intentSecret($planPrice);
            $stripe_publishable_key = $_ENV['STRIPE_PUBLIC_KEY'];
        }

        return $this->render('user_category/agent/home_agent.html.twig', [
            'allSecteurs' => $allSecteurs,
            'repoAgentSecteur' => $this->repoAgentSecteur,
            'agent' => $this->getUser(),
            'agentSecteurService' => $agentSecteurService,
            'sessionAgentId' => $agent->getId(),
            'stripeIntentSecret' => $stripeIntentSecret,
            'stripe_publishable_key' => $stripe_publishable_key,
            'planPrice' => $planPrice,
            'expiredAccount' => $expiredAccount,
            'accountStatus' => $accountStatus,
            'USER_ACCOUNT_STATUS' => USER::ACCOUNT_STATUS,
            'repoUser' => $this->repoUser,
            'plan' => $planAgentAccount,
        ]);
    }


    /**
     * Permet de générer une session qui contient l'id du secteur 
     * Après génération du clé, on redirige l'utilisateur vers le dashboard
     * 
     * @Route("/agent/secteur/{id}/session/generate", name="agent_generate_sessionSecteur_before_redirect_to_route_dahsboard")
     */
    public function agent_generate_sessionSecteur_before_redirect_to_route_dahsboard(Secteur $secteur)
    {
        $this->session->set('secteurId', $secteur->getId());
        $this->session->set('typeSecteurId', $secteur->getType()->getId());
        return $this->redirectToRoute('agent_dashboard_secteur', ['id' => $secteur->getId()]);
    }

    /**
     * @Route("/agent/secteur/{id}/add", name="agent_add_sector")
     */
    public function agentAddSector(Secteur $secteur)
    {
        $user = $this->getUser();
        $agentSecteur  = new AgentSecteur();
        $agentSecteur->setAgent($user);
        $agentSecteur->setSecteur($secteur);
        $agentSecteur->setStatut(1);
        $agentSecteur->setDateValidation(new \DateTime());
        $this->entityManager->save($agentSecteur);
        return $this->redirectToRoute('agent_home');
    }

    /**
     * @Route("/agent/dashboard/secteur/{id}", name="agent_dashboard_secteur")
     */
    public function agent_dashboard_secteur( Request $request, PaginatorInterface $paginator, Secteur $secteur, StatAgentService $statAgentService,UserRepository $userRepository, UserTransactionRepository $userTransactionRepository, CategorieFormationRepository $categorieFormationRepository)
    {
      
        //dd($secteur);
        $agent = (object)$this->getUser();
        $this->agentService->setStartDate($agent);
      
        $firstFormation = $this->repoFormation->findOrderedNonFinishedFormations($secteur, $agent);
        
        // On vérifie d'abord si la session avec la clé 'secteurId' est générée ou les contenus sont activés
        $sessionSecteurId =  $this->session->get('secteurId');
        $sessionAccountStatus =  $this->agentService->isActivableContent($agent);
        if (!$sessionSecteurId || !$sessionAccountStatus) {
            return $this->redirectToRoute('agent_home');
        }

        $statDigital = null;
        if($sessionSecteurId == $this->getParameter('secteur_digital_id')){
            $statDigital = $statAgentService->getPbbStat($agent->getId());
            // $statDigital = $statAgentService->getPbbStat(1);
        }

        $contacts = $this->repoContact->findBy(['secteur' => $secteur, 'agent' => $agent]);
        $contacts = $paginator->paginate(
            $contacts,
            $request->query->getInt('page', 1),
            5
        );

        // Calendar upcoming events :
        $upcomingEvents = $this->calendarEventRepository->findUpcomingEvents($agent);
        $eventsOfTheDay = $this->calendarEventRepository->findEventsOfTheDay($agent);

        // Coach
        $userSearch = new UserSearch();
        $coachs = $paginator->paginate(
            $userRepository->findCoachBySecteur(new UserSearch(),$secteur),
            $request->query->getInt('page', 1),
            20
        );

        //stat
        $anneeActuelle = intval(date('Y'));
        $annee = $request->get('annee', $anneeActuelle);
        $statVente = $statAgentService->getStatVente($agent->getId(), $secteur->getId(), $secteur->getType()->getId());
        $nbrClients = $statAgentService->getNbrClients($agent->getId());
        $topClients = $statAgentService->getTopClients($agent->getId(), $secteur->getId(), 5);
        $revenuAnnee = $statAgentService->getRevenuAnnee($annee, $secteur->getId(), $agent->getId());
        $nbrRdv = $statAgentService->getNbrRdv($agent->getId());
        $pbb_summary = $statAgentService->getPbbSummary($agent->getId(), $agent->getNom());
        $soldeRemuneration = $userTransactionRepository->getSolde($agent, [$secteur->getId()]);
        //dd($pbb_summary);
        $chiffreAffaireTotal = $pbb_summary['chiffreAffaire'] + ($statVente != null ? $statVente['ca'] : 0);
        $nbVentesTotal = count($pbb_summary['orders']) + ($statVente != null ? $statVente['nbr_ventes'] : 0);


        $positionSteps = [
            ['position' => 1, 'label' => 'Avoir au moins 5 filleuls directs et au moins 1000 € de CA'],
            ['position' => 2, 'label' => 'Avoir au moins 25 membres dans son équipe'],
            ['position' => 3, 'label' => 'Avoir au moins 100 membres dans son équipe'],
        ];

        $formationCategoriesOrdered = $categorieFormationRepository->getValidCategoriesOrdered();

        return $this->render('user_category/agent/dashboard_secteur.html.twig', [
            'secteur' => $secteur,
            'firstFormation' => $firstFormation,
            'contacts' => $contacts,
            'CategorieFormation' => CategorieFormation::class,
            'nbrAllMyContacts' => count($this->repoContact->findAll()),
            'repoRelationFormationCategorie' => $this->repoRelationFormationCategorie,
            'upcomingEvents'=> $upcomingEvents,
            'eventsOfTheDay'=> $eventsOfTheDay,
            'statVente' => $statVente,
            'nbrClients' => $nbrClients,
            'topClients' => $topClients,
            'revenuAnnee' => $revenuAnnee,
            'annee' => $annee,
            'anneeActuelle' => $anneeActuelle,
            'nbrRdv' => $nbrRdv,
            'chiffreAffaireTotal' => $chiffreAffaireTotal,
            'nbVentesTotal' => $nbVentesTotal,
            "coachs" => $coachs,
            "agent"=> $agent,
            'statDigital' => $statDigital,
            'soldeRemuneration' => $soldeRemuneration,
            'positionSteps' => $positionSteps,
            'formationCategoriesOrdered' => $formationCategoriesOrdered
        ]);
    }

    /**
     * @Route("/agent/view", name="agent_view")
     */
    public function admin_agent_view(Request $request, AgentSecteurService $agentSecteurService,UserRepository $repoUser, PaginatorInterface $paginator)
    {
        $ambassadeur = $this->getUser();
        $result=$this->repoUser->findBy(['parrain'=>$ambassadeur->getId()]);
        $filleul = $paginator->paginate(
            $result,
            $request->query->getInt('page', 1),
            5
        );

        $countEquipe = $this->agentService->getNumberOfTeam($ambassadeur,1);
        $countDirect = count($result);
        return $this->render('user_category/agent/view_agent.html.twig', [
            'ambassadeur' => $ambassadeur,
            'filleul'=>$filleul,
            'countEquipe' =>$countEquipe,
            'countDirect' =>$countDirect,
        ]);
    }

       /**
     * @Route("/agent/filleul-tree", name="app_agent_data_lineaire")
     */
    public function getDataUnilevel()
    {
        $unilevel = $this->agentService->getUnilevelChildren($this->getUser(),1,true);
        $data = ['equipe' => $unilevel];
        return new JsonResponse($data);
    }

    // public function agent_dashboard_secteur( Request $request, PaginatorInterface $paginator, Secteur $secteur, StatAgentService $statAgentService)
    // {
      
    //     $agent = (object)$this->getUser();
    //     $this->agentService->setStartDate($agent);

    //     $categorie = $this->categorieFormationAgentService->getCurrentAgentCategorie($agent, $secteur);
      
    //     $formations = $this->repoFormation->findFormationsAgentBySecteurAndCategorie($secteur, $agent, $categorie, true);
       
    //     if (count($formations) > 0) {
    //         $firstFormation = $formations[0];
    //     }else{
    //         $firstFormation = null;
    //     }
        
    //     // On vérifie d'abord si la session avec la clé 'secteurId' est générée ou les contenus sont activés
    //     $sessionSecteurId =  $this->session->get('secteurId');
    //     $sessionAccountStatus =  $this->agentService->isActivableContent($agent);
    //     if (!$sessionSecteurId || !$sessionAccountStatus) {
    //         return $this->redirectToRoute('agent_home');
    //     }

    //     $contacts = $this->repoContact->findBy(['secteur' => $secteur, 'agent' => $agent]);
    //     $contacts = $paginator->paginate(
    //         $contacts,
    //         $request->query->getInt('page', 1),
    //         5
    //     );

    //     // Calendar upcoming events :
    //     $upcomingEvents = $this->calendarEventRepository->findUpcomingEvents($agent);
    //     $eventsOfTheDay = $this->calendarEventRepository->findEventsOfTheDay($agent);


    //     //stat
    //     $anneeActuelle = intval(date('Y'));
    //     $annee = $request->get('annee', $anneeActuelle);
    //     $statVente = $statAgentService->getStatVente($agent->getId(), $secteur->getId(), $secteur->getType()->getId());
    //     $nbrClients = $statAgentService->getNbrClients($agent->getId());
    //     $topClients = $statAgentService->getTopClients($agent->getId(), $secteur->getId(), 5);
    //     $revenuAnnee = $statAgentService->getRevenuAnnee($annee, $secteur->getId(), $agent->getId());
    //     $nbrRdv = $statAgentService->getNbrRdv($agent->getId());

    //     return $this->render('user_category/agent/dashboard_secteur.html.twig', [
    //         'secteur' => $secteur,
    //         'formations' => $formations,
    //         'firstFormation' => $firstFormation,
    //         'contacts' => $contacts,
    //         'CategorieFormation' => CategorieFormation::class,
    //         'nbrAllMyContacts' => count($this->repoContact->findAll()),
    //         'repoRelationFormationCategorie' => $this->repoRelationFormationCategorie,
    //         'upcomingEvents'=> $upcomingEvents,
    //         'eventsOfTheDay'=> $eventsOfTheDay,
    //         'statVente' => $statVente,
    //         'nbrClients' => $nbrClients,
    //         'topClients' => $topClients,
    //         'revenuAnnee' => $revenuAnnee,
    //         'annee' => $annee,
    //         'anneeActuelle' => $anneeActuelle,
    //         'nbrRdv' => $nbrRdv
    //     ]);
    // }

    /**
     * @Route("/agent/account/trial/payement/execute", name="agent_account_trial_payment_execute")
     */
    public function agent_account_trial_payment_execute(Request $request)
    {
        $user = $this->getUser();

        if ($request->getMethod() === "POST") {
            $this->stripeManager->persistPayment($user, $_POST);
        }

        return $this->json(
            ['stripe_checkout' => 'successfully'], 
            200
        );
    }
}