<?php


namespace App\Controller;

use App\Entity\User;
use App\Repository\CalendarEventRepository;
use App\Repository\SecteurRepository;
use App\Services\Stat\StatAdminService;
use App\Services\Stat\StatAgentService;
use App\Services\Stat\StatCoachService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\UserRepository;

class AdminAccountController extends AbstractController
{
    private $calendarEventRepository;

    protected $repoSecteur;

    public function __construct(CalendarEventRepository $calendarEventRepository, SecteurRepository $repoSecteur)
    {
        $this->calendarEventRepository = $calendarEventRepository;
        $this->repoSecteur = $repoSecteur;
    }

    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function admin_dashboard(Request $request, StatAdminService $statAdminService, StatAgentService $statAgentService, SecteurRepository $secteurRepository, StatCoachService $statCoachService)
    {
        $secteurs = $secteurRepository->getValidSecteurs();
        $secteur = null;

        //stat
        $secteurId = $request->get('secteurId', -1);
        if ($secteurId > 0) $secteur = $secteurRepository->find($secteurId);
        $anneeActuelle = intval(date('Y'));
        $annee = $request->get('annee', $anneeActuelle);
        $statVente = $statAdminService->getStatVente();
        $nbrAgents = $statAdminService->getNbrAgents();
        $nbrCoachs = $statAdminService->getNbrCoachs();
        $nbrSecteurs = $statAdminService->getNbrSecteurs();
        $revenuAnnee = $statAgentService->getRevenuAnnee($annee, $secteurId);

        // Calendar upcoming events :
        $upcomingEvents = $this->calendarEventRepository->findBy([], ['id' => 'DESC'], 3);
        $eventsOfTheDay = $this->calendarEventRepository->findBy([], ['id' => 'DESC'], 3);

        $moisActuel = intval(date('m'));
        $bestStatVente = $statCoachService->getBestStatVente();
        $allStatsVente = $statCoachService->getAllStatVente();
        $revenuAnneeMoisBest = $statAgentService->getRevenuAnneeMois($anneeActuelle, $moisActuel, $bestStatVente['secteur_id'], -1);
        $bestStatVente['percent'] = 0;
        if ($statVente['ca'] > 0) {
            $bestStatVente['percent'] = $bestStatVente['ca'] * 100 / $statVente['ca'];
        }

        return $this->render('user_category/admin/admin_dashboard.html.twig', [
            'statVente' => $statVente,
            'revenuAnnee' => $revenuAnnee,
            'annee' => $annee,
            'anneeActuelle' => $anneeActuelle,
            'nbrCoachs' => $nbrCoachs,
            'nbrAgents' => $nbrAgents,
            'nbrSecteurs' => $nbrSecteurs,
            'secteurs' => $secteurs,
            'secteur' => $secteur,
            'upcomingEvents' => $upcomingEvents,
            'eventsOfTheDay' => $eventsOfTheDay,
            'bestStatVente' => $bestStatVente,
            'repoSecteur' => $this->repoSecteur,
            'allStatsVente' => $allStatsVente,
            'revenuAnneeMoisBest' => $revenuAnneeMoisBest
        ]);
    }
    /**
     * @Route("/admin/view", name="admin_view")
     */
    public function admin_ambassadeur_view(Request $request, UserRepository $repoUser, PaginatorInterface $paginator)
    {
        $ambassadeur = $this->getUser();
        $result = $repoUser->findBy(['parrain' => $ambassadeur->getId()]);
        $filleul = $paginator->paginate(
            $result,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('user_category/admin/view_admin.html.twig', [
            'ambassadeur' => $ambassadeur,
            'filleul' => $filleul
        ]);
    }
}
