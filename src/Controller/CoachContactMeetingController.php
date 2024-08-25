<?php


namespace App\Controller;

use Exception;
use DateInterval;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Meeting;
use App\Form\MeetingType;
use App\Entity\CallScript;
use App\Entity\MeetingFiles;
use App\Services\FileHandler;
use App\Form\MeetingFilterType;



use App\Form\MeetingSearchType;


use App\Form\CallScriptFormType;
use App\Services\MeetingService;
use App\Entity\ContactInformation;
use App\Repository\UserRepository;
use App\Repository\ContactRepository;
use App\Repository\MeetingRepository;
use App\Repository\SecteurRepository;
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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoachContactMeetingController extends AbstractController
{
    private $entityManager;
    private $meetingStateRepository;
    private $meetingRepository;
    private $meetingService;

    public function __construct(
        EntityManagerInterface $entityManager,
        MeetingRepository $meetingRepository,
        MeetingStateRepository $meetingStateRepository,
        CoachSecteurRepository $repoCoachSecteur,
        MeetingService $meetingService,
        private FileHandler $fileHandler, 
    ) {
        $this->entityManager = $entityManager;
        $this->meetingStateRepository = $meetingStateRepository;
        $this->meetingRepository = $meetingRepository;
        $this->meetingService = $meetingService;
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
    public function coach_contact_meeting_list(Request $request, PaginatorInterface $paginator, User $agent = null, Contact $contact = null)
    {
        $coach = $this->getUser();
        $options = [];
        if ($agent) {
            $coach = $agent;
        } else {
            $options['secteur'] = $coach->getSecteurByCoach();
        }
        $search = new MeetingSearch();
        $searchForm = $this->createForm(MeetingSearchType::class, $search);
        $searchForm->handleRequest($request);
        $meetings = $paginator->paginate(
            $this->meetingRepository->findMeetingByUser($search, $coach, $contact, $options),
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
        $previousUrl = $this->generateUrl('coach_contact_meeting_list', ['agent' => $meeting->getUser()->getId(), 'contact' => $meeting->getUserToMeet()->getId()]);
        return $this->render('user_category/agent/audit/view_audit.html.twig', [
            'audit' => $meeting->getAudit(),
            'meeting' => $meeting,
            'previousUrl' => $previousUrl,

        ]);
    }
    /**
     * @Route("/coach/contact/{id}/meeting/make", name="coach_contact_meeting_make")
     */
    public function coach_contact_meeting_make(Contact $userToMeet, Request $request, CoachSecteurRepository $coachSecteurRepository, CalendarEventLabelRepository $calendarEventLabelRepository)
    {
        $user = $this->getUser();
        $error = null;
        $meeting = new Meeting();
        $meeting->setStart(new \Datetime());
        $meeting->setEnd((new \Datetime())->add(new DateInterval('PT1H')));
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $meetingTitle = $form->getData()->getTitle();
            $CoachSecteur = $coachSecteurRepository->findOneBy(['coach' => $user->getId()]);
            $secteur = $CoachSecteur->getSecteur();
            try {
                if ($userToMeet == null) throw new \Exception('User to meet invalid');

                $meetingCalendarEventLabel = $calendarEventLabelRepository->findOneBy(["value" => "meeting"]);
                if ($meetingCalendarEventLabel == null) throw new \Exception('Calendar event "meeting" is missing in the database.');

                $this->entityManager->beginTransaction();


                $meeting->setSecteur($secteur);
                $this->meetingService->saveMeeting($meeting, $user, $userToMeet);
                $this->meetingService->saveMeetingEvent($meeting, $user, $meetingCalendarEventLabel);

                $information = $userToMeet->getInformation();
                $information->setType(ContactInformation::TYPE_AUDIT);
                $this->entityManager->persist($information);

                $this->entityManager->flush();
                $this->entityManager->commit();



                $this->addFlash(
                    'success',
                    "Votre rendez-vous a été programmé."
                );

                return $this->redirectToRoute('coach_contact_meeting_fiche', ['id' => $meeting->getId()]);
            } catch (\Exception $ex) {
                $error = $ex->getMessage();
                if ($this->entityManager->getConnection()->isTransactionActive()) {
                    $this->entityManager->rollback();
                }
            }
        }

        return $this->render('user_category/coach/meeting/meeting-form.html.twig', [
            'userToMeet' => $userToMeet,
            'form' => $form->createView(),
            'error' => $error,
            'button' => 'Prendre rendez-vous'
        ]);
    }
    /**
     * @Route("/coach/contact/meeting/{id}/edit", name="coach_contact_meeting_edit")
     */
    public function coach_contact_meeting_edit(Meeting $meeting, Request $request, CoachSecteurRepository $coachSecteurRepository, CalendarEventLabelRepository $calendarEventLabelRepository)
    {
        // $meeting->setStart(new \Datetime());
        // $meeting->setEnd((new \Datetime())->add(new DateInterval('PT1H')));
        $error = null;
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try {

                $meetingCalendarEventLabel = $calendarEventLabelRepository->findOneBy(["value" => "meeting"]);
                if ($meetingCalendarEventLabel == null) throw new \Exception('Calendar event "meeting" is missing in the database.');

                $this->entityManager->beginTransaction();
                $this->meetingService->updateMeeting($meeting);
                $this->entityManager->flush();
                $this->entityManager->commit();
                $this->addFlash(
                    'success',
                    "Votre rendez-vous a été mis à jour."
                );

                return $this->redirectToRoute('coach_contact_meeting_fiche', ['id' => $meeting->getId()]);
            } catch (\Exception $ex) {
                $error = $ex->getMessage();
                if ($this->entityManager->getConnection()->isTransactionActive()) {
                    $this->entityManager->rollback();
                }
            }
        }
        return $this->render('user_category/coach/meeting/meeting-form.html.twig', [
            'userToMeet' => $meeting->getUserToMeet(),
            'form' => $form->createView(),
            'error' => $error,
            'button' => 'Modifier le rendez-vous'
        ]);
    }

    #[Route('/coach/rendez-vous/scripts-d-appel', name : 'coach_call_script_list')]
    public function listCallScript(Request $request ,PaginatorInterface $paginator,CallScriptRepository $callScriptRepository,CoachSecteurRepository $coachSecteurRepository){
        $user = $this->getUser();
        $CoachSecteur = $coachSecteurRepository->findOneBy(['coach' => $user->getId()]);
        $secteur = $CoachSecteur->getSecteur();


        $scripts = $paginator->paginate(
            $callScriptRepository->findAllScript($user,$secteur),
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('user_category/coach/meeting/script/script_list.html.twig', [
            'scripts' => $scripts,
        ]);
    }

    #[Route('/coach/rendez-vous/scripts-d-appel/nouveau', name : 'coach_call_script_add')]
    public function addScript(Request $request,CoachSecteurRepository $coachSecteurRepository){
        $user = $this->getUser();
        $script = new CallScript();
        $form = $this->createForm(CallScriptFormType::class, $script);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            try {
                $CoachSecteur = $coachSecteurRepository->findOneBy(['coach' => $user->getId()]);
                $secteur = $CoachSecteur->getSecteur();
                $script->setAuthor($user);
                $script->setSecteur($secteur);


                $this->entityManager->persist($script);
                $this->entityManager->flush();
                $this->addFlash('success', 'Script ajouté avec succès');
                return $this->redirectToRoute('coach_call_script_list');
            } catch (\Throwable $th) {
                $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
            }
        }
        return $this->render('user_category/coach/meeting/script/script_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/coach/rendez-vous/scripts-d-appel/modifier/{id}', name : 'coach_call_script_edit')]
    public function editScript(CallScript $script,Request $request,CoachSecteurRepository $coachSecteurRepository){
        $user = $this->getUser();
        $form = $this->createForm(CallScriptFormType::class, $script);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            try {
                $CoachSecteur = $coachSecteurRepository->findOneBy(['coach' => $user->getId()]);
                $secteur = $CoachSecteur->getSecteur();
                $script->setAuthor($user);
                $script->setSecteur($secteur);


                $this->entityManager->persist($script);
                $this->entityManager->flush();
                $this->addFlash('success', 'Script modifié avec succès');
                return $this->redirectToRoute('coach_call_script_list');
            } catch (\Throwable $th) {
                $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
            }
        }
        return $this->render('user_category/coach/meeting/script/script_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/coach/rendez-vous/scripts-d-appel/detail/{id}', name : 'coach_call_script_view')]
    public function viewCallScript(CallScript $callScript,Request $request){

        return $this->render('user_category/coach/meeting/script/script_view.html.twig', [
            'script' => $callScript,
        ]);
    }


    #[Route('/coach/rendez-vous/ajouter/document', name: 'coach_add_meeting_document' ,  methods: ['POST'])]
    public function addDocument(Request $request)
    {
        $files = $request->files->get('files');
        $meetingId = $request->get('meeting_id');
        try {
            $this->entityManager->beginTransaction();

            $meeting = $this->meetingRepository->findOneBy(['id'=> $meetingId ]);
            if ($files) {
                foreach ($files as $file) {
                    $document = new MeetingFiles();
                    $filePath = $this->fileHandler->upload($file, "meeting/document/".$meeting->getId());
                    $document->setFilePath($filePath);
                    $document->setFileName($file->getClientOriginalName());
                    $document->setMeeting($meeting);
                    $document->setAuthor($this->getUser());
                    $this->entityManager->persist($document);
                    $this->entityManager->flush();
                }
                $this->entityManager->flush();
                $this->entityManager->commit();
                $this->entityManager->clear();
                $this->addFlash('success',"Fichier(s) ajouté(s) avec succès.");
            }
            else{
                $this->addFlash('danger',"Veuillez choisir un fichier, s'il vous plaît.");
            }
        } catch(\Exception $ex){
            $error = $ex->getMessage();
            if($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->rollback();
            }
            $this->addFlash('danger',$_ENV['CUSTOM_ERROR_MESSAGE']);
        }
        return $this->redirectToRoute('coach_contact_meeting_fiche',['id' => $meetingId ]);
    }

    
    #[Route('/coach/rendez-vous/download/document/{id}', name: 'download_meeting_file')]
    public function downloadCommentFile(MeetingFiles $file,Request $request)
    {
        if($file->getFilePath()!=null){
            $parts = explode('/', $file->getFilePath());
            $fileNameWithExtension = end($parts);
            return $this->fileHandler->downloadFile($file->getFilePath(),$fileNameWithExtension);  
        }    
        else{
            $this->addFlash('danger', "Aucun fichier detectée");
            $route = in_array(User::ROLE_COACH, $this->getUser()->getRoles()) ? "coach_contact_meeting_fiche": "agent_contact_meeting_fiche";
            return $this->redirectToRoute('coach_contact_meeting_fiche', ['id' => $file->getMeeting()->getId()]);    
        }
    }

}
