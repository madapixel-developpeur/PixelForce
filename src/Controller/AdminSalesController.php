<?php


namespace App\Controller;

use App\Entity\CoachAgent;
use App\Entity\SearchEntity\UserSearch;
use App\Entity\User;
use App\Entity\AgentSecteur;
use App\Entity\PlanAgentAccount;
use App\Entity\SearchEntity\OrderSearch;
use App\Entity\Secteur;
use App\Form\InscriptionAgentType;
use App\Form\ResetPasswordType;
use App\Form\SecteurType;
use App\Form\UserSearchType;
use App\Form\AgentSecteurType;
use App\Form\MultipleSecteurType;
use App\Form\OrderSearchType;
use App\Form\PlanAgentAccountType;
use App\Form\UserType;
use App\Manager\EntityManager;
use App\Manager\StripeManager;
use App\Manager\UserManager;
use App\Repository\CoachAgentRepository;
use App\Repository\SecteurRepository;
use App\Repository\UserRepository;
use App\Repository\AgentSecteurRepository;
use App\Repository\CoachSecteurRepository;
use App\Repository\OrderRepository;
use App\Repository\PlanAgentAccountRepository;
use App\Repository\SubscriptionPlanAgentAccountRepository;
use App\Services\AgentSecteurService;
use App\Services\StripeService;
use App\Services\User\AgentService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class AdminSalesController extends AbstractController
{
    public function __construct(private OrderRepository $repoOrder)
    {
        $this->repoOrder = $repoOrder;
    }

    /**
     * @Route("/admin/sales/liste", name="admin_sales_list")
     */
    public function admin_agent_list(Request $request, PaginatorInterface $paginator)
    {
        $search = new OrderSearch();
        $searchForm = $this->createForm(OrderSearchType::class, $search);
        $searchForm->handleRequest($request);
        
        $orders = $paginator->paginate(
            $this->repoOrder->findOrdersQuery($search),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/admin/sales/list_sales.html.twig', [
            'orders' => $orders,
            'searchForm' => $searchForm->createView()
        ]);
    }
    /**
     * @Route("/admin/sales/orders/details/{id}", name="admin_sales_orders_details")
     */
    public function admin_pack_orders_details($id)
    {
        $error = null;
        $order = $this->repoOrder->find($id);
        // dd($order);
        return $this->render('user_category/admin/sales/order_details.html.twig', [
            'order' => $order,
            'error' => null,
        ]);
    }

}
