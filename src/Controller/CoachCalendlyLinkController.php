<?php
// src/Controller/FileUploadController.php
namespace App\Controller;

use App\Entity\CalendlyLink;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Services\FileHandler;
use App\Util\Status;
use App\Form\CalendlyLinkFormType;
use App\Services\SearchService;
use App\Util\Search\MyCriteriaParam;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\CalendlyLinkFilterType;

#[Route('/coach/calendly-links')]
class CalendlyLinkController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager, private FileHandler $fileHandler)
    {
    }


    #[Route('/add', name: 'app_coach_calendly_link_add')]
    public function add(Request $request): Response
    {
        $cl = new CalendlyLink();
        $form = $this->createForm(CalendlyLinkFormType::class, $cl);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            try {
                $uploadedFile = $form->get('imageFile')->getData();
                if($uploadedFile) {
                    $filename = $this->fileHandler->upload($uploadedFile, "calendly-link-images");
                    $cl->setImage($filename);
                }
                $cl->setStatus(Status::VALID);
                $this->entityManager->persist($cl);
                $this->entityManager->flush();

                // return $this->redirectToRoute('app_coach_calendly_link_details', [
                //     'id' => $cl->getId()
                // ]);
                $this->addFlash('success', 'Lien ajouté avec succès');
                return $this->redirectToRoute('app_coach_calendly_link_list');
            } catch (\Exception $ex) {
                $this->addFlash('danger', $ex->getMessage());
            }
            
        }

        return $this->render('user_category/coach/calendly-links/form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => false
        ]);
    }


    #[Route('/{id}/edit', name: 'app_coach_calendly_link_edit')]
    public function edit(CalendlyLink $cl, Request $request): Response
    {
        $form = $this->createForm(CalendlyLinkFormType::class, $cl);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            try {
                $uploadedFile = $form->get('imageFile')->getData();
                if($uploadedFile) {
                    $filename = $this->fileHandler->upload($uploadedFile, "calendly-link-images");
                    $cl->setImage($filename);
                }
                $cl->setStatus(Status::VALID);
                $this->entityManager->persist($cl);
                $this->entityManager->flush();

                // return $this->redirectToRoute('app_coach_calendly_link_details', [
                //     'id' => $cl->getId()
                // ]);
                $this->addFlash('success', 'Lien modifié avec succès');
                return $this->redirectToRoute('app_coach_calendly_link_list');
            } catch (\Exception $ex) {
                $this->addFlash('danger', $ex->getMessage());
            }
            
        }

        return $this->render('user_category/coach/calendly-links/form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => true
        ]);
    }


    #[Route('/{id}/details', name: 'app_coach_calendly_link_details')]
    public function details(CalendlyLink $cl): Response
    {
        return $this->render('user_category/coach/calendly-links/details.html.twig', [
            'cl' => $cl,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_coach_calendly_link_delete', methods: ['POST'])]
    public function delete(CalendlyLink $cl): Response
    {
        try {
            $cl->setStatus(Status::INVALID);
            $this->entityManager->persist($cl);
            $this->entityManager->flush();
            $this->addFlash('success', 'Lien supprimé avec succès');
        } catch (\Exception $ex) {
            $this->addFlash('danger', $ex->getMessage());
        }
        return $this->redirectToRoute('app_coach_calendly_link_list');

    }



    #[Route('/', name: 'app_coach_calendly_link_list')]
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $page = $request->query->get('page', 1);
        $limit = 5;
        $criteria = [
            ['prop' => 'description', 'op' => 'LIKE']
        ];

        $filter = [];

        $form = $this->createForm(CalendlyLinkFilterType::class, $filter, [
            'method' => 'GET'
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('c')
            ->from(CalendlyLink::class, 'c')
        ;

        $where = $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'c'));
        $query->where($where["where"] . " and c.status = :statusValid ");
        $where["params"]["statusValid"] = Status::VALID;
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'c.id', 'direction' => 'asc']);

        $result = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/coach/calendly-links/list.html.twig', [
            'result' => $result,
            'form' => $form->createView(),
            'page' => $page
        ]);

    }
}