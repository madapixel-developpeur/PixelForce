<?php

namespace App\Controller\Order;

use App\Controller\BaseControllerClient;
use App\Entity\Order;
use App\Entity\OrderSecu;
use App\Form\OrderSecuClientFilterType;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Services\SearchService;
use App\Util\Search\MyCriteriaParam;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client/{token}/ordersecu")
 */
class OrderSecuControllerClient extends AbstractController
{
    private $entityManager;
    private $userRepository;
    private $session;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->session = $session;
    }

    /**
     * @Route("/", name="client_ordersecu_list")
     */
    public function index($token, Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByUsername($token);
        $page = $request->query->get('page', 1);
        $limit = 5;
        $criteria = [
            ['prop' => 'statut'],
            ['prop' => 'dateMin', 'col' => 'dateCommande', 'op' => '>='],
            ['prop' => 'dateMax', 'col' => 'dateCommande', 'op' => '<='],
            ['prop' => 'client', 'col' => 'id', 'alias' => 'c']
        ];

        $filter = [];

        $form = $this->createForm(OrderSecuClientFilterType::class, $filter, [
            'method' => 'GET',
        ]);
        $form->handleRequest($request);
        $filter = $form->getData();
        $filter["client"] = ((object)$this->getUser())->getId();

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('o')
            ->from(OrderSecu::class, 'o')
            ->join('o.kitbase', 'k')
            ->join('o.tva', 't')
            ->join('o.client', 'c')
            ->join('o.agent', 'a')
            ->join('o.secteur', 's')
        ;  

        $where =  $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'o'));   
        $query->where($where["where"]." and a.id = :agentId and s.id = :secteurId ");
        $where["params"]["agentId"] = $agent->getId();
        $where["params"]["secteurId"] = $secteurId;
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'o.dateCommande', 'direction' => 'desc']);

        $orderList = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/client/secu/order/order_list.html.twig', [
            'orderList' => $orderList,
            'form' => $form->createView(),
            'token' => $token,
            'agent' => $agent
        ]);

    }

    /**
     * @Route("/{id}", name="client_ordersecu_details")
     */
    public function details($token, Request $request, OrderSecu $order): Response
    {
        $error = null;
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByUsername($token);
        return $this->render('user_category/client/secu/order/order_details.html.twig',[
            'error' => $error,
            'order' => $order,
            'filesDirectory' => $this->getParameter('files_directory_relative'),
            'token' => $token,
            'agent' => $agent
        ]);

    }

        /**
     * @Route("/{id}/download-contrat", name="client_download_contrat")
     */
    public function client_download_contrat($token, OrderSecu $order): Response
    {
        $filename = $order->getContratSigned();
        $response = new BinaryFileResponse(
            $this->getParameter('files_directory_relative')."/".$filename
        );
        $response->headers->set('Content-Type', 'appication/pdf');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT
        );
        return $response;
    }
}