<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Secteur;
use App\Entity\CoachAgent;
use App\Form\UserLoginType;
use App\Entity\AgentSecteur;
use App\Form\UserSearchType;
use App\Manager\UserManager;
use App\Manager\EntityManager;
use App\Form\ResetPasswordType;
use App\Form\MultipleSecteurType;
use App\Form\InscriptionAgentType;
use App\Repository\UserRepository;
use App\Services\FormationService;
use App\Services\User\AgentService;
use App\Repository\SecteurRepository;
use App\Services\AgentSecteurService;
use App\Entity\SearchEntity\UserSearch;
use App\Repository\FormationRepository;
use App\Services\RemunerationServiceSecu;
use App\Services\Stat\StatAgentService;
use App\Repository\CoachAgentRepository;
use App\Repository\AgentSecteurRepository;
use App\Repository\CoachSecteurRepository;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieFormationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoachAgentController extends AbstractController
{
    protected $coachAgentRepository;
    protected $repoUser;
    protected $userManager;
    protected $entityManager;
    protected $repoCoachSecteur;

    protected $repoAgentSecteur;
    /**
     * @var FormationService
     */
    private $formationService;

    public function __construct(
        FormationService $formationService,
        CoachAgentRepository $coachAgentRepository,
        UserRepository $repoUser,
        UserManager $userManager,
        EntityManager $entityManager,
        CoachSecteurRepository $repoCoachSecteur,
        AgentSecteurRepository $repoAgentSecteur,
        private FormationRepository $repoFormation,
        private TranslatorInterface $translator,
        private StatAgentService $statAgentService,
        private AgentService $agentService,
         
    ) {
        $this->coachAgentRepository = $coachAgentRepository;
        $this->repoUser = $repoUser;
        $this->userManager = $userManager;
        $this->entityManager = $entityManager;
        $this->repoCoachSecteur = $repoCoachSecteur;
        $this->repoAgentSecteur = $repoAgentSecteur;
        $this->formationService = $formationService;
    }

    /**
     * @Route("/coach/agent/list", name="coach_agent_list")
     */
    public function coach_agent_list(Request $request, PaginatorInterface $paginator)
    {

        /** @var User $coach */
        $coach = $this->getUser();
        $mySector = $this->repoCoachSecteur->findOneBy(['coach' => $this->getUser()])->getSecteur();
        $search = new UserSearch();
        $searchForm = $this->createForm(UserSearchType::class, $search)
            ->remove('secteur')
            ->remove('tag')
            ->remove('active');
        $searchForm->handleRequest($request);
        $agents = $paginator->paginate(
            $this->repoUser->findAgentByCoach($search, $coach),
            $request->query->getInt('page', 1),
            20
        );


        return $this->render('user_category/coach/agent/list_agents.html.twig', [
            'agents' => $agents,
            'searchForm' => $searchForm->createView(),
            'repoAgentSecteur' => $this->repoAgentSecteur,
            'mySector' => $mySector
        ]);
    }


    /**
     * @Route("/coach/agent/add", name="coach_agent_add")
     */
    public function coach_agent_add(Request $request, SecteurRepository $secteurRepository, AgentSecteurRepository $tset)
    {
        $agent = new User();
        $coach = $this->getUser();

        $agentSecteur = new AgentSecteur();
        $coachAgent = new CoachAgent();
        $formUser = $this->createForm(InscriptionAgentType::class, $agent)
            ->remove('secteur')
            ->remove('username')
            ->remove('password')
            ->remove('ville')
            ->remove('numero_rue')
        ;
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $agentSecteur->setAgent($agent);
            $agentSecteur->setStatut(1);
            $secteur = $this->repoCoachSecteur->findBy(['coach' => $coach])[0]->getSecteur();
            $agentSecteur->setSecteur($secteur);
            $agent->setRoles([User::ROLE_AGENT]);
            $agent->setPassword(base64_encode('_dfdkf12132_1321df'));

            $coachAgent->setCoach($this->getUser());
            $coachAgent->setAgent($agent);
            $this->entityManager->save($agent);
            $this->entityManager->save($agentSecteur);
            $this->entityManager->save($coachAgent);

            $this->addFlash('success', $this->translator->trans('Informations enregistrées avec succès'));
            return $this->redirectToRoute('coach_agent_password_generate', ['id' => $agent->getId()]);

        }

        return $this->render('user_category/coach/agent/add_agent.html.twig', [
            'formUser' => $formUser->createView()
        ]);

    }


    /**
     * @Route("/coach/agent/{id}/password/generate", name="coach_agent_password_generate")
     */
    public function coach_agent_password_generate(Request $request, User $agent)
    {
        $formUserPassword = $this->createForm(UserLoginType::class);
        $formUserPassword->handleRequest($request);
        if ($formUserPassword->isSubmitted() && $formUserPassword->isValid()) {
            $agent->setActive(true);
            $agent->setUsername($request->request->get('user_login')['username']);
            $this->userManager->setUserPasword($agent, $request->request->get('user_login')['password']['first'], '', false);
            $this->addFlash('success', $this->translator->trans('Ajout de l\'utilisateur Agent efféctué avec succès'));
            return $this->redirectToRoute('coach_agent_list');
        }

        return $this->render('user_category/coach/agent/generate_password_agent.html.twig', [
            'formUserPassword' => $formUserPassword->createView(),
            'button' => 'Enregistrer'
        ]);
    }






    /**
     * @Route("/coach/agent/{id}/secteur/view", name="coach_agent_view")
     */
    public function coach_agent_view(User $agent, AgentSecteurService $agentSecteurService, CategorieFormationRepository $categorieFormationRepository, StatAgentService $statAgentService, RemunerationServiceSecu $remunerationServiceSecu)
    {
        $mySector = $this->repoCoachSecteur->findOneBy(['coach' => $this->getUser()])->getSecteur();
        $agentSecteur = $this->repoAgentSecteur->findOneBy(['secteur' => $mySector, 'agent' => $agent]);
        $agentSecteurs = $this->repoAgentSecteur->findBy(['agent' => $agent]);
        $secteurs = $agentSecteurService->getSecteurs($agentSecteurs);

        $positionSteps = [
            ['position' => 1, 'label' => 'Avoir au moins 5 filleuls directs et au moins 1000 € de CA'],
            ['position' => 2, 'label' => 'Avoir au moins 25 membres dans son équipe'],
            ['position' => 3, 'label' => 'Avoir au moins 100 membres dans son équipe'],
        ];

        $formationCategoriesOrdered = $categorieFormationRepository->getValidCategoriesOrderedSecteur($mySector->getId());

        $firstFormation = $this->repoFormation->findOrderedNonFinishedFormations($mySector, $agent);

        $chiffreAffaireTotal = 0;
        // if($mySector->getId() == $this->getParameter('secteur_digital_id')){
        $chiffreAffaireTotal = $statAgentService->getStat($agent->getId(), $mySector->getId(), $mySector->getType()->getId())['totalAmount'];
        // }
        if ($mySector->getId() != $this->getParameter('secteur_digital_id') && $mySector->getType()->getId() != $this->getParameter('type_secteur_securite_id')) {
            $statVente = $statAgentService->getStatVente($agent->getId(), $mySector->getId(), $mySector->getType()->getId());
            $pbb_summary = $statAgentService->getSummary($agent->getId(), $mySector->getId());
            $chiffreAffaireTotal = $pbb_summary['chiffreAffaire'] + ($statVente != null ? $statVente['ca'] : 0);
        }
        // }

        return $this->render('user_category/coach/agent/view_agent.html.twig', [
            'agent' => $agent,
            'agentSecteur' => $agentSecteur,
            'secteurs' => $secteurs,
            'repoCoachSecteur' => $this->repoCoachSecteur,
            'positionSteps' => $positionSteps,
            'formationCategoriesOrdered' => $formationCategoriesOrdered,
            'firstFormation' => $firstFormation,
            'chiffreAffaireTotal' => $chiffreAffaireTotal
        ]);
    }



    /**
     * Permet de valider le secteur en attente de l'agent
     * 
     * @Route("/coach/agent/secteur/{agentSecteur}/validate", name="coach_agent_secteur_validate")
     */
    public function coach_agent_secteur_validate(AgentSecteur $agentSecteur, Request $request): Response
    {
        $agentSecteur->setStatut(1);
        $agentSecteur->setDateValidation(new \DateTime());
        $this->entityManager->save($agentSecteur);
        $this->formationService->affecterToutFormation($agentSecteur->getAgent(), $agentSecteur->getSecteur());

        if ($request->query->get('pageReloaded') === 'true') {
            return $this->redirectToRoute('coach_agent_list');
        }

        return $this->json([
            'validation' => 'successfully'
        ], 200);
    }

    /**
     * Permet de bloquer un secteur validé de l'agent
     * 
     * @Route("/coach/agent/secteur/{agentSecteur}/invalidate", name="coach_agent_secteur_invalidate")
     * 
     */
    public function coach_agent_secteur_invalidate(AgentSecteur $agentSecteur, Request $request): Response
    {

        $agentSecteur->setStatut(0);
        $this->entityManager->save($agentSecteur);

        if ($request->query->get('pageReloaded') === 'true') {
            return $this->redirectToRoute('coach_agent_list');
        }

        return $this->json([
            'invalidation' => 'successfully'
        ], 200);

    }


      /**
     * @Route("/coach/agent-isole/list", name="coach_isolated_agent")
     */
    public function coachIsolatedAgentInNetwork(Request $request, PaginatorInterface $paginator)
    {

        /** @var User $coach */
        $coach = $this->getUser();
        $mySector = $this->repoCoachSecteur->findOneBy(['coach' => $this->getUser()])->getSecteur();
        $searchForm =  $this->createFormBuilder()
            ->add('name', TextType::class, [
                'label' => 'Nom ou prénom',
                'attr' => ['class' => 'form-control'], 
                'required' =>  false
            ])
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
                'attr' => ['class' => 'form-control'], 
                'required' =>  false
            ])
        ->getForm();

        $searchForm->handleRequest($request);
        $filter = $searchForm->getData() ?? [];

        $agents = $paginator->paginate(
            $this->repoUser->findRootUser(User::ROLE_AGENT,[],$filter),
            $request->query->getInt('page', 1),
            20
        );
        $agentsCaAmount = $this->statAgentService->addCaAmount($agents->getItems(),$mySector);
        return $this->render('user_category/coach/agent/list_agent_isole.html.twig', [
            'agents' => $agents,
            'searchForm' => $searchForm->createView(),
            'repoAgentSecteur' => $this->repoAgentSecteur,
            'mySector' => $mySector,
            'agentsCaAmount' => $agentsCaAmount

        ]);
    }


    /**     * @Route("/coach/view-global-network", name="coach_view_gloabl_network")
     */
    public function coach_global_network_view(Request $request)
    {
        $mySector = $this->repoCoachSecteur->findOneBy(['coach' => $this->getUser()])->getSecteur();
        $secteur_network =  $mySector?->getNom() ?? '';
        return $this->render('user_category/coach/agent/global_network_view.html.twig', [
            'secteurNetwork' => $secteur_network
        ]);
    }


     /**
     * @Route("/coach/global-tree/{secteur_network}", name="coach_global_data_lineaire")
     */
    public function getDataUnilevel(Request $request,$secteur_network = '')
    {
        $mySector = $this->repoCoachSecteur->findOneBy(['coach' => $this->getUser()])->getSecteur();
        $secteur_finance_id = $this->getParameter('secteur_finance_id');
        $limit =  $_ENV['LIMIT_NIVEAU_EQUIPE_LINEAIRE'] + 1;

        
        if($mySector->getId() == $_ENV['SECTEUR_DIGITAL_ID']){
            $unilevel = $this->agentService->getUnilevelGlobalChildren($limit);
            $unilevel = $this->statAgentService->addSummaryCaToUnilevel($unilevel);

        }elseif($mySector->getId() == $_ENV['SECTEUR_LITTLE_PONAILS_ID']){
            $unilevel = $this->agentService->getUnilevelGlobalChildren($limit);
            // $unilevel = $this->statAgentService->getLittlePonailsUnilevelChildren( $limit);
        }else{
            $data = ['equipe' => []];

            return new JsonResponse($data);
        }
        $data = ['equipe' => $unilevel];

        return new JsonResponse($data);
    }
}
