<?php

namespace App\Entity;

use App\Repository\MeetingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MeetingRepository::class)
 */
class Meeting implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\GreaterThan("today", message="La date de début doit être ultérieure à la date d'aujourd'hui !")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\GreaterThan(propertyPath="start", message="La date de fin doit être plus éloignée que la date de début !")
     */
    private $end;

     /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="meetings")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Audit::class)
     * @ORM\JoinColumn(name="audit_id", referencedColumnName="id", nullable=true)
     */
    private $audit;

     /**
     * @ORM\ManyToOne(targetEntity="MeetingState", inversedBy="meetings")
     * @ORM\JoinColumn(name="meeting_state_id", referencedColumnName="id")
     */
    private $meetingState;

    /**
     * @ORM\ManyToOne(targetEntity=Contact::class, inversedBy="meetings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userToMeet;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(?\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }


    public function getMeetingState(): ?MeetingState
    {
        return $this->meetingState;
    }

    public function setMeetingState(?MeetingState $meetingState): self
    {
        $this->meetingState = $meetingState;

        return $this;
    }
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
    public function toCalendarEvent(bool $is_coach=false): ?CalendarEvent
    {
        $firstUrl = $is_coach ? 'coach' : 'agent';
        $event = new CalendarEvent();
        $event->setTitle($this->getTitle());
        $event->setStart($this->getStart());
        $event->setEnd($this->getEnd());
        $event->setAllDay(false);
        $event->setUrl("/".$firstUrl."/contact/meeting/".$this->getId()."/fiche");
        return $event;
    }
    public function clone(): ?Meeting
    {
        $meeting = new Meeting();
        $meeting->setTitle($this->getTitle());
        $meeting->setNote($this->getNote());
        $meeting->setStart($this->getStart());
        $meeting->setEnd($this->getEnd());
        return $meeting;
    }

    public function getUserToMeet(): ?Contact
    {
        return $this->userToMeet;
    }

    public function setUserToMeet(?Contact $userToMeet): self
    {
        $this->userToMeet = $userToMeet;

        return $this;
    }

    public function getAudit(): ?Audit
    {
        return $this->audit;
    }

    public function setAudit(?Audit $audit): static
    {
        $this->audit = $audit;

        return $this;
    }
}
