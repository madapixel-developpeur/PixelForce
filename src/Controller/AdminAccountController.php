<?php


namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Twig\HelperFunction;
use App\Exception\CustomException;
use App\Message\RefreshCaTracking;
use App\Repository\UserRepository;
use App\Repository\SecteurRepository;
use App\Services\Stat\StatAdminService;
use App\Services\Stat\StatAgentService;
use App\Services\Stat\StatCoachService;
use App\Repository\AgentSecteurRepository;
use App\Repository\CalendarEventRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAccountController extends AbstractController
{
    private $calendarEventRepository;

    protected $repoSecteur;

    public function __construct(
        CalendarEventRepository $calendarEventRepository,
        SecteurRepository $repoSecteur,
        private UserRepository $userRepository
    )
    {
        $this->calendarEventRepository = $calendarEventRepository;
        $this->repoSecteur = $repoSecteur;
    }

    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function admin_dashboard(Request $request, StatAdminService $statAdminService, StatAgentService $statAgentService, StatCoachService $statCoachService)
    {
        $countAgents = $this->userRepository->getCountActiveAgent();
        $statGeoAgents = $statAdminService->getStatGeoAgentForGraph(); 
        $recentRegisteredUsers = $this->userRepository->getRecentRegisteredUser();
        $statSecteurAgents = $statAdminService->getStatAgentBySecteur();
        $globalStat = $statAdminService->getGlobalCA();
        return $this->render('user_category/admin/dashboard/admin_dashboard.html.twig', [
            'countAgents' => $countAgents,
            'statGeoAgents' => $statGeoAgents,
            'recentRegisteredUsers' => $recentRegisteredUsers,
            'statSecteurAgents' => $statSecteurAgents,
            'statCA' => $globalStat['overview'],
            'caMonthlyData' => $globalStat['monthly_breakdown'],
        ]);
    }

    #[Route('/admin/statistique-performance', name: 'admin_stat_performance')]
    public function statAndPerformance(Request $request, StatAdminService $statAdminService): Response
    {
        $recentRegisteredUsers = $this->userRepository->getRecentRegisteredUser([
            'order' => 'DESC',
            'items_number' => 10,
            'DATE_OFFSET_OFF' => true
        ]);
        $agentWithMostReferral = $this->userRepository->getAmountOfReferralRanking();
        $agentRankedByCa = $statAdminService->getRankingAgentByCa();
        return $this->render('user_category/admin/statistics/statistic.html.twig', [
           'recentRegisteredUsers' => $recentRegisteredUsers,
           'agentWithMostReferral' => $agentWithMostReferral,
           'agentRankedByCa' => $agentRankedByCa
        ]);
    }

    #[Route('/admin/statistique-secteur', name: 'admin_stat_secteur')]
    public function statAndActivity(Request $request, StatAdminService $statAdminService,HelperFunction $helperFunction): Response
    {
        $statSecteur = $statAdminService->getStatGlobalBySecteur();
        $monthlyBreakdown= $helperFunction->transformMonthlyBreakDownStatToDataset($statSecteur['monthly_breakdown']);
        return $this->render('user_category/admin/statistics/statistic_secteur.html.twig', [
            'statSecteur' => $statSecteur['stat_secteur'],
            'monthlyBreakdown' => $monthlyBreakdown
        ]);
    }


    
    /**
     * @Route("/admin/view", name="admin_view")
     */
    public function admin_ambassadeur_view(Request $request,UserRepository $repoUser, PaginatorInterface $paginator)
    {
        $ambassadeur = $this->getUser();
        $result=$repoUser->findBy(['parrain'=>$ambassadeur->getId()]);
        $filleul = $paginator->paginate(
            $result,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('user_category/admin/view_admin.html.twig', [
            'ambassadeur' => $ambassadeur,
            'filleul'=>$filleul
        ]);
    }


     #[Route('/mise-a-jour-chiffres-affaire', name: 'app_admin_update_agent_ca_trakcing',methods: ['POST'])]
    public function updateAgentTracking(MessageBusInterface $bus): Response
    {
        try{
            $bus->dispatch(new RefreshCaTracking());
            $this->addFlash(
                'success',
                'Mise à jour lancée'
            ); 
        } catch (CustomException $ex) {
            $this->addFlash(
                'danger',
                $ex->getMessage()
            );
        } catch (Exception $ex) {
            // Gérer toutes les autres exceptions
            $this->addFlash(
                'danger',
                $_ENV['ERROR_MESSAGE']
            );
        }
        return $this->redirectToRoute('admin_stat_performance');
    }
}