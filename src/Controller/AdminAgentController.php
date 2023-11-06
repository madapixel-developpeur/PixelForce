<?php


namespace App\Controller;

use App\Entity\CoachAgent;
use App\Entity\SearchEntity\UserSearch;
use App\Entity\User;
use App\Entity\AgentSecteur;
use App\Entity\PlanAgentAccount;
use App\Entity\Secteur;
use App\Form\InscriptionAgentType;
use App\Form\ResetPasswordType;
use App\Form\SecteurType;
use App\Form\UserSearchType;
use App\Form\AgentSecteurType;
use App\Form\MultipleSecteurType;
use App\Form\PlanAgentAccountType;
use App\Form\UserType;
use App\Manager\EntityManager;
use App\Manager\StripeManager;
use App\Manager\UserManager;
use App\Repository\CoachAgentRepository;
use App\Repository\SecteurRepository;
use App\Repository\UserRepository;
use App\Repository\AgentSecteurRepository;
use App\Repository\CoachSecteurRepository;
use App\Repository\PlanAgentAccountRepository;
use App\Repository\SubscriptionPlanAgentAccountRepository;
use App\Services\AgentSecteurService;
use App\Services\StripeService;
use App\Services\User\AgentService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class AdminAgentController extends AbstractController
{
    protected $repoUser;
    protected $entityManager;
    protected $userManager;
    protected $repoCoachAgent;
    protected $repoAgentSecteur;
    protected $repoSecteur;
    protected $agentSecteurService;
    protected $repoCoachSecteur;
    protected $stripeService;
    protected $agentService;
    protected $repoPlanAgentAccount;
    protected $stripeManager;
    protected $repoSubscriptionPlanAgentAccount;
    
    public function __construct(UserRepository $repoUser,
                                EntityManager $entityManager,
                                UserManager $userManager,
                                CoachAgentRepository $repoCoachAgent,
                                AgentSecteurRepository $repoAgentSecteur,
                                SecteurRepository $repoSecteur,
                                AgentSecteurService $agentSecteurService,
                                CoachSecteurRepository $repoCoachSecteur,
                                StripeService $stripeService,
                                AgentService $agentService,
                                PlanAgentAccountRepository $repoPlanAgentAccount,
                                StripeManager $stripeManager,
                                SubscriptionPlanAgentAccountRepository $repoSubscriptionPlanAgentAccount
    )
    {
        $this->repoUser = $repoUser;
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->repoCoachAgent = $repoCoachAgent;
        $this->repoAgentSecteur = $repoAgentSecteur;
        $this->repoSecteur = $repoSecteur;
        $this->agentSecteurService = $agentSecteurService;
        $this->repoCoachSecteur = $repoCoachSecteur;
        $this->stripeService = $stripeService;
        $this->agentService = $agentService;
        $this->repoPlanAgentAccount = $repoPlanAgentAccount;
        $this->stripeManager = $stripeManager;
        $this->repoSubscriptionPlanAgentAccount = $repoSubscriptionPlanAgentAccount;
    }

    /**
     * @Route("/admin/agent/liste", name="admin_agent_list")
     */
    public function admin_agent_list(Request $request, PaginatorInterface $paginator)
    {
        $search = new UserSearch();
        $searchForm = $this->createForm(UserSearchType::class, $search)->remove('tag');
        $searchForm->handleRequest($request);
        
        $agents = $paginator->paginate(
            $this->repoUser->findCoachOrAgentQuery($search, User::ROLE_AGENT),
            $request->query->getInt('page', 1),
            20
        );
        // dd($agents[12]);

        return $this->render('user_category/admin/agent/list_agents.html.twig', [
            'agents' => $agents,
            'searchForm' => $searchForm->createView(),
            'repoAgentSecteur' => $this->repoAgentSecteur
        ]);
    }

    /**
     * @Route("/admin/agent/{id}/view", name="admin_agent_view", options={"expose"=true})
     */
    public function admin_agent_view(User $agent,  AgentSecteurService $agentSecteurService, SecteurRepository $secteurRepository)
    {
        $agentSecteurs = $this->repoAgentSecteur->findBy(['agent' => $agent]);
        $secteurs = $agentSecteurService->getSecteurs($agentSecteurs);
        $secteursForEdition = $secteurRepository->findAll();
        $formSecteur = $this->createForm(MultipleSecteurType::class);

        return $this->render('user_category/admin/agent/view_agent.html.twig', [
            'agent' => $agent,
            'agentSecteurs' => $agentSecteurs,
            'secteurs' => $secteurs,
            'repoCoachSecteur' => $this->repoCoachSecteur,
            'formSecteur' => $formSecteur->createView(),
            'secteursForEdition' => $secteursForEdition
        ]);
    }


    /**
     * @Route("/admin/agent/{id}/edit", name="admin_agent_edit")
     */
    public function admin_agent_edit(Request $request, User $agent, SecteurRepository $secteurRepository)
    {
        $formUser = $this->createForm(InscriptionAgentType::class, $agent)
            ->remove('secteur')
            ->remove('username')
            ->remove('password')
        ;
        $formSecteur = $this->createForm(AgentSecteurType::class);
        
        $secteurs = $secteurRepository->findAll();
        $myAgentSecteurs = $this->repoAgentSecteur->findBy(['agent' => $agent]);

        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $this->entityManager->save($agent);
            $this->addFlash('success', "Modification du agent avec succès");
            return $this->redirectToRoute('admin_agent_list');    
        }

        return $this->render('user_category/admin/agent/edit_agent.html.twig', [
            'formUser' => $formUser->createView(),
            'formSecteur' => $formSecteur->createView(),
            'button' => 'Enregistrer',
            'secteurs' => $secteurs,
            'myAgentSecteurs' => $myAgentSecteurs,
            'agent' => $agent
        ]);    
    }

    /**
     * @Route("/admin/agent/{id}/password/generate", name="admin_agent_password_generate")
     */
    public function admin_agent_password_generate(Request $request, User $agent)
    {
        $formUserPassword = $this->createForm(ResetPasswordType::class);
        $formUserPassword->handleRequest($request);
        if ($formUserPassword->isSubmitted() && $formUserPassword->isValid()) {
            $agent->setActive(true);
            $this->userManager->setUserPasword($agent, $request->request->get('reset_password')['password']['first'], '', false);
            $this->addFlash('success', 'Utilisateur agent ajouté avec succès');
            return $this->redirectToRoute('admin_agent_list');    
        }


        return $this->render('user_category/admin/agent/generate_password_agent.html.twig', [
            'formUserPassword' => $formUserPassword->createView(),
            'button' => 'Enregistrer'
        ]);
    }


    /**
     * @Route("/admin/agent/{id}/delete", name="admin_agent_delete")
     */
    public function admin_agent_delete(User $agent, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'. $agent->getId(), $request->get('_token'))) {
            $agent->setActive(-1);
            $this->entityManager->save($agent);

            $this->addFlash( 'danger', 'L\'agent a été banni du plateforme avec succès');
        }
        return $this->redirectToRoute('admin_agent_list');    
    }

    /**
     * @Route("/admin/agent/{id}/reactiver", name="admin_agent_reactiver")
     */
    public function admin_agent_reactiver(User $coach, Request $request)
    {

        $coach->setActive(1);
        $this->entityManager->save($coach);

        $this->addFlash('success', 'Le compte de l\'agent a été réactivé');

        return $this->redirectToRoute('admin_agent_list');
    }

    /**
     * @Route("/admin/agent/secteur/multiple/add", name="admin_agent_secteur_multiple_add")
     * @param Request $request
     * @param CoachSecteurRepository $coachSecteurRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function admin_agent_secteur_multiple_add(Request $request, CoachSecteurRepository $coachSecteurRepository)
    {
        $data = $_POST;
        $errorMessages = [];
        $secteurAdded = [];

        foreach ($data["selectedSecteurId"] as $index => $sectuerId) {
       
        /** @var Secteur @secteur */
            $secteur = $this->repoSecteur->find($sectuerId);

            // On gère le cas, où il y a une duplication du secteur
            $agent = $this->repoUser->find($data["userId"]);
            $myAllAgentSecteurs = $this->repoAgentSecteur->findBy(['agent' => $agent]);
            $isNewSectorInArray =  $this->agentSecteurService->isNewSectorInArray($secteur, $myAllAgentSecteurs);
            if ($isNewSectorInArray) {
                $errorMessages[] = 'Duplication secteur ' . $secteur->getNom() .'<br>';  
            }else{
                // Si il n'y a pas de doublon, on sauvegarde la modification
                if ($request->getMethod() === "POST") {
                    $agentSecteur  = new AgentSecteur();
                    $agentSecteur->setAgent($agent);
                    $agentSecteur->setSecteur($secteur);
                    $agentSecteur->setStatut(1);
                    $agentSecteur->setDateValidation(new \DateTime());
                    $this->entityManager->save($agentSecteur);


                    $secteurAdded['secteur'.$index]['nom'] = $secteur->getNom();
                    $secteurAdded['secteur'.$index]['dateValidation'] = (new \DateTime())->format('d/m/Y');
                    $secteurAdded['secteur'.$index]['agentSecteurId'] = $agentSecteur->getId();
                }
            }
        }

    
        return $this->json([
            'errorMessages' => $errorMessages,
            'secteurAdded' => $secteurAdded
        ], 200); 
    }    

    /**
     * @Route("/admin/agent/secteur/{agentSecteur}/edit", name="admin_agent_secteur_edit", requirements={"agentSecteur"="\d+"})
     */
    public function admin_agent_secteur_edit(AgentSecteur $agentSecteur, Request $request)
    {
        $data = $_POST;
        $secteur = $this->repoSecteur->find($data["newSecteurId"]);
        
        // On gère le cas, où il y a une duplication du secteur
        $agent = $this->repoUser->find($data["userId"]);
        $myAllAgentSecteurs = $this->repoAgentSecteur->findBy(['agent' => $agent]);
        $isNewSectorInArray =  $this->agentSecteurService->isNewSectorInArray($secteur, $myAllAgentSecteurs);
        if ($isNewSectorInArray) {
            return $this->json([
                'edit' => 'error',
                'cause' => 'duplication_sector'
            ], 200); 
        }

        // Si il n'y a pas de doublon, on sauvegarde la modification
        if ($request->getMethod() === "POST") {
            $agentSecteur->setSecteur($secteur);
            $this->entityManager->save($agentSecteur);

            return $this->json([
                'edit' => 'successfully',
                'newSector' => $secteur->getNom()
            ], 200);    
        }
    }

    /**
     * @Route("/admin/agent/secteur/editOne", name="admin_agent_secteur_editOne")
     */
    public function admin_agent_secteur_editOne(Request $request)
    {
        if($request->getMethod() === 'POST') {
            $agentSecteurId = $request->request->get('agentSecteur');
            $secteur = $request->request->get('secteur');
            if($agentSecteurId && $secteur) {
                $agentSecteur = $this->repoAgentSecteur->findOneBy(['id' => $agentSecteurId]);
                $secteur = $this->repoSecteur->findOneBy(['id' => $secteur]);
                $agentSecteur->setSecteur($secteur);
                $this->entityManager->save($agentSecteur);
                $this->addFlash('success', 'Le secteur a été changé avec succès');
                return $this->redirectToRoute('admin_agent_view', ['id' => $request->request->get('agent_id')]);
            }
        }

        $this->addFlash('danger', 'Aucun paramètre posté');

        return $this->redirectToRoute('admin_agent_list');

    }

    /**
     * Permet de valider le secteur en attente de l'agent
     * 
     * @Route("/admin/agent/secteur/{agentSecteur}/validate", name="admin_agent_secteur_validate")
     */
    public function admin_agent_secteur_validate(AgentSecteur $agentSecteur, Request $request): Response
    {
        $agentSecteur->setStatut(1);
        $agentSecteur->setDateValidation(new \DateTime());
        $this->entityManager->save($agentSecteur);
        return $this->json([
            'validation' => 'successfully'
        ], 200); 
        
    }

    /**
     * Permet de bloquer un secteur validé de l'agent
     * 
     * @Route("/admin/agent/secteur/{agentSecteur}/invalidate", name="admin_agent_secteur_invalidate")
     */
    public function admin_agent_secteur_invalidate(AgentSecteur $agentSecteur, Request $request): Response
    {
        $agentSecteur->setStatut(0);
        $this->entityManager->save($agentSecteur);
        return $this->json([
            'invalidation' => 'successfully'
        ], 200); 
        
    }

    /**
     * @Route("/admin/agent/attribuerFormation/{id}", name="admin_agent_attribuerFormation")
     */
    public function admin_agent_attributionFormation(User $user, AgentSecteurRepository $agentSecteurRepository)
    {
        if(in_array(User::ROLE_AGENT,$user->getRoles())) {
            $secteurs = $user->getSecteursByAgent();
            return $this->render('user_category/admin/agent/attribuerFormation.html.twig', [
                'secteurs' => $secteurs,
                'repoAgentSecteur' => $agentSecteurRepository,
                'agent' => $user
            ]);
        }
        $this->addFlash('danger', 'Erreur : '.$user->getNom().' n\'est pas un agent');
        return $this->redirectToRoute('admin_agent_list');
    }

    /**
     * @Route("/admin/agent/subscription/price/list", name="admin_agent_subscription_price_list")
     */
    public function admin_agent_subscription_price_list(): Response
    {
        $allPlanAgentAccount = $this->repoPlanAgentAccount->findBy(['status' => StripeService::PLAN_STATUS['ACTIVE'], 'statusChange' => StripeService::STATUS_CHANGE['ACTIVE']] );
        
        return $this->render('user_category/admin/agent/subscription/price/list_subscription.html.twig', [
            'allPlanAgentAccount' => $allPlanAgentAccount,
            'STATUS_CHANGE' => StripeService::STATUS_CHANGE,
            'repoPlan' => $this->repoPlanAgentAccount
        ]);
    }

    /**
     * @Route("/admin/agent/subscription/{id}/price/view", name="admin_agent_subscription_price_view")
     */
    public function admin_agent_subscription_price_view(PlanAgentAccount $planAgentAccount, Request $request)
    {   
        $allSubscriptionsInOldPrice = $this->repoSubscriptionPlanAgentAccount->findBy(['stripePriceId' => $planAgentAccount->getStripePriceId()]);

        $formStripe = $this->createForm(PlanAgentAccountType::class)
            ->remove('priceName')
            ->remove('planDescription')
        ;
        $formStripe->handleRequest($request);
        if ($formStripe->isSubmitted() && $formStripe->isValid()) {
            $amount = $_POST['plan_agent_account']['amount'];
            $interval_unit = $this->stripeService->getIntervalUnitToEnglish($planAgentAccount->getPriceIntervalUnit());
            // $planDescription = $_POST['plan_agent_account']['planDescription'];
            // $this->agentService->create_PlanAgentAccount($amount, StripeService::INTERVAL_UNIT_MONTH, $priceName, $planDescription);
            
            $newPlanAgentAccount = $this->stripeManager->persistMigrateAbonnement($amount, $interval_unit, $planAgentAccount->getStripePriceName(), $planAgentAccount->getDescription(), $planAgentAccount->getStipeProductId(), $planAgentAccount->getStripePriceId(), $planAgentAccount);
            $this->addFlash('success', "Modification réussie. </br> L'abonnement ". $planAgentAccount->getAmount(). " € a été mis à niveau de " . $amount ." €");
            return $this->redirectToRoute('admin_agent_subscription_price_view', ['id' => $newPlanAgentAccount->getId()]);    
        }

        return $this->render('user_category/admin/agent/subscription/price/view_price.html.twig', [
            'planAgentAccount' => $planAgentAccount,
            'formStripe' => $formStripe->createView(),
            'allSubscriptionsInOldPrice' => $allSubscriptionsInOldPrice,
            'repoUser' => $this->repoUser,
            'STATUS_CHANGE' => StripeService::STATUS_CHANGE,
            'repoPlan' => $this->repoPlanAgentAccount
        ]);
    }

    /**
     * @Route("admin/agent/subscription/price/create", name="admin_agent_subscription_price_create_page")
     */
    public function admin_agent_subscription_price_create_page(Request $request): Response
    {
        $formStripe = $this->createForm(PlanAgentAccountType::class);

        $formStripe->handleRequest($request);

        if ($formStripe->isSubmitted() && $formStripe->isValid()) {
            $amount = $_POST['plan_agent_account']['amount'];
            $priceName = $_POST['plan_agent_account']['priceName'];
            $planDescription = $_POST['plan_agent_account']['planDescription'];
            $this->agentService->create_PlanAgentAccount($amount, StripeService::INTERVAL_UNIT_MONTH, $priceName, $planDescription);
            $this->addFlash('success', "Création prix d'abonnement avec succès");
            return $this->redirectToRoute('admin_agent_list');    
        }

        return $this->render('user_category/admin/agent/subscription/price/create_price.html.twig', [
            'formStripe' => $formStripe->createView()
        ]);
    }

}
