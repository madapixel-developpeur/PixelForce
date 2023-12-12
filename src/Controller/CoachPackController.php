<?php


namespace App\Controller;

use App\Entity\OrderPack;
use App\Entity\Pack;
use App\Entity\SearchEntity\OrderSearch;
use App\Form\OrderSearchType;
use App\Form\PackType;
use App\Manager\EntityManager;
use App\Repository\OrderPackRepository;
use App\Repository\PackRepository;
use App\Services\FileHandler;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CoachPackController extends AbstractController
{
    /**
     * @var PackRepository
     */
    private $packRepository;
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(private OrderPackRepository $orderPackRepo, private FileHandler $fileHandler, PackRepository $packRepository, PaginatorInterface $paginator, EntityManager $entityManager)
    {
        $this->packRepository = $packRepository;
        $this->paginator = $paginator;
        $this->entityManager = $entityManager;
    }
/**
     * @Route("/coach/pack/orders/liste", name="coach_pack_orders_list")
     */
    public function coach_pack_orders_list(Request $request, PaginatorInterface $paginator)
    {
        $orders = $paginator->paginate(
            $this->orderPackRepo->findOrdersQuery(),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/coach/pack/list_orders.html.twig', [
            'orders' => $orders
        ]);
    }
    /**
     * @Route("/coach/pack/orders/details/{order_pack_id}", name="coach_pack_orders_details")
     */
    public function coach_pack_orders_details($order_pack_id)
    {
        $error = null;
        $orderPack = $this->orderPackRepo->find($order_pack_id);
        return $this->render('user_category/coach/pack/order_details.html.twig', [
            'order' => $orderPack,
            'error' => null,
            'subscription'=>[
                'amount'=>OrderPack::SUBSCRIPTION_AMOUNT,
                'interval'=>OrderPack::IntervaltoLocale(OrderPack::SUBSCRIPTION_INTERVAL),
            ]
        ]);
    }
}