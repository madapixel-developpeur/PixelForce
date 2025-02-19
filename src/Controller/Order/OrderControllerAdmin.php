<?php

namespace App\Controller\Order;

use DateTime;
use Exception;
use App\Entity\Order;
use App\Services\OrderService;
use App\Services\SearchService;
use App\Form\OrderClientFilterType;
use App\Repository\OrderRepository;
use App\Form\OrderSearchTypeDigital;
use App\Util\Search\MyCriteriaParam;
use App\Services\Stat\StatAgentService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/agent/order")
 */
class OrderControllerAdmin extends AbstractController
{
    private $entityManager;
    private $orderRepository;
    private $orderService;
    private $session; 

    public function __construct(EntityManagerInterface $entityManager, OrderRepository $orderRepository, OrderService $orderService, SessionInterface $session, private StatAgentService $statAgentService)
    {
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->session = $session;
    }

    /**
     * @Route("/", name="agent_order_list")
     */
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {

        $user = (object)$this->getUser();
        $secteurId = $this->session->get('secteurId');
        if($secteurId == $this->getParameter('secteur_digital_id')) return $this->redirectToRoute('agent_order_list_digital');
        $page = $request->query->get('page', 1);
        $limit = 5;
        $criteria = [
            ['prop' => 'status'],
            ['prop' => 'dateMin', 'col' => 'orderDate', 'op' => '>='],
            ['prop' => 'dateMax', 'col' => 'orderDate', 'op' => '<='],
            ['prop' => 'clientName', 'col' => "concat(concat(coalesce(u.prenom, ''), ' '), u.nom)", 'alias' => null, 'op' => 'LIKE']
        ];

        $filter = [];

        $form = $this->createForm(OrderClientFilterType::class, $filter, [
            'method' => 'GET',
            'admin' => true
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();

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
        $where["params"]["agentId"] = $user->getId();
        $where["params"]["secteurId"] = $secteurId;
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'o.orderDate', 'direction' => 'desc']);

        $orderList = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/agent/order/order_list.html.twig', [
            'orderList' => $orderList,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", name="agent_order_details")
     */
    public function details(Request $request, Order $order): Response
    {
        $error = null;
        return $this->render('user_category/agent/order/order_details.html.twig',[
            'error' => $error,
            'order' => $order,
            'filesDirectory' => $this->getParameter('files_directory_relative')
        ]);

    }

    /**
     * @Route("/{id}/validate", name="agent_order_validate")
     */
    public function validate(Request $request, int $id): Response
    {
        try{
            $this->orderService->changeStatus($id, Order::VALIDATED);
            $this->addFlash(
                'success',
                'Commande livrée'
            ); 
        } catch(Exception $ex){
            $this->addFlash(
               'error',
               $ex->getMessage()
            );
        } 
        return $this->redirectToRoute('agent_order_details', ['id' => $id]);
    }


    /**
     * @Route("/digital/all", name="agent_order_list_digital")
     */
    public function indexDigital(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {

        $user = (object)$this->getUser();
        $secteurId = $this->session->get('secteurId');
        $page = $request->query->get('page', 1);
        
        $filter = [];

        $form = $this->createForm(OrderSearchTypeDigital::class, $filter);

        $form->handleRequest($request);
        $filter = $form->getData();
        if(!$filter) $filter = [];
        $filter['ibiId'] = $user->getId();
        // $filter['ibiId'] = 1;
        if(isset($filter['dateMin']) && $filter['dateMin'])  $filter['dateMin'] = $filter['dateMin']->format('Y-m-d');
        if(isset($filter['dateMax']) && $filter['dateMax'])  $filter['dateMax'] = $filter['dateMax']->format('Y-m-d');
        $filter['page'] = $page;
        $result = $this->statAgentService->getOrders($filter);

        $orderList = $paginator->paginate(
            $result['items'],
            1,
            $result['itemNumberPerPage']
        );
        
        $orderList->setTotalItemCount($result['total']);
        $orderList->setCurrentPageNumber($result['currentPageNumber']);

        return $this->render('user_category/agent/order/order_list_digital.html.twig', [
            'orderList' => $orderList,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/digital/details/{id}", name="agent_order_details_digital")
     */
    public function detailsDigital(int $id, Request $request): Response
    {
        $error = null;
        return $this->render('user_category/agent/order/order_details_digital.html.twig',[
            'error' => $error,
            'order' => $this->statAgentService->getOrderById($id),
            'filesDirectory' => $this->getParameter('files_directory_relative')
        ]);

    }

    /**
     * @Route("/digital/historique-chiffre-d-affaire", name="agent_ca_list_digital")
     */
    public function getCaHistory(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {

        $user = (object)$this->getUser();
        $secteurId = $this->session->get('secteurId');
        $page = $request->query->get('page', 1);
        
        $filter = [];

        $form = $this->createFormBuilder()
        ->add('dateMin', TextType::class, [
            'label' => 'Mois min',
            'attr' => [
                'type' => 'month', 
                'class' => 'form-control month-picker-input',
                'placeholder' => 'YYYY-MM', 
            ],
            'required' => false,
        ])
        ->add('dateMax', TextType::class, [
            'label' => 'Mois max',
            'attr' => [
                'type' => 'month', 
                'class' => 'form-control month-picker-input',
                'placeholder' => 'YYYY-MM',
            ],
            'required' => false,
        ])
        ->getForm();

        
        $form->handleRequest($request);
        $filter = $form->getData();
        if(!$filter) $filter = [];
        $filter['ibiId'] = $user->getId();

        if(isset($filter['dateMin']) && $filter['dateMin'])  $filter['dateMin'] =  (new DateTime($filter['dateMin'] . "-01"))->setTime(0,0,0)->format('Y-m-d H:i:s');
        if(isset($filter['dateMax']) && $filter['dateMax'])  $filter['dateMax'] = (new DateTime($filter['dateMax'] . "-01"))->modify('last day of this month')->setTime(23,59,59)->format('Y-m-d H:i:s');
        $filter['page'] = $page;
        $result = $this->statAgentService->getCaHistory($filter);
        $historiquesCa = $result['result'];
        $totalCa = $result['totalCa'];

       

        return $this->render('user_category/agent/order/chiffre_affaire_historique.html.twig', [
            'historiquesCa' => $historiquesCa,
            'totalCa' => $totalCa,
            'form' => $form->createView(),
        ]);

    }

}