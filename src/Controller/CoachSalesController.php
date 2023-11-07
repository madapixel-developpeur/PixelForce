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

class CoachSalesController extends AbstractController
{
    public function __construct(private UserRepository $repoUser, private OrderRepository $repoOrder, private CoachSecteurRepository $repoCoachSecteur)
    {
    }

    /**
     * @Route("/coach/sales/liste", name="coach_sales_list")
     */
    public function coach_agent_list(Request $request, PaginatorInterface $paginator)
    {
        $coachSecteurs = $this->repoCoachSecteur->findBy(["coach"=>$this->getUser()]);
        $orders = $paginator->paginate(
            $this->repoOrder->findOrdersInListOfSecteurQuery($coachSecteurs),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/coach/sales/list_sales.html.twig', [
            'orders' => $orders
        ]);
    }

}
