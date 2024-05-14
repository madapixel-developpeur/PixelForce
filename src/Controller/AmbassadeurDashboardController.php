<?php

namespace App\Controller;

use App\Repository\CalendarEventRepository;
use App\Repository\ContactRepository;
use App\Repository\SecteurRepository;
use App\Services\Stat\StatAgentService;
use App\Services\Stat\StatCoachService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

/**
 * @Route("/ambassadeur/dashboard")
 */
class AmbassadeurDashboardController extends AbstractController
{
    private $entityManager;
    private $repoContact;
    private $calendarEventRepository;

    public function __construct(EntityManagerInterface $entityManager, ContactRepository $repoContact, CalendarEventRepository $calendarEventRepository){
        $this->entityManager = $entityManager;
        $this->repoContact = $repoContact;
        $this->calendarEventRepository = $calendarEventRepository;
    }

    /**
     * @Route("", name="ambassadeur_dashboard_index")
     */
    public function index(Request $request, PaginatorInterface $paginator, StatAgentService $statAgentService, StatCoachService $statCoachService, SecteurRepository $secteurRepository)
    {
      
        $user = (object)$this->getUser();
        $secteur = $user->getUniqueCoachSecteur();
        

        $contacts = $this->repoContact->findBy(['secteur' => $secteur]);
        $contacts = $paginator->paginate(
            $contacts,
            $request->query->getInt('page', 1),
            5
        );

        // Calendar upcoming events :
        $upcomingEvents = $this->calendarEventRepository->findUpcomingEvents($user);
        $eventsOfTheDay = $this->calendarEventRepository->findEventsOfTheDay($user);


        //stat
        $anneeActuelle = intval(date('Y'));
        $annee = $request->get('annee', $anneeActuelle);
        $statVente = $statCoachService->getStatVente($secteur->getId());
        $nbrClients = $statCoachService->getNbrClients($secteur->getId());
        $revenuAnnee = $statAgentService->getRevenuAnnee($annee, $secteur->getId());
        $nbrRdv = $statAgentService->getNbrRdv($user->getId());
        $nbrAgents = $statCoachService->getNbrAgents($secteur->getId());

        return $this->render('user_category/ambassadeur/dashboard/dashboard_index.html.twig', [
            'secteur' => $secteur,
            'contacts' => $contacts,
            'nbrAllMyContacts' => count($contacts),
            'upcomingEvents'=> $upcomingEvents,
            'eventsOfTheDay'=> $eventsOfTheDay,
            'statVente' => $statVente,
            'nbrClients' => $nbrClients,
            'revenuAnnee' => $revenuAnnee,
            'annee' => $annee,
            'anneeActuelle' => $anneeActuelle,
            'nbrRdv' => $nbrRdv,
            'nbrAgents' => $nbrAgents
        ]);
    }
    /**
     * @Route("/view", name="ambassadeur_view")
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
        return $this->render('user_category/ambassadeur/view_ambassadeur.html.twig', [
            'ambassadeur' => $ambassadeur,
            'filleul'=>$filleul
        ]);
    }

}