<?php
// src/Controller/FileUploadController.php
namespace App\Controller;

use App\Entity\Ressource;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Services\FileHandler;
use App\Util\Status;
use App\Form\RessourceFormType;
use App\Services\SearchService;
use App\Util\Search\MyCriteriaParam;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\RessourceFilterType;

#[Route('/agent/ressources')]
class AgentRessourceController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager, private FileHandler $fileHandler, private SessionInterface $session, )
    {
    }

    #[Route('/file/download', name: 'app_agent_ressource_file_download')]
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



    #[Route('/', name: 'app_agent_ressource_list')]
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $sessionSecteurId = $this->session->get('secteurId');
        $user = $this->getUser();
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
        $query->where($where["where"] . " and r.status = :statusValid and r.secteur = :secteurId and (r.type is null or r.type = :type)");
        $where["params"]["statusValid"] = Status::VALID;
        $where["params"]["secteurId"] = $sessionSecteurId;
        $where["params"]["type"] = in_array(User::ROLE_PROFESSIONNEL, $user->getRoles()) ? Ressource::TYPE_PROFESSIONNEL : Ressource::TYPE_REVENDEUR;
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'r.id', 'direction' => 'asc']);

        $result = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/agent/ressource/list.html.twig', [
            'result' => $result,
            'form' => $form->createView(),
            'page' => $page
        ]);

    }
}