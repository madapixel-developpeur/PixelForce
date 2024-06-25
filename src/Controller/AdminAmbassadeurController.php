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

class AdminAmbassadeurController extends AbstractController
{
    protected $repoUser;
    protected $entityManager;
    protected $userManager;

    protected $repoCoachAgent;

    protected $repoSecteur;

    protected $repoCoachSecteur;

    public function __construct(UserRepository $repoUser,
                                EntityManager $entityManager,
                                UserManager $userManager,
                                CoachAgentRepository $repoCoachAgent,
                                SecteurRepository $repoSecteur,
                                CoachSecteurRepository $repoCoachSecteur)
    {
        $this->repoUser = $repoUser;
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->repoCoachAgent = $repoCoachAgent;
        $this->repoSecteur = $repoSecteur;
        $this->repoCoachSecteur = $repoCoachSecteur;
    }

    /**
     * @Route("/admin/ambassadeur/liste", name="admin_ambassadeur_list")
     */
    public function admin_ambassadeur_list(Request $request, PaginatorInterface $paginator)
    {
        $search = new UserSearch();
        $searchForm = $this->createForm(UserSearchType::class, $search)->remove('tag');
        $searchForm->handleRequest($request);
        // dd($this->repoUser->findCoachOrAgentQuery($search, User::ROLE_COACH));
        $coachs = $paginator->paginate(
            $this->repoUser->findCoachQuery($search, User::ROLE_AMBASSADEUR),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/admin/ambassadeur/list_ambassadeur.html.twig', [
            'coachs' => $coachs,
            'searchForm' => $searchForm->createView(),
            'repoCoachSecteur' => $this->repoCoachSecteur
        ]);
    }

    /**
     * @Route("/admin/ambassadeur/{id}/view", name="admin_ambassadeur_view")
     */
    public function admin_ambassadeur_view(User $ambassadeur,Request $request, AgentSecteurService $agentSecteurService, PaginatorInterface $paginator)
    {
        $coachtSecteurs = $this->repoCoachSecteur->findBy(['coach' => $ambassadeur]);
        $secteurs = $agentSecteurService->getSecteurs($coachtSecteurs);
        $result=$this->repoUser->findBy(['parrain'=>$ambassadeur->getId()]);
        $filleul = $paginator->paginate(
            $result,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('user_category/admin/ambassadeur/view_ambassadeur.html.twig', [
            'ambassadeur' => $ambassadeur,
            'secteurs' => $secteurs,
            'coachtSecteurs' => $coachtSecteurs,
            'filleul'=>$filleul
        ]);
    }

    /**
     * @Route("/admin/ambassadeur/add", name="admin_ambassadeur_add")
     */
    public function admin_ambassadeur_add(Request $request)
    {
        $coach = new User();

        $formUser = $this->createForm(UserType::class, $coach)
            ->remove('lienCalendly')
            ->remove('photo')
            ->add('email')
        ;
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $coach->setRoles([USER::ROLE_AMBASSADEUR]);
            $coach->setPassword(base64_encode('_dfdkf12132_1321df'));
            
            $this->entityManager->save($coach);

            $this->addFlash('primary', "Information enregistrée avec succès, choisissez son secteur");
            return $this->redirectToRoute('admin_ambassadeur_secteur_relate', ['id' =>  $coach->getId()]);    
        }

        return $this->render('user_category/admin/ambassadeur/add_ambassadeur.html.twig', [
            'formUser' => $formUser->createView(),
            'button' => 'Suivant'
        ]);    
    }

    /**
     * @Route("/admin/ambassadeur/{id}/edit", name="admin_ambassadeur_edit")
     */
    public function admin_ambassadeur_edit(Request $request, User $ambassadeur)
    {
        $formUser = $this->createForm(UserType::class, $ambassadeur)
            ->remove('photo')
            ->add('email')
            ->remove('lienCalendly')
        ;
       
        $coachSecteur = $this->repoCoachSecteur->findBy(['coach' => $ambassadeur]);
        if ($coachSecteur) {
            $coachSecteur = $coachSecteur[0];
        }
       
        $formSecteur = $this->createForm(CoachSecteurType::class);

        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $this->entityManager->save($ambassadeur);
            $this->addFlash('success', "Modification du coach avec succès");
            return $this->redirectToRoute('admin_ambassadeur_list');    
        }

        return $this->render('user_category/admin/ambassadeur/edit_ambassadeur.html.twig', [
            'formUser' => $formUser->createView(),
            'coach' => $ambassadeur,
            'coachSecteur' => $coachSecteur,
            'formSecteur' => $formSecteur->createView()
        ]);    
    }

    /**
     * @Route("/admin/ambassadeur/{id}/secteur/relate", name="admin_ambassadeur_secteur_relate")
     */
    public function admin_ambassadeur_secteur_relate(Request $request, User $ambassadeur)
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
            $coachRelations = $this->repoCoachSecteur->findBy(['coach' =>$ambassadeur]);
            if(count($coachRelations) > 0) {
                $this->entityManager->removeMultiple($coachRelations);
            }
            $secteurId = $request->request->get('form')['secteur'];
            $ambassadeur->setActive(true);
            $coachSecteur->setCoach($ambassadeur);
            $coachSecteur->setSecteur($this->repoSecteur->find($secteurId));
            $this->entityManager->save($coachSecteur);

            if ($request->query->get('edition') === 'attribution_only') {
                $this->addFlash('success', 'Secteur attribué avec succès');
                return $this->redirectToRoute('admin_ambassadeur_list');    
            }

            $this->addFlash('primary', "Secteur choisi avec succès");
            return $this->redirectToRoute('admin_ambassadeur_password_generate', ['id' => $ambassadeur->getId()]);    
        }
        return $this->render('user_category/admin/ambassadeur/relate_secteur.html.twig', [
            'formCoachSecteur' => $formCoachSecteur->createView(),
            'coach' => $ambassadeur,
            'button' => $button
        ]);
    }

    /**
     * @Route("/admin/ambassadeur/{id}/password/generate", name="admin_ambassadeur_password_generate")
     */
    public function admin_ambassadeur_password_generate(Request $request, User $ambassadeur)
    {
        $formUserPassword = $this->createForm(UserLoginType::class);
        $formUserPassword->handleRequest($request);
        if ($formUserPassword->isSubmitted() && $formUserPassword->isValid()) {
            $ambassadeur->setActive(true);
            $ambassadeur->setUsername($request->request->get('user_login')['username']);
            $this->userManager->setUserPasword($ambassadeur, $request->request->get('user_login')['password']['first'], '', false);
            $this->addFlash('success', 'Les informations sur le nouveau ambassadeur ont été bien enregistrées');
            return $this->redirectToRoute('admin_ambassadeur_list');    
        }


        return $this->render('user_category/admin/ambassadeur/generate_password_ambassadeur.html.twig', [
            'formUserPassword' => $formUserPassword->createView(),
            'button' => 'Enregistrer'
        ]);
    }


    /**
     * @Route("/admin/ambassadeur/{id}/delete", name="admin_ambassadeur_delete")
     */
    public function admin_ambassadeur_delete(User $ambassadeur, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'. $ambassadeur->getId(), $request->get('_token'))) {
            $ambassadeur->setActive(-1);
           $this->entityManager->save($ambassadeur);

            $this->addFlash('danger', 'L\'Ambassadeur a été banni du plateforme');
        }
        return $this->redirectToRoute('admin_ambassadeur_list');    
    }

    /**
     * @Route("/admin/ambassadeur/{id}/reactiver", name="admin_ambassadeur_reactiver")
     */
    public function admin_ambassadeur_reactiver(User $ambassadeur, Request $request)
    {

        $ambassadeur->setActive(1);
        $this->entityManager->save($ambassadeur);

        $this->addFlash('success', 'L\'Ambassadeur a été réactivé');

        return $this->redirectToRoute('admin_ambassadeur_list');
    }
    
    
    /**
     * @Route("/admin/ambassadeur/secteur/{coachSecteur}/edit", name="admin_coach_secteur_edit")
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
