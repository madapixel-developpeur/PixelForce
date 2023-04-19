<?php

namespace App\Controller\Order;

use App\Entity\OrderAroma;
use App\Form\OrderAromaFilterType;
use App\Repository\OrderAromaRepository;
use App\Services\OrderServiceAroma;
use App\Services\SearchService;
use App\Util\Search\MyCriteriaParam;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/agent/orderaroma")
 */
class OrderAromaControllerAdmin extends AbstractController
{
    private $entityManager;
    private $orderAromaRepository;
    private $orderService;
    private $session; 

    public function __construct(EntityManagerInterface $entityManager, OrderAromaRepository $orderAromaRepository, OrderServiceAroma $orderService, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->orderAromaRepository = $orderAromaRepository;
        $this->orderService = $orderService;
        $this->session = $session;
    }

    /**
     * @Route("/", name="admin_aroma_order_list")
     */
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {

        $user = (object)$this->getUser();
        $secteurId = $this->session->get('secteurId');
        $page = $request->query->get('page', 1);
        $limit = 5;
        $criteria = [
            ['prop' => 'status'],
            ['prop' => 'dateMin', 'col' => 'orderDate', 'op' => '>='],
            ['prop' => 'dateMax', 'col' => 'orderDate', 'op' => '<='],
            ['prop' => 'clientName', 'col' => "concat(concat(coalesce(ad.firstname, ''), ' '), ad.lastname)", 'alias' => null, 'op' => 'LIKE']
        ];

        $filter = [];

        $form = $this->createForm(OrderAromaFilterType::class, $filter, [
            'method' => 'GET',
            'admin' => true
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('o')
            ->from(OrderAroma::class, 'o')
            ->join('o.user', 'u')
            ->join('o.agent', 'a')
            ->join('o.secteur', 's')
            ->join('o.address', 'ad')
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

        return $this->render('user_category/agent/aroma/order/order_list.html.twig', [
            'orderList' => $orderList,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", name="admin_aroma_order_details")
     */
    public function details(OrderAroma $order): Response
    {
        return $this->render('user_category/agent/aroma/order/order_details.html.twig',[
            'order' => $order
        ]);

    }

    
    

    /**
     * @Route("/{id}/deliver", name="admin_aroma_order_validate")
     */
    public function validate(OrderAroma $order, Request $request): Response
    {
        try{
            $this->orderService->deliverOrder($order);
            $this->addFlash(
                'success',
                'Commande livrée'
            ); 
        } catch(Exception $ex){
            $this->addFlash(
               'danger',
               $ex->getMessage()
            );
        } 
        return $this->redirectToRoute('admin_aroma_order_details', ['id' => $order->getId()]);
    }

    

}