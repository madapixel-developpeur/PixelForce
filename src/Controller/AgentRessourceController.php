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
use App\Repository\RessourceRubriqueRepository;
use App\Entity\RessourceRubrique;
use App\Repository\RessourceRepository;
use Google\Service\Resource;

#[Route('/agent/ressources')]
class AgentRessourceController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager,
        private FileHandler $fileHandler, 
        private SessionInterface $session,
        private RessourceRepository $ressourceRepository
    )
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



    #[Route('/{type}', name: 'app_agent_ressource_list')]
    public function index(string $type, Request $request, PaginatorInterface $paginator, SearchService $searchService, RessourceRubriqueRepository $ressourceRubriqueRepository): Response
    {
        $sessionSecteurId = $this->session->get('secteurId');
        $user = $this->getUser();
        // $page = $request->query->get('page', 1);
        // $limit = 5;
        $criteria = [
            ['prop' => 'name', 'op' => 'LIKE']
        ];

        $filter = [];

        // $form = $this->createForm(RessourceFilterType::class, $filter, [
        //     'method' => 'GET'
        // ]);

        // $form->handleRequest($request);
        // $filter = $form->getData();

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('r')
            ->from(Ressource::class, 'r')
            ->leftJoin('r.rubrique', 'rb')
        ;

        $where = $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'r'));
        $query->where($where["where"] . " and r.status = :statusValid and r.secteur = :secteurId and (r.type is null or r.type = :type)");
        $where["params"]["statusValid"] = Status::VALID;
        $where["params"]["secteurId"] = $sessionSecteurId;
        $where["params"]["type"] = $type;
        $searchService->setAllParameters($query, $where["params"]);
        $query->addOrderBy('rb.id', 'asc');
        // $query->addOrderBy('rb.id', 'asc');
        $query->addOrderBy('r.id', 'asc');
        // $searchService->addOrderBy($query, $filter, ['sort' => 'r.id', 'direction' => 'asc']);

        // $result = $paginator->paginate(
        //     $query,
        //     $page,
        //     $limit
        // );
        $result = $query->getQuery()->getResult();

        return $this->render('user_category/agent/ressource/list.html.twig', [
            'result' => $result,
            'type' => $type,
            'rubriques' => $this->entityManager
                ->createQueryBuilder()
                ->select('rb')
                ->from(RessourceRubrique::class, 'rb')
                ->where('rb.status = :statusValid and (rb.secteur = :secteur or rb.secteur is null)')
                ->addOrderBy('rb.id', 'asc')
                ->setParameter('secteur', $sessionSecteurId)
                ->setParameter('statusValid', Status::VALID)
                ->getQuery()
                ->getResult()
            // 'form' => $form->createView(),
            // 'page' => $page
        ]);

    }

     /**
     * @Route("/{type}/{id}/details", name="agent_ressource_details")
     */
    public function view(string $type,Ressource $ressource)
    {
        return $this->render('user_category/agent/ressource/detail.html.twig', [
            'ressource' => $ressource,
            'type' => $type
         ]);
    }

    #[Route('/{id}/preview', name: 'app_ressource_file_preview')]
    public function preview(Ressource $ressource,Request $request): Response
    {
        $customName = $request->get('customName');
        $download = $request->get('download');
        $path = $this->getDocumentInformation($ressource->getFilesParsed(),$customName)['path'];
        $filePath = $this->getParameter('files_directory_relative') . "/" . $path;
        if (!file_exists($filePath)) {
            $this->addFlash('danger',$_ENV['CUSTOM_ERROR_MESSAGE']);
            return $this->redirectToRoute('agent_ressource_details',['type' => $ressource->getType() , 'id' => $ressource->getId()]);
        }

        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $disposition = ResponseHeaderBag::DISPOSITION_INLINE;

        $response = new BinaryFileResponse($filePath);
        $response->setContentDisposition($disposition, $customName);

        if (in_array($ext, ['pdf'])) {
            $response->headers->set('Content-Type', 'application/pdf');
        } elseif (in_array($ext, ['mp4', 'webm', 'ogg'])) {
            $response->headers->set('Content-Type', 'video/' . $ext);
        } elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $response->headers->set('Content-Type', 'image/' . $ext);
        }

        if($download == 1){
            $disposition = ResponseHeaderBag::DISPOSITION_ATTACHMENT;
            $response->setContentDisposition($disposition, $customName);
        }
        return $response;
    }

    public function getDocumentInformation(array $docs,string $customName){
        foreach($docs as $doc){
            if($doc['customName'] == $customName){
                return $doc;
            }
        };
        throw new \Exception('Fichier non trouvé');
    }


     /**
     * @Route("/{type}/{id}/view-document", name="agent_ressource_visualize")
     */
    public function visualiser(string $type,Ressource $ressource,Request $request)
    {
        $fileName = $request->get('customName');
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if(!in_array($ext, ['pdf','mp4', 'mov', 'avi', 'webm'])){
            return $this->redirectToRoute('agent_ressource_details',['type' => $type , 'id' => $ressource->getId()]);
        }
        $file = $this->getDocumentInformation($ressource->getFilesParsed(),$fileName);
        return $this->render('user_category/agent/ressource/visualize_document.html.twig', [
            'file' => [
                'customName' => $file['customName'],
                'ressourceID' => $ressource->getId(),
            ],
            'type' => $type
         ]);
    }
}