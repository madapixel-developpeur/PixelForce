<?php


namespace App\Controller;

use App\Entity\CoachSecteur;
use App\Entity\SearchEntity\UserSearch;
use App\Entity\Secteur;
use App\Entity\User;
use App\Form\AgentSecteurType;
use App\Form\CoachSecteurType;
use App\Form\ResetPasswordType;
use App\Form\SecteurType;
use App\Form\UserLoginType;
use App\Form\UserSearchType;
use App\Form\UserSecteurType;
use App\Services\FileHandler;
use App\Form\UserType;
use App\Manager\EntityManager;
use App\Manager\UserManager;
use App\Repository\CoachAgentRepository;
use App\Repository\CoachSecteurRepository;
use App\Repository\SecteurRepository;
use App\Repository\UserRepository;
use App\Services\AgentSecteurService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCoachController extends AbstractController
{
    protected $repoUser;
    protected $entityManager;
    protected $userManager;

    protected $repoCoachAgent;

    protected $repoSecteur;

    protected $repoCoachSecteur;

    protected $fileHandler;

    public function __construct(UserRepository $repoUser,
                                EntityManager $entityManager,
                                UserManager $userManager,
                                CoachAgentRepository $repoCoachAgent,
                                FileHandler $fileHandler,
                                SecteurRepository $repoSecteur,
                                CoachSecteurRepository $repoCoachSecteur)
    {
        $this->repoUser = $repoUser;
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->repoCoachAgent = $repoCoachAgent;
        $this->repoSecteur = $repoSecteur;
        $this->repoCoachSecteur = $repoCoachSecteur;
        $this->fileHandler = $fileHandler;
    }

    /**
     * @Route("/admin/coach/liste", name="admin_coach_list")
     */
    public function admin_coach_list(Request $request, PaginatorInterface $paginator)
    {
        $search = new UserSearch();
        $searchForm = $this->createForm(UserSearchType::class, $search)->remove('tag');
        $searchForm->handleRequest($request);
        // dd($this->repoUser->findCoachOrAgentQuery($search, User::ROLE_COACH));
        $coachs = $paginator->paginate(
            $this->repoUser->findCoachQuery($search, User::ROLE_COACH),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/admin/coach/list_coachs.html.twig', [
            'coachs' => $coachs,
            'searchForm' => $searchForm->createView(),
            'repoCoachSecteur' => $this->repoCoachSecteur
        ]);
    }

    /**
     * @Route("/admin/coach/{id}/view", name="admin_coach_view")
     */
    public function admin_coach_view(User $coach,Request $request, AgentSecteurService $agentSecteurService, PaginatorInterface $paginator)
    {
        $coachtSecteurs = $this->repoCoachSecteur->findBy(['coach' => $coach]);
        $secteurs = $agentSecteurService->getSecteurs($coachtSecteurs);
        $result=$this->repoUser->findBy(['parrain'=>$coach->getId()]);
        $filleuil = $paginator->paginate(
            $result,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('user_category/admin/coach/view_coach.html.twig', [
            'coach' => $coach,
            'secteurs' => $secteurs,
            'coachtSecteurs' => $coachtSecteurs,
            'filleuil'=>$filleuil
        ]);
    }

    /**
     * @Route("/admin/coach/add", name="admin_coach_add")
     */
    public function admin_coach_add(Request $request)
    {
        $coach = new User();

        $formUser = $this->createForm(UserType::class, $coach)
            ->add('email')
        ;
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $imageCouverture = $formUser->get('photo')->getData();
                if ($imageCouverture) {
                    $photo = $this->fileHandler->upload($imageCouverture, "images\secteur\photo");
                    $coach->setPhoto($photo);
                }
            $coach->setRoles([USER::ROLE_COACH]);
            $coach->setPassword(base64_encode('_dfdkf12132_1321df'));
            
            $this->entityManager->save($coach);

            $this->addFlash('primary', "Information enregistrée avec succès, choisissez son secteur");
            return $this->redirectToRoute('admin_coach_secteur_relate', ['id' =>  $coach->getId()]);    
        }

        return $this->render('user_category/admin/coach/add_coach.html.twig', [
            'formUser' => $formUser->createView(),
            'button' => 'Suivant'
        ]);    
    }

    /**
     * @Route("/admin/coach/{id}/edit", name="admin_coach_edit")
     */
    public function admin_coach_edit(Request $request, User $coach)
    {
        $formUser = $this->createForm(UserType::class, $coach)
        ->remove('username')    
        ->add('email')
        ;
       
        $coachSecteur = $this->repoCoachSecteur->findBy(['coach' => $coach]);
        if ($coachSecteur) {
            $coachSecteur = $coachSecteur[0];
        }
       
        $formSecteur = $this->createForm(CoachSecteurType::class);

        $formUser->handleRequest($request);
        //dd($formUser);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $imageCouverture = $formUser->get('photo')->getData();
                if ($imageCouverture) {
                    $photo = $this->fileHandler->upload($imageCouverture, "images\secteur\photo");
                    $coach->setPhoto($photo);
                }
            $this->entityManager->save($coach);
            $this->addFlash('success', "Modification du coach avec succès");
            return $this->redirectToRoute('admin_coach_list');    
        }

        return $this->render('user_category/admin/coach/edit_coach.html.twig', [
            'formUser' => $formUser->createView(),
            'coach' => $coach,
            'coachSecteur' => $coachSecteur,
            'formSecteur' => $formSecteur->createView()
        ]);    
    }

    /**
     * @Route("/admin/coach/{id}/secteur/relate", name="admin_coach_secteur_relate")
     */
    public function admin_coach_secteur_relate(Request $request, User $coach)
    {
        $coachSecteur = new CoachSecteur();
        $formCoachSecteur = $this->createFormBuilder($coachSecteur)
            ->add('secteur', EntityType::class, [
                'label'=> false,
                'class'=> Secteur::class,
                'choice_label' => 'nom'
            ])
            ->getForm()
        ;
        $formCoachSecteur->handleRequest($request);

        $button = 'Suivant';
        if ($request->query->get('edition') === 'attribution_only') {
            $button = 'Enregistrer';
        }
        
        if ($formCoachSecteur->isSubmitted() && $formCoachSecteur->isValid()) {
            $coachRelations = $this->repoCoachSecteur->findBy(['coach' => $coach]);
            if(count($coachRelations) > 0) {
                $this->entityManager->removeMultiple($coachRelations);
            }
            $secteurId = $request->request->get('form')['secteur'];
            $coach->setActive(true);
            $coachSecteur->setCoach($coach);
            $coachSecteur->setSecteur($this->repoSecteur->find($secteurId));
            $this->entityManager->save($coachSecteur);

            if ($request->query->get('edition') === 'attribution_only') {
                $this->addFlash('success', 'Secteur attribué avec succès');
                return $this->redirectToRoute('admin_coach_list');    
            }

            $this->addFlash('primary', "Secteur choisi avec succès");
            return $this->redirectToRoute('admin_coach_password_generate', ['id' => $coach->getId()]);    
        }
        return $this->render('user_category/admin/coach/relate_secteur.html.twig', [
            'formCoachSecteur' => $formCoachSecteur->createView(),
            'coach' => $coach,
            'button' => $button
        ]);
    }

    /**
     * @Route("/admin/coach/{id}/password/generate", name="admin_coach_password_generate")
     */
    public function admin_coach_password_generate(Request $request, User $coach)
    {
        $formUserPassword = $this->createForm(UserLoginType::class);
        $formUserPassword->handleRequest($request);
        if ($formUserPassword->isSubmitted() && $formUserPassword->isValid()) {
            $coach->setActive(true);
            $coach->setUsername($request->request->get('user_login')['username']);
            $this->userManager->setUserPasword($coach, $request->request->get('user_login')['password']['first'], '', false);
            $this->addFlash('success', 'Les informations sur le nouveau coach ont été bien enregistrées');
            return $this->redirectToRoute('admin_coach_list');    
        }


        return $this->render('user_category/admin/coach/generate_password_coach.html.twig', [
            'formUserPassword' => $formUserPassword->createView(),
            'button' => 'Enregistrer'
        ]);
    }


    /**
     * @Route("/admin/coach/{id}/delete", name="admin_coach_delete")
     */
    public function admin_coach_delete(User $coach, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'. $coach->getId(), $request->get('_token'))) {
           $coach->setActive(-1);
           $this->entityManager->save($coach);

            $this->addFlash('danger', 'Le coach a été banni du plateforme');
        }
        return $this->redirectToRoute('admin_coach_list');    
    }

    /**
     * @Route("/admin/coach/{id}/reactiver", name="admin_coach_reactiver")
     */
    public function admin_coach_reactiver(User $coach, Request $request)
    {

        $coach->setActive(1);
        $this->entityManager->save($coach);

        $this->addFlash('success', 'Le compte du coach a été réactivé');

        return $this->redirectToRoute('admin_coach_list');
    }
    
    
    /**
     * @Route("/admin/coach/secteur/{coachSecteur}/edit", name="admin_coach_secteur_edit")
     */
    public function admin_coach_secteur_edit(CoachSecteur $coachSecteur, Request $request)
    {
        $data = $_POST;

        $secteur = $this->repoSecteur->find($data["newSecteurId"]);
        
        // Si il n'y a pas de doublon, on sauvegarde la modification
        if ($request->getMethod() === "POST") {
            $coachSecteur->setSecteur($secteur);
            $this->entityManager->save($coachSecteur);

            return $this->json([
                'edit' => 'successfully',
                'newSector' => $secteur->getNom()
            ], 200);    
        }
    }    
}
