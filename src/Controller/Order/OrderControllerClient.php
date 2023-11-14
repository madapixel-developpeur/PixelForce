<?php

namespace App\Controller\Order;

use App\Controller\BaseControllerClient;
use App\Entity\Order;
use App\Entity\Utilisateur;
use App\Form\OrderClientFilterType;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Services\SearchService;
use App\Util\Search\MyCriteriaParam;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client/{token}/order")
 */
class OrderControllerClient extends AbstractController
{
    private $entityManager;
    private $orderRepository;
    private $userRepository;
    private $session;

    public function __construct(EntityManagerInterface $entityManager, OrderRepository $orderRepository, UserRepository $userRepository, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->session = $session;
    }

    /**
     * @Route("/", name="client_order_list")
     */
    public function index($token, Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByUsername($token);
        $page = $request->query->get('page', 1);
        $limit = 5;
        $criteria = [
            ['prop' => 'status'],
            ['prop' => 'dateMin', 'col' => 'orderDate', 'op' => '>='],
            ['prop' => 'dateMax', 'col' => 'orderDate', 'op' => '<='],
            ['prop' => 'user', 'col' => 'id', 'alias' => 'u']
        ];

        $filter = [];

        $form = $this->createForm(OrderClientFilterType::class, $filter, [
            'method' => 'GET',
        ]);
        $form->handleRequest($request);
        $filter = $form->getData();
        $filter["user"] = ((object)$this->getUser())->getId();

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('o')
            ->from(Order::class, 'o')
            ->join('o.user', 'u')
            ->join('o.agent', 'a')
            ->join('o.secteur', 's')
        ;  

        $where =  $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'o'));   
        $query->where($where["where"]." and a.id = :agentId and s.id = :secteurId ");
        $where["params"]["agentId"] = $agent->getId();
        $where["params"]["secteurId"] = $secteurId;
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'o.orderDate', 'direction' => 'desc']);

        $orderList = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/client/order/order_list.html.twig', [
            'orderList' => $orderList,
            'form' => $form->createView(),
            'token' => $token,
            'agent' => $agent
        ]);

    }

    /**
     * @Route("/{id}", name="client_order_details")
     */
    public function details($token, Request $request, Order $order): Response
    {
        $error = null;
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByUsername($token);
        return $this->render('user_category/client/order/order_details.html.twig',[
            'error' => $error,
            'order' => $order,
            'filesDirectory' => $this->getParameter('files_directory_relative'),
            'token' => $token,
            'agent' => $agent
        ]);

    }

}