<?php


namespace App\Services;
use App\Entity\Meeting;
use App\Entity\MeetingEvent;

use App\Entity\User;
use App\Entity\Contact;


use App\Repository\MeetingRepository;
use App\Repository\MeetingStateRepository;
use App\Repository\CalendarEventLabelRepository;

use App\Entity\SearchEntity\MeetingSearch;
use App\Form\MeetingType;
use App\Form\MeetingFilterType;
use App\Form\MeetingSearchType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
class MeetingService
{
    private $entityManager;
    private $meetingStateRepository;
    private $meetingRepository;
    private $calendarEventLabelRepository;

    public function __construct(EntityManagerInterface $entityManager, MeetingRepository $meetingRepository ,MeetingStateRepository $meetingStateRepository , CalendarEventLabelRepository $calendarEventLabelRepository)
    {
        $this->entityManager = $entityManager;
        $this->meetingStateRepository = $meetingStateRepository;
        $this->meetingRepository = $meetingRepository;
        $this->calendarEventLabelRepository = $calendarEventLabelRepository;
    }

    public function saveMeeting(Meeting $meeting, User $user, Contact $userToMeet, $meetingState = null){
        if($meetingState == null) $meetingState = $this->meetingStateRepository->find(1); // En attente par défaut
        $meeting->setMeetingState($meetingState);
        $meeting->setUser($user);
        $meeting->setUserToMeet($userToMeet);
        $this->entityManager->persist($meeting);
        $this->entityManager->flush();
    }
    public function updateMeeting(Meeting $meeting, $meetingState = null){
        if($meetingState == null) $meetingState = $this->meetingStateRepository->find(1); // En attente par défaut
        $meeting->setMeetingState($meetingState);
        $this->entityManager->persist($meeting);
        $this->entityManager->flush();
    }

    public function saveMeetingEvent(Meeting $meeting, User $user, $meetingCalendarEventLabel = null){
        if($meetingCalendarEventLabel == null) $meetingCalendarEventLabel = $this->calendarEventLabelRepository->findOneBy(["value"=>"meeting"]);
        if($meetingCalendarEventLabel == null) throw new \Exception('Calendar event "meeting" is missing in the database.');

        $is_coach = in_array(User::ROLE_COACH, $user->getRoles());
        $event = $meeting->toCalendarEvent($is_coach);
        $event->setCalendarEventLabel($meetingCalendarEventLabel);
        $event->setUser($user);
        $this->entityManager->persist($event);
        $this->entityManager->flush();

        $meeting_event = new MeetingEvent();
        $meeting_event->setMeeting($meeting);
        $meeting_event->setCalendarEvent($event);
        $this->entityManager->persist($meeting_event);
        $this->entityManager->flush();
    }
}
