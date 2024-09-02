<?php


namespace App\Controller;

use App\Entity\CoachSecteur;
use App\Entity\SearchEntity\SecteurSearch;
use App\Entity\Secteur;
use App\Entity\User;
use App\Form\SecteurSearchType;
use App\Form\SecteurType;
use App\Manager\EntityManager;
use App\Manager\UserManager;
use App\Repository\CoachAgentRepository;
use App\Repository\CoachSecteurRepository;
use App\Repository\SecteurRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Services\FileHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminSecteurController extends AbstractController
{
    protected $repoUser;
    protected $entityManager;
    protected $userManager;
    protected $repoCoachAgent;
    protected $repoSecteur;
    protected $repoCoachSecteur;
    private $fileHandler;

    public function __construct(
        UserRepository $repoUser,
        EntityManager $entityManager,
        UserManager $userManager,
        CoachAgentRepository $repoCoachAgent,
        SecteurRepository $repoSecteur,
        FileHandler $fileHandler,
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
     * @Route("/admin/secteur/liste", name="admin_sector_list")
     */
    public function admin_sector_list(Request $request, PaginatorInterface $paginator)
    {
        $secteurSearch = new SecteurSearch();
        $sectorFormSearch = $this->createForm(SecteurSearchType::class, $secteurSearch);
        $sectorFormSearch->handleRequest($request);
        $sectors = $paginator->paginate(
            $this->repoSecteur->filter($secteurSearch),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/admin/sector/list_sectors.html.twig', [
            'sectors' => $sectors,
            'repoCoachSecteur' => $this->repoCoachSecteur,
            'sectorSearchForm' => $sectorFormSearch->createView()
        ]);
    }

    /**
     * @Route("/admin/secteur/add", name="admin_sector_add")
     */
    public function admin_sector_add(Request $request)
    {
        $sector = new Secteur();
        $duplicateId = $request->get('duplicateId', null);
        if($duplicateId){
            $duplicateSecteur = $this->repoSecteur->find($duplicateId);
            $sector = $duplicateSecteur->duplicate();
        }
        
        // $coachSecteur = new CoachSecteur();
        $formSecteur = $this->createForm(SecteurType::class, $sector)
            // ->add('coach', EntityType::class, [
            //     'mapped' => false,
            //     'class' => User::class,
            //     'choice_label' => 'prenom',
            //     'query_builder' => function (EntityRepository $er) {
            //         return $er->createQueryBuilder('u')
            //             ->where('u.roles LIKE :role')
            //             ->setParameter('role', '%'. User::ROLE_COACH.'%');
            //         ;
            //     }
            // ])
        ;

        $formSecteur->handleRequest($request);
        if ($formSecteur->isSubmitted() && $formSecteur->isValid()) {
            $imageCouverture = $formSecteur->get('couverture')->getData();
            if ($imageCouverture) {
                $photo = $this->fileHandler->upload($imageCouverture, "images\secteur\couverture");
                $sector->setCouverture($photo);
            }
            $affiche = $formSecteur->get('affiche')->getData();
            if ($affiche) {
                $photo = $this->fileHandler->upload($affiche, "images\secteur\affiche");
                $sector->setAffiche($photo);
            }
            $sector->setActive(1);
            $this->entityManager->save($sector);
            
            // $coachId = $request->request->get('secteur')['coach'];
            // $coach = $this->repoUser->find($coachId);
            // $coachSecteur->setCoach($coach);
            // $coachSecteur->setSecteur($sector);
            // $this->entityManager->save($coachSecteur);

            $this->addFlash('success', "Ajout d'un secteur avec succès");
            return $this->redirectToRoute('admin_sector_list');    
        }

        return $this->render('user_category/admin/sector/add_sector.html.twig', [
            'formSecteur' => $formSecteur->createView()
        ]);    
    }


    /**
     * @Route("/admin/secteur/{id}/edit", name="admin_sector_edit")
     */
    public function admin_sector_edit(Request $request, Secteur $sector)
    {
        $formSecteur = $this->createForm(SecteurType::class, $sector);

        $formSecteur->handleRequest($request);
        if ($formSecteur->isSubmitted() && $formSecteur->isValid()) {
            $imageCouverture = $formSecteur->get('couverture')->getData();
            if ($imageCouverture) {
                $photo = $this->fileHandler->upload($imageCouverture, "images\secteur\couverture");
                $sector->setCouverture($photo);
            }
            $affiche = $formSecteur->get('affiche')->getData();
            if ($affiche) {
                $photo = $this->fileHandler->upload($affiche, "images\secteur\affiche");
                $sector->setAffiche($photo);
            }
            $this->entityManager->save($sector);
            $this->addFlash('success', "Modification secteur avec succès");
            return $this->redirectToRoute('admin_sector_list');    
        }

        return $this->render('user_category/admin/sector/edit_sector.html.twig', [
            'formSecteur' => $formSecteur->createView(),
            'sector' => $sector
        ]);    
    }

    /**
     * @Route("/admin/secteur/{id}/delete", name="admin_sector_delete")
     */
    public function admin_sector_delete(Secteur $sector, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'. $sector->getId(), $request->get('_token'))) {
            $sector->setActive(-1);
            $this->entityManager->save($sector);

            $this->addFlash( 'danger', 'Secteur supprimé');
        }
        return $this->redirectToRoute('admin_sector_list');    
    }
    /**
     * @Route("/admin/secteur/{id}/reactiver", name="admin_sector_reactiver")
     */
    public function admin_sector_reactiver(Secteur $sector, Request $request)
    {  
            $sector->setActive(1);
            $this->entityManager->save($sector);

            $this->addFlash( 'success', 'Secteur restauré');
        return $this->redirectToRoute('admin_sector_list');    
    }
}