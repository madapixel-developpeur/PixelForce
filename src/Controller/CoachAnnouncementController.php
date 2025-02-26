<?php
// src/Controller/FileUploadController.php
namespace App\Controller;

use App\Util\Status;
use App\Entity\Ressource;
use App\Entity\Announcement;
use App\Form\AnnouncementFilterType;
use App\Form\AnnouncementFormType;
use App\Services\FileHandler;
use App\Form\RessourceFormType;
use App\Services\SearchService;
use App\Form\RessourceFilterType;
use App\Util\Search\MyCriteriaParam;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/coach/annonce')]
class CoachAnnouncementController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager, private FileHandler $fileHandler)
    {
    }

    
    

    #[Route('/add', name: 'app_announcement_add')]
    public function add(Request $request): Response
    {
        $announcement = new Announcement();
        $form = $this->createForm(AnnouncementFormType::class, $announcement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $banniere = $form->get('filepath')->getData();
                if ($banniere) {
                    $filePath = $this->fileHandler->upload($banniere, "announcements/");
                    $announcement->setFilePath($filePath);
                }
                $announcement->setSecteur($this->getUser()->getUniqueCoachSecteur());
                $this->entityManager->persist($announcement);
                $this->entityManager->flush();

                $this->addFlash('success', 'Annonce ajoutée avec succès');
                return $this->redirectToRoute('app_coach_announcement_list');
            } catch (\Exception $ex) {
                // $this->addFlash('danger', $ex->getMessage());
                $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
            }
        }

        return $this->render('user_category/coach/announcement/announcement_form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => false,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_announcement_edit')]
    public function edit(Announcement $announcement, Request $request): Response
    {
        $form = $this->createForm(AnnouncementFormType::class, $announcement,[
            'isEdit' => true
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $banniere = $form->get('filepath')->getData();
                if ($banniere) {
                    $filePath = $this->fileHandler->upload($banniere, "announcements/");
                    $announcement->setFilePath($filePath);
                }
                $this->entityManager->persist($announcement);
                $this->entityManager->flush();

                $this->addFlash('success', 'Annonce modifiée avec succès');
                return $this->redirectToRoute('app_coach_announcement_list');
            } catch (\Exception $ex) {
                $this->addFlash('danger', $ex->getMessage());
            }
        }

        return $this->render('user_category/coach/announcement/announcement_form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => true,
            "announcement" => $announcement
        ]);
    }


   
    #[Route('/{id}/delete', name: 'app_announcement_delete', methods: ['POST'])]
    public function delete(Announcement $announcement): Response
    {
        try {
            $this->entityManager->remove($announcement);
            $this->entityManager->flush();
            $this->addFlash('success', 'Annonce supprimée avec succès');
        } catch (\Exception $ex) {
            $this->addFlash('danger', $ex->getMessage());
        }
        return $this->redirectToRoute('app_coach_announcement_list');

    }



    #[Route('/', name: 'app_coach_announcement_list')]
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $page = $request->query->get('page', 1);
        $limit = 20;

        $criteria = [
            ['prop' => 'nom', 'op' => 'LIKE'],
            ['prop' => 'description', 'op' => 'LIKE'],
            ['prop' => 'type','op' => '='],
        ];  

        $filter = [];

        $form = $this->createForm(AnnouncementFilterType::class, $filter, [
            'method' => 'GET'
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();

    
        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('a')
            ->from(Announcement::class, 'a');

        $where = $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'a'));
        $query->where($where["where"] . " and a.secteur = :secteurId ");
        $where["params"]["secteurId"] = $this->getUser()->getUniqueCoachSecteur()?->getId();
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'a.startDate', 'direction' => 'DESC']);

        $announcements = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/coach/announcement/announcement_list.html.twig', [
            'result' => $announcements,
            'form' => $form->createView(),
            'page' => $page
        ]);

    }
}