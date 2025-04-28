<?php

namespace App\Controller\Order;

use App\Controller\BaseControllerAdmin;
use App\Entity\Order;
use App\Entity\OrderSecu;
use App\Entity\Utilisateur;
use App\Form\OrderClientFilterType;
use App\Form\OrderSecuClientFilterType;
use App\Repository\OrderRepository;
use App\Services\OrderSecuService;
use App\Services\OrderService;
use App\Services\SearchService;
use App\Util\Search\MyCriteriaParam;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/agent/ordersecu")
 */
class OrderSecuControllerAdmin extends AbstractController
{
    private $entityManager;
    private $orderSecuService;
    private $session;

    public function __construct(EntityManagerInterface $entityManager, OrderSecuService $orderSecuService, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->orderSecuService = $orderSecuService;
        $this->session = $session;
    }

    /**
     * @Route("/", name="admin_ordersecu_list")
     */
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {

        $user = (object) $this->getUser();
        $secteurId = $this->session->get('secteurId');
        $page = $request->query->get('page', 1);
        $limit = 5;
        $criteria = [
            ['prop' => 'statut'],
            ['prop' => 'dateMin', 'col' => 'dateCommande', 'op' => '>='],
            ['prop' => 'dateMax', 'col' => 'dateCommande', 'op' => '<='],
            ['prop' => 'clientName', 'col' => "concat(concat(coalesce(c.prenom, ''), ' '), c.nom)", 'alias' => null, 'op' => 'LIKE']
        ];

        $filter = [];

        $form = $this->createForm(OrderSecuClientFilterType::class, $filter, [
            'method' => 'GET',
            'admin' => true
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();

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

        $where = $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'o'));
        $query->where($where["where"] . " and a.id = :agentId and s.id = :secteurId ");
        $where["params"]["agentId"] = $user->getId();
        $where["params"]["secteurId"] = $secteurId;
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'o.dateCommande', 'direction' => 'desc']);

        $orderList = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/agent/secu/order/order_list.html.twig', [
            'orderList' => $orderList,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", name="admin_ordersecu_details")
     */
    public function details(Request $request, OrderSecu $order): Response
    {
        $error = null;
        return $this->render('user_category/agent/secu/order/order_details.html.twig', [
            'error' => $error,
            'order' => $order,
            'filesDirectory' => $this->getParameter('files_directory_relative')
        ]);

    }

    /**
     * @Route("/{id}/status/{status}", name="admin_ordersecu_status")
     */
    public function changeStatus(Request $request, int $id, int $status): Response
    {
        try {
            $this->orderSecuService->changeStatus($id, $status);
            $this->addFlash(
                'success',
                'Commande ' . OrderSecu::STATUS[$status]
            );
        } catch (Exception $ex) {
            $this->addFlash(
                'error',
                $ex->getMessage()
            );
        }
        return $this->redirectToRoute('admin_ordersecu_details', ['id' => $id]);
    }

    /**
     * @Route("/{id}/downloadContrat", name="admin_ordersecu_download_contrat")
     */
    public function downloadContrat(OrderSecu $order): Response
    {
        $response = new BinaryFileResponse(
            $this->getParameter('files_directory_relative') . "/" . $order->getContratSigned()
        );
        $response->headers->set('Content-Type', 'appication/pdf');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'contrat-' . $order->getId() . '.pdf'
        );
        return $response;
    }

}