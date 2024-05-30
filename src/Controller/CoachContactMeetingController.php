<?php


namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Meeting;
use App\Form\MeetingType;
use App\Form\MeetingFilterType;
use App\Form\MeetingSearchType;
use App\Repository\UserRepository;
use App\Repository\ContactRepository;



use App\Repository\MeetingRepository;


use App\Repository\SecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SearchEntity\MeetingSearch;
use App\Repository\AgentSecteurRepository;
use App\Repository\CoachSecteurRepository;
use App\Repository\MeetingStateRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CalendarEventLabelRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoachContactMeetingController extends AbstractController
{
    private $entityManager;
    private $meetingStateRepository;
    private $meetingRepository;

    public function __construct(EntityManagerInterface $entityManager, MeetingRepository $meetingRepository ,MeetingStateRepository $meetingStateRepository,
        private CoachSecteurRepository $repoCoachSecteur)
    {
        $this->entityManager = $entityManager;
        $this->meetingStateRepository = $meetingStateRepository;
        $this->meetingRepository = $meetingRepository;
    }

    /**
     * @Route("/coach/contact/meeting/{id}/fiche", name="coach_contact_meeting_fiche")
     */
    public function coach_contact_meeting_fiche($id)
    {
        $meeting = $this->meetingRepository->find($id);
        
        return $this->render('user_category/coach/meeting/meeting-fiche.html.twig', [
            'meeting' => $meeting
        ]);
    }

     /**
     * @Route("/coach/contact/meeting/list/{agent}/{contact}", name="coach_contact_meeting_list")
     */
    public function coach_contact_meeting_list(Request $request,PaginatorInterface $paginator,User $agent= null,Contact $contact = null)
    {
        $coach = $this->getUser();
        $options = [];
        if($agent){
            $coach = $agent;
        }else{
            $options['secteur'] = $coach->getSecteurByCoach();
        }
        $search = new MeetingSearch();
        $searchForm = $this->createForm(MeetingSearchType::class, $search);
        $searchForm->handleRequest($request);
        $meetings = $paginator->paginate(
            $this->meetingRepository->findMeetingByUser($search, $coach,$contact,$options),
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('user_category/coach/meeting/meeting-list.html.twig', [
            'meetings' => $meetings,
            'searchForm' => $searchForm->createView(),
            'contact' => $contact,
        ]);
    }

     /**
     * @Route("/coach/contact/meeting/audit/{id}/fiche", name="coach_meeting_audit_view")
     */
    public function audit_view(Meeting $meeting)
    {
        $previousUrl = $this->generateUrl('coach_contact_meeting_list', ['agent' => $meeting->getUser()->getId(),'contact'=> $meeting->getUserToMeet()->getId() ]);
        return $this->render('user_category/agent/audit/view_audit.html.twig', [
            'audit' => $meeting->getAudit(),
            'meeting'=> $meeting,
            'previousUrl'=> $previousUrl, 
        ]);
    }
}