<?php

namespace App\Entity;

use App\Repository\CalendarEventLabelRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=CalendarEventLabelRepository::class)
 * @UniqueEntity(fields="value", message="Calendar event label is already taken.")
 */
class CalendarEventLabel implements JsonSerializable
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity="CalendarEvent", mappedBy="calendarEventLabel")
     */
    private $calendarEvents;
    public function __construct() {
        $this->calendarEvents = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }

    /**
     * @return Collection<int, CalendarEvent>
     */
    public function getCalendarEvents(): Collection
    {
        return $this->calendarEvents;
    }

    public function addCalendarEvent(CalendarEvent $calendarEvent): static
    {
        if (!$this->calendarEvents->contains($calendarEvent)) {
            $this->calendarEvents->add($calendarEvent);
            $calendarEvent->setCalendarEventLabel($this);
        }

        return $this;
    }

    public function removeCalendarEvent(CalendarEvent $calendarEvent): static
    {
        if ($this->calendarEvents->removeElement($calendarEvent)) {
            // set the owning side to null (unless already changed)
            if ($calendarEvent->getCalendarEventLabel() === $this) {
                $calendarEvent->setCalendarEventLabel(null);
            }
        }

        return $this;
    }
}
