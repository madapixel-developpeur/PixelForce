<?php

namespace App\Controller;

use App\Entity\AgentSecteur;
use App\Entity\CoachAgent;
use App\Entity\SearchEntity\UserSearch;
use App\Entity\Secteur;
use App\Entity\User;
use App\Form\InscriptionAgentType;
use App\Form\MultipleSecteurType;
use App\Form\ResetPasswordType;
use App\Form\UserLoginType;
use App\Form\UserSearchType;
use App\Form\UserType;
use App\Manager\EntityManager;
use App\Manager\UserManager;
use App\Repository\AgentSecteurRepository;
use App\Repository\CoachAgentRepository;
use App\Repository\CoachSecteurRepository;
use App\Repository\SecteurRepository;
use App\Repository\UserRepository;
use App\Services\AgentSecteurService;
use App\Services\FormationService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    public function __construct(FormationService $formationService,
                                CoachAgentRepository $coachAgentRepository,
                                UserRepository $repoUser,
                                UserManager $userManager,
                                EntityManager $entityManager,
                                CoachSecteurRepository $repoCoachSecteur,
                                AgentSecteurRepository $repoAgentSecteur)
    {
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

        if($formUser->isSubmitted() && $formUser->isValid()) {
            $agentSecteur->setAgent($agent);
            $agentSecteur->setStatut(1);
            $secteur = $this->repoCoachSecteur->findBy(['coach' => $coach])[0]->getSecteur();
            $agentSecteur->setSecteur($secteur);
            $agent->setRoles([ User::ROLE_AGENT ]);
            $agent->setPassword(base64_encode('_dfdkf12132_1321df'));

            $coachAgent->setCoach($this->getUser());
            $coachAgent->setAgent($agent);
            $this->entityManager->save($agent);
            $this->entityManager->save($agentSecteur);
            $this->entityManager->save($coachAgent);

            $this->addFlash('success', 'Informations enregistrées avec succès');
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
            $this->addFlash('success', 'Ajout de l\'utilisateur Agent efféctué avec succès');
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
    public function coach_agent_view(User $agent,  AgentSecteurService $agentSecteurService)
    {
        $mySector = $this->repoCoachSecteur->findOneBy(['coach' => $this->getUser()])->getSecteur();
        $agentSecteur = $this->repoAgentSecteur->findOneBy(['secteur' => $mySector, 'agent' => $agent]);
        $agentSecteurs = $this->repoAgentSecteur->findBy(['agent' => $agent]);
        $secteurs = $agentSecteurService->getSecteurs($agentSecteurs);

        return $this->render('user_category/coach/agent/view_agent.html.twig', [
            'agent' => $agent,
            'agentSecteur' => $agentSecteur,
            'secteurs' => $secteurs,
            'repoCoachSecteur' =>  $this->repoCoachSecteur,
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
}
