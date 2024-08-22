<?php


namespace App\Controller;

use Exception;
use DateInterval;
use App\Entity\Contact;
use App\Entity\Meeting;
use App\Form\MeetingType;
use App\Entity\CallScript;
use App\Form\MeetingFilterType;
use App\Form\MeetingSearchType;
use App\Form\CallScriptFormType;
use App\Services\MeetingService;



use App\Entity\ContactInformation;


use App\Repository\UserRepository;
use App\Services\FormationService;

use App\Repository\ContactRepository;
use App\Repository\MeetingRepository;
use App\Repository\SecteurRepository;
use App\Repository\FormationRepository;
use App\Repository\CallScriptRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SearchEntity\MeetingSearch;
use App\Repository\AgentSecteurRepository;
use App\Repository\CoachSecteurRepository;
use App\Repository\MeetingStateRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CalendarEventLabelRepository;
use App\Repository\CategorieFormationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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


    public function __construct(EntityManagerInterface $entityManager, MeetingRepository $meetingRepository, MeetingStateRepository $meetingStateRepository, CalendarEventLabelRepository $calendarEventLabelRepository, ContactRepository $contactRepository, CoachSecteurRepository $coachSecteurRepository, SecteurRepository $secteurRepository, SessionInterface $session, MeetingService $meetingService,
        private  UserRepository $repoUser,
        private FormationRepository $formationRepository,
        private CallScriptRepository $callScriptRepository
    )
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

            try {
                if ($userToMeet == null) throw new \Exception('User to meet invalid');

                $meetingCalendarEventLabel = $this->calendarEventLabelRepository->findOneBy(["value" => "meeting"]);
                if ($meetingCalendarEventLabel == null) throw new \Exception('Calendar event "meeting" is missing in the database.');

                $this->entityManager->beginTransaction();

                // foreach ($allCoachSecteur as $coachSecteur) {
                //     $coach = $coachSecteur->getCoach();
                //     if($coach!=null) {
                //         $meetingCoach = $meeting->clone($coach);
                //         $this->meetingService->saveMeeting($meetingCoach, $coach, $userToMeet);
                //         $this->meetingService->saveMeetingEvent($meetingCoach, $coach, $meetingCalendarEventLabel);
                //     }

                // }
                $meeting->setSecteur($secteur);
                $this->meetingService->saveMeeting($meeting, $agent, $userToMeet);
                $this->meetingService->saveMeetingEvent($meeting, $agent, $meetingCalendarEventLabel);

                $information = $userToMeet->getInformation();
                $information->setType(ContactInformation::TYPE_AUDIT);
                $this->entityManager->persist($information);

                $this->entityManager->flush();
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
                    "Votre rendez-vous a été programmé."
                );

                return $this->redirectToRoute('agent_contact_meeting_fiche', ['id' => $meeting->getId()]);
            } catch (\Exception $ex) {
                $error = $ex->getMessage();
                if ($this->entityManager->getConnection()->isTransactionActive()) {
                    $this->entityManager->rollback();
                }
            }
        }

        return $this->render('user_category/agent/meeting/meeting-form.html.twig', [
            'userToMeet' => $userToMeet,
            'form' => $form->createView(),
            'error' => $error,
            'button' => 'Prendre rendez-vous'
        ]);
    }
    /**
     * @Route("/agent/contact/meeting/{id}/edit", name="agent_contact_meeting_edit")
     */
    public function agent_contact_meeting_edit(Meeting $meeting, Request $request)
    {

        // $meeting->setStart(new \Datetime());
        // $meeting->setEnd((new \Datetime())->add(new DateInterval('PT1H')));
        $error = null;
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try {

                $meetingCalendarEventLabel = $this->calendarEventLabelRepository->findOneBy(["value" => "meeting"]);
                if ($meetingCalendarEventLabel == null) throw new \Exception('Calendar event "meeting" is missing in the database.');

                $this->entityManager->beginTransaction();
                $this->meetingService->updateMeeting($meeting);
                $this->entityManager->flush();
                $this->entityManager->commit();
                $this->addFlash(
                    'success',
                    "Votre rendez-vous a été mis à jour."
                );

                return $this->redirectToRoute('agent_contact_meeting_fiche', ['id' => $meeting->getId()]);
            } catch (\Exception $ex) {
                $error = $ex->getMessage();
                if ($this->entityManager->getConnection()->isTransactionActive()) {
                    $this->entityManager->rollback();
                }
            }
        }
        return $this->render('user_category/agent/meeting/meeting-form.html.twig', [
            'userToMeet' => $meeting->getUserToMeet(),
            'form' => $form->createView(),
            'error' => $error,
            'button' => 'Modifier le rendez-vous'
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
     * @Route("/agent/contact/meeting/audit/{id}/fiche", name="meeting_audit_view")
     */
    public function audit_view(Meeting $meeting)
    {

        return $this->render('user_category/agent/audit/view_audit.html.twig', [
            'audit' => $meeting->getAudit(),
            'meeting' => $meeting
        ]);
    }

    /**
     * @Route("/agent/contact/meeting/list/{contact}", name="agent_contact_meeting_list")
     */
    public function agent_contact_meeting_list(Request $request, PaginatorInterface $paginator,CategorieFormationRepository $categorieFormationRepo,FormationService $formationService, Contact $contact = null)
    {
        $secteur = $this->secteurRepository->findOneBy(['id' => $this->session->get('secteurId')]);
        if(is_null($secteur)){
            return $this->redirectToRoute('agent_home');
        }
        $agent = $this->getUser();
        $search = new MeetingSearch();
        $searchForm = $this->createForm(MeetingSearchType::class, $search);
        $searchForm->handleRequest($request);
        $meetings = $paginator->paginate(
            $this->meetingRepository->findMeetingByUser($search, $agent, $contact, null, $request->get('search')),
            $request->query->getInt('page', 1),
            20
        );

        $firstCallScriptAvailable = $this->callScriptRepository->findFirstAvailableScript($agent,$secteur);
        $categorie = $categorieFormationRepo->findOneBy(['id' => $_ENV['CATEGORIE_FORMATION_RENDEZ_VOUS_ID']]);
        $formationData = $formationService->getRendezVousFormation($secteur, $request->query->get('formationId'),$categorie);
        $expert = $this->repoUser->getFirstCoachBySecteur($secteur);
        return $this->render('user_category/agent/meeting/meeting-list.html.twig', [
            'meetings' => $meetings,
            'searchForm' => $searchForm->createView(),
            'contact' => $contact,
            'expert' => $expert,
            'firstFormation' => $formationData['formation'],
            'previousFormation' => $formationData['previous'],
            'nextFormation' => $formationData['next'],
            'callScript' => $firstCallScriptAvailable
        ]);
    }

    /**
     * @Route("/meeting/api/cancel/{meetingId}", name="meeting_api_cancel", methods={"POST"})
     */
    public function cancelMeeting(Request $request, int $meetingId): JsonResponse
    {
        try {
            $meetingState = $this->meetingStateRepository->findOneBy(["name" => "Annulé"]);
            $meeting = $this->meetingRepository->find($meetingId);
            $meeting->setMeetingState($meetingState);
            $this->entityManager->persist($meeting);
            $this->entityManager->flush();
            return new JsonResponse(array('id' => $meetingId));
        } catch (Exception $ex) {
            return new JsonResponse(array('message' => $ex->getMessage()), 500);
        }
    }
    /**
     * @Route("/meeting/api/report/{meetingId}", name="meeting_api_report", methods={"POST"})
     */
    public function reportMeeting(Request $request, int $meetingId): JsonResponse
    {
        try {
            $meetingState = $this->meetingStateRepository->findOneBy(["name" => "Annulé"]);
            $meeting = $this->meetingRepository->find($meetingId);
            $meeting->setMeetingState($meetingState);
            $this->entityManager->persist($meeting);
            $this->entityManager->flush();
            return new JsonResponse(array('id' => $meetingId));
        } catch (Exception $ex) {
            return new JsonResponse(array('message' => $ex->getMessage()), 500);
        }
    }
    /**
     * @Route("/meeting/api/end/{meetingId}", name="meeting_api_end", methods={"POST"})
     */
    public function endMeeting(Request $request, int $meetingId): JsonResponse
    {
        try {
            $meetingState = $this->meetingStateRepository->findOneBy(["name" => "Terminé"]);
            $meeting = $this->meetingRepository->find($meetingId);
            $meeting->setMeetingState($meetingState);
            $this->entityManager->persist($meeting);
            $this->entityManager->flush();
            return new JsonResponse(array('id' => $meetingId));
        } catch (Exception $ex) {
            return new JsonResponse(array('message' => $ex->getMessage()), 500);
        }
    }


    
    #[Route('/agent/rendez-vous/scripts-d-appel', name : 'agent_call_script_list')]
    public function listCallScript(Request $request ,PaginatorInterface $paginator,CallScriptRepository $callScriptRepository,CoachSecteurRepository $coachSecteurRepository){
        $user = $this->getUser();
        $secteur = $this->secteurRepository->findOneBy(['id' => $this->session->get('secteurId')]);
        if(is_null($secteur)){
            return $this->redirectToRoute('agent_home');
        }


        $scripts = $paginator->paginate(
            $callScriptRepository->findAllScript($user,$secteur),
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('user_category/coach/meeting/script/script_list.html.twig', [
            'scripts' => $scripts,
        ]);
    }

    #[Route('/agent/rendez-vous/scripts-d-appel/nouveau', name : 'agent_call_script_add')]
    public function addScript(Request $request){
        $user = $this->getUser();
        $secteur = $this->secteurRepository->findOneBy(['id' => $this->session->get('secteurId')]);
        if(is_null($secteur)){
            return $this->redirectToRoute('agent_home');
        }
        $script = new CallScript();
        $form = $this->createForm(CallScriptFormType::class, $script);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            try {
                $script->setAuthor($user);
                $script->setSecteur($secteur);


                $this->entityManager->persist($script);
                $this->entityManager->flush();
                $this->addFlash('success', 'Script ajouté avec succès');
                return $this->redirectToRoute('agent_call_script_list');
            } catch (\Throwable $th) {
                $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
            }
        }
        return $this->render('user_category/coach/meeting/script/script_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/agent/rendez-vous/scripts-d-appel/modifier/{id}', name : 'agent_call_script_edit')]
    public function editScript(CallScript $script,Request $request){
        $user = $this->getUser();
        $secteur = $this->secteurRepository->findOneBy(['id' => $this->session->get('secteurId')]);
        if(is_null($secteur)){
            return $this->redirectToRoute('agent_home');
        }
        $form = $this->createForm(CallScriptFormType::class, $script);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            try {
                $script->setAuthor($user);
                $script->setSecteur($secteur);


                $this->entityManager->persist($script);
                $this->entityManager->flush();
                $this->addFlash('success', 'Script modifié avec succès');
                return $this->redirectToRoute('agent_call_script_list');
            } catch (\Throwable $th) {
                $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
            }
        }
        return $this->render('user_category/coach/meeting/script/script_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/agent/rendez-vous/scripts-d-appel/detail/{id}', name : 'agent_call_script_view')]
    public function viewCallScript(CallScript $callScript,Request $request){
        return $this->render('user_category/coach/meeting/script/script_view.html.twig', [
            'script' => $callScript,
        ]);
    }
}
