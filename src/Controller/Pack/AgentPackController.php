<?php

namespace App\Controller\Pack;

use App\Entity\OrderPack;
use App\Entity\Pack;
use App\Form\PackPayFormType;
use App\Repository\OrderPackRepository;
use App\Repository\PackRepository;
use App\Services\OrderPackService;
use App\Services\StripeService;
use App\Util\GenericUtil;
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
 * @Route("/agent/pack")
 */
class AgentPackController extends AbstractController
{
    public function __construct(private PaginatorInterface $paginator, private OrderPackRepository $orderPackRepo,private OrderPackService $orderPackService,private PackRepository $packRepository, private StripeService $stripeService)
    {
       
    }

    /**
     * @Route("/", name="app_agent_pack_index")
     */
    public function index(Request $request): Response
    {
        $orderPacks = $this->paginator->paginate(
            $this->orderPackRepo->findByAgentQuery($this->getUser()),
            $request->query->get('page', 1),
            20
        );
        return $this->render('user_category/agent/pack/pack_list.html.twig', [
            'orderPacks' => $orderPacks
        ]);

    }
    
}