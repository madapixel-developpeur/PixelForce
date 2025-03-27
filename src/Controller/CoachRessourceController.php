<?php
// src/Controller/FileUploadController.php
namespace App\Controller;

use App\Entity\Ressource;
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
use App\Form\RessourceFormType;
use App\Services\SearchService;
use App\Util\Search\MyCriteriaParam;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\RessourceFilterType;

#[Route('/coach/ressources')]
class CoachRessourceController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager, private FileHandler $fileHandler)
    {
    }

    #[Route('/file/upload', name: 'app_ressource_file_upload', methods: ['POST'])]
    public function uploadFile(
        Request $request
    ): JsonResponse {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            return new JsonResponse(['message' => 'No file provided'], 400);
        }
        try {
            $filename = $this->fileHandler->upload($uploadedFile, "ressources");
            return new JsonResponse(['message' => 'File uploaded successfully', 'path' => $filename, 'name' => basename($filename)]);
        } catch (\Exception $ex) {
            return new JsonResponse(['message' => $ex->getMessage()], 500);
        }
    }

    #[Route('/file/download', name: 'app_ressource_file_download')]
    public function downloadFile(Request $request): Response
    {
        $filename = $request->get('filename');
        $response = new BinaryFileResponse(
            $this->getParameter('files_directory_relative') . "/" .
            $filename
        );
        // $mimeType = mime_content_type($filePath) ?: 'application/octet-stream';
        // $response->headers->set('Content-Type', 'appication/pdf');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            basename($filename)
        );
        return $response;
    }


    #[Route('/add', name: 'app_ressource_add')]
    public function add(Request $request): Response
    {
        $res = new Ressource();
        $form = $this->createForm(RessourceFormType::class, $res, ['secteur' => $this->getUser()->getUniqueCoachSecteur()]);
        $form->handleRequest($request);
        $files = [];
        if ($form->isSubmitted()) {
            $filesStr = trim($request->request->get('files', ''));
            if ($filesStr) {
                $files = json_decode($filesStr, true);
            }
            if ($form->isValid()) {
                try {
                    $res->setSecteur($this->getUser()->getUniqueCoachSecteur());
                    $res->setFiles($files);
                    $res->setStatus(Status::VALID);
                    $this->entityManager->persist($res);
                    $this->entityManager->flush();

                    return $this->redirectToRoute('app_ressource_details', [
                        'id' => $res->getId()
                    ]);
                } catch (\Exception $ex) {
                    $this->addFlash('danger', $ex->getMessage());
                }
            }
        }

        return $this->render('user_category/coach/ressources/form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => false,
            'files' => array_map(function ($file) {
                return ['path' => $file['path'], 'name' => basename($file['path']), 'customName' => $file['customName']];
            }, $files),
            "ressource" => $res
        ]);
    }


    #[Route('/{id}/edit', name: 'app_ressource_edit')]
    public function edit(Ressource $res, Request $request): Response
    {
        $form = $this->createForm(RessourceFormType::class, $res, ['secteur' => $this->getUser()->getUniqueCoachSecteur()]);
        $form->handleRequest($request);
        $files = $res->getFiles();
        if ($form->isSubmitted()) {
            $filesStr = trim($request->request->get('files', ''));
            if ($filesStr) {
                $files = json_decode($filesStr, true);
            }
            if ($form->isValid()) {
                try {
                    $res->setSecteur($this->getUser()->getUniqueCoachSecteur());
                    $res->setFiles($files);
                    $res->setStatus(Status::VALID);
                    $this->entityManager->persist($res);
                    $this->entityManager->flush();

                    return $this->redirectToRoute('app_ressource_details', [
                        'id' => $res->getId()
                    ]);
                } catch (\Exception $ex) {
                    $this->addFlash('danger', $ex->getMessage());
                }
            }
        }

        return $this->render('user_category/coach/ressources/form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => true,
            'files' => array_map(function ($file) {
                return ['path' => $file['path'], 'name' => basename($file['path']), 'customName' => $file['customName']];
            }, $files),
            "ressource" => $res
        ]);
    }


    #[Route('/{id}/details', name: 'app_ressource_details')]
    public function details(Ressource $res): Response
    {
        return $this->render('user_category/coach/ressources/details.html.twig', [
            'res' => $res,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_ressource_delete', methods: ['POST'])]
    public function delete(Ressource $res): Response
    {
        try {
            $res->setStatus(Status::INVALID);
            $this->entityManager->persist($res);
            $this->entityManager->flush();
            $this->addFlash('success', 'Ressource supprimée avec succès');
        } catch (\Exception $ex) {
            $this->addFlash('danger', $ex->getMessage());
        }
        return $this->redirectToRoute('app_ressource_list');

    }



    #[Route('/', name: 'app_ressource_list')]
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $page = $request->query->get('page', 1);
        $limit = 5;
        $criteria = [
            ['prop' => 'name', 'op' => 'LIKE']
        ];

        $filter = [];

        $form = $this->createForm(RessourceFilterType::class, $filter, [
            'method' => 'GET'
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('r')
            ->from(Ressource::class, 'r')
        ;

        $where = $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'r'));
        $query->where($where["where"] . " and r.status = :statusValid and r.secteur = :secteurId ");
        $where["params"]["statusValid"] = Status::VALID;
        $where["params"]["secteurId"] = $this->getUser()->getUniqueCoachSecteur()?->getId();
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'r.id', 'direction' => 'asc']);

        $result = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/coach/ressources/list.html.twig', [
            'result' => $result,
            'form' => $form->createView(),
            'page' => $page
        ]);

    }
}