<?php


namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\MeetingStateRepository;
use App\Repository\MeetingRepository;
use App\Repository\AgentSecteurRepository;
use App\Repository\CoachSecteurRepository;
use App\Repository\SecteurRepository;



use App\Repository\CalendarEventLabelRepository;


use App\Entity\Meeting;
use App\Services\MeetingService;

use App\Entity\SearchEntity\MeetingSearch;
use App\Form\MeetingType;
use App\Form\MeetingFilterType;
use App\Form\MeetingSearchType;
use App\Repository\ContactRepository;
use DateInterval;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AgentContactMeetingController extends AbstractController
{
    private $entityManager;
    private $meetingStateRepository;
    private $meetingRepository;
    private $calendarEventLabelRepository;    
    private $contactRepository;
    private $coachSecteurRepository;
    private $secteurRepository;
    private $session;
    private $meetingService;


    public function __construct(EntityManagerInterface $entityManager, MeetingRepository $meetingRepository ,MeetingStateRepository $meetingStateRepository , CalendarEventLabelRepository $calendarEventLabelRepository, ContactRepository $contactRepository, CoachSecteurRepository $coachSecteurRepository, SecteurRepository $secteurRepository, SessionInterface $session, MeetingService $meetingService)
    {
        $this->entityManager = $entityManager;
        $this->meetingStateRepository = $meetingStateRepository;
        $this->meetingRepository = $meetingRepository;
        $this->calendarEventLabelRepository = $calendarEventLabelRepository;
        $this->contactRepository = $contactRepository;
        $this->coachSecteurRepository = $coachSecteurRepository;
        $this->secteurRepository = $secteurRepository;
        $this->session = $session;
        $this->meetingService = $meetingService;

    }

    /**
     * @Route("/agent/contact/{id}/meeting/make", name="agent_contact_meeting_make")
     */
    public function agent_contact_meeting_make($id, Request $request)
    {
        /** @var Contact $userToMeet */
        $userToMeet = $this->contactRepository->find($id);
        $agent = $this->getUser();
        $error = null;
        $meeting = new Meeting();
        $meeting->setStart(new \Datetime());
        $meeting->setEnd((new \Datetime())->add(new DateInterval('PT1H')));
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $meetingTitle = $form->getData()->getTitle();
            $secteurId = $this->session->get('secteurId');
            $secteur = $this->secteurRepository->find($secteurId);
            $allCoachSecteur = $this->coachSecteurRepository->findBy(['secteur' => $secteur]);
           
            try{
                if($userToMeet == null) throw new \Exception('User to meet invalid');

                $meetingCalendarEventLabel = $this->calendarEventLabelRepository->findOneBy(["value"=>"meeting"]);
                if($meetingCalendarEventLabel == null) throw new \Exception('Calendar event "meeting" is missing in the database.');
                
                $this->entityManager->beginTransaction();

                foreach ($allCoachSecteur as $coachSecteur) {
                    $coach = $coachSecteur->getCoach();
                    if($coach!=null) {
                        $meetingCoach = $meeting->clone($coach);
                        $this->meetingService->saveMeeting($meetingCoach, $coach, $userToMeet);
                        $this->meetingService->saveMeetingEvent($meetingCoach, $coach, $meetingCalendarEventLabel);
                    }
                   
                }

                $this->meetingService->saveMeeting($meeting, $agent, $userToMeet);
                $this->meetingService->saveMeetingEvent($meeting, $agent, $meetingCalendarEventLabel);

                $this->entityManager->commit();

                // // Get "En attente" meeting state
                // $defaultMeetingState = $this->meetingStateRepository->find(1);
                // if($defaultMeetingState != null) $meeting->setMeetingState($defaultMeetingState);

                // $meeting->setTitle($meetingTitle);
                // $meeting->setUser($agent);
                // $meeting->setUserToMeet($userToMeet);
                // $this->entityManager->persist($meeting);
                // $this->entityManager->flush();

                

                // // Insert calendarEvent for the current user (Agent)
                // $event = $meeting->toCalendarEvent();
                // $event->setCalendarEventLabel($meetingCalendarEventLabel);
                // $event->setUser($meeting->getUser());
                // $this->entityManager->persist($event);
                // $this->entityManager->flush();


                // // Insert calendarEvent for the coach of Agent (Coach)
                // $meetingCoach = new Meeting();
                // $meetingCoach->setTitle($meetingTitle);
                // $meetingCoach->setUser($coach);
                // $meetingCoach->setUserToMeet($userToMeet);
                // $meetingCoach->setMeetingState($defaultMeetingState);
                // $meetingCoach->setStart(new \Datetime());
                // $meetingCoach->setEnd(new \Datetime());
                // $this->entityManager->persist($meetingCoach);
                // $this->entityManager->flush();

                // $event = $meeting->toCalendarEvent();
                // $event->setCalendarEventLabel($meetingCalendarEventLabel);
                // $event->setUser($coach);
                // $this->entityManager->persist($event);
                // $this->entityManager->flush();
                
                $this->addFlash(
                   'success',
                   "Rendez-vous programmé,Veuillez remplir les informations concernant l'Audit."
                );
             
                return $this->redirectToRoute('meeting_audit_add',['id'=>$meeting->getId()]);
            } catch(\Exception $ex){
                $error = $ex->getMessage();
                if($this->entityManager->getConnection()->isTransactionActive()) {
                    $this->entityManager->rollback();
                }
            }
        }

        return $this->render('user_category/agent/meeting/meeting-form.html.twig', [
            'userToMeet' => $userToMeet,
            'form' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * @Route("/agent/contact/meeting/{id}/fiche", name="agent_contact_meeting_fiche")
     */
    public function agent_contact_meeting_fiche(Meeting $meeting)
    {   
        return $this->render('user_category/agent/meeting/meeting-fiche.html.twig', [
            'meeting' => $meeting
        ]);
    }

     /**
     * @Route("/agent/contact/meeting/list", name="agent_contact_meeting_list")
     */
    public function agent_contact_meeting_list(Request $request, PaginatorInterface $paginator)
    {
        $agent = $this->getUser();
        $search = new MeetingSearch();
        $searchForm = $this->createForm(MeetingSearchType::class, $search);
        $searchForm->handleRequest($request);
        $meetings = $paginator->paginate(
            $this->meetingRepository->findMeetingByUser($search, $agent),
            $request->query->getInt('page', 1),
            20
        );
        
        return $this->render('user_category/agent/meeting/meeting-list.html.twig', [
            'meetings' => $meetings,
            'searchForm' => $searchForm->createView()
        ]);
    }

    /**
     * @Route("/meeting/api/cancel/{meetingId}", name="meeting_api_cancel", methods={"POST"})
     */
    public function cancelMeeting(Request $request, int $meetingId): JsonResponse
    {
        try{
            $meetingState = $this->meetingStateRepository->findOneBy(["name"=>"Annulé"]);
            $meeting = $this->meetingRepository->find($meetingId);
            $meeting->setMeetingState($meetingState);
            $this->entityManager->persist($meeting);
            $this->entityManager->flush();
            return new JsonResponse(array('id' => $meetingId));
        } catch(Exception $ex){
            return new JsonResponse(array('message' => $ex->getMessage()), 500);
        }
    }
    /**
     * @Route("/meeting/api/report/{meetingId}", name="meeting_api_report", methods={"POST"})
     */
    public function reportMeeting(Request $request, int $meetingId): JsonResponse
    {
        try{
            $meetingState = $this->meetingStateRepository->findOneBy(["name"=>"Annulé"]);
            $meeting = $this->meetingRepository->find($meetingId);
            $meeting->setMeetingState($meetingState);
            $this->entityManager->persist($meeting);
            $this->entityManager->flush();
            return new JsonResponse(array('id' => $meetingId));
        } catch(Exception $ex){
            return new JsonResponse(array('message' => $ex->getMessage()), 500);
        }
    }
    /**
     * @Route("/meeting/api/end/{meetingId}", name="meeting_api_end", methods={"POST"})
     */
    public function endMeeting(Request $request, int $meetingId): JsonResponse
    {
        try{
            $meetingState = $this->meetingStateRepository->findOneBy(["name"=>"Terminé"]);
            $meeting = $this->meetingRepository->find($meetingId);
            $meeting->setMeetingState($meetingState);
            $this->entityManager->persist($meeting);
            $this->entityManager->flush();
            return new JsonResponse(array('id' => $meetingId));
        } catch(Exception $ex){
            return new JsonResponse(array('message' => $ex->getMessage()), 500);
        }
    }
}