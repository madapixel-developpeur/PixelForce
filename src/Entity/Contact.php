<?php

namespace App\Entity;

use App\Repository\TypeLogementRepository;
use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{

    const FIRSTNAME = 'firstname';
    const LASTNAME = 'lastname';
    const EMAIL = 'email';
    const PHONE = 'phone';
    const ADDRESS = 'address';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contact")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agent;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="contact_client")
     */
    private $client;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity=ContactInformation::class, inversedBy="contact", cascade={"persist", "remove"})
     */
    private $information;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class, inversedBy="contacts_agent")
     */
    private $secteur;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="contacts", fetch="EAGER")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=Meeting::class, mappedBy="userToMeet", orphanRemoval=true)
     */
    private $meetings;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isExample;

    public function __construct()
    {
        $this->client = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->tags = new ArrayCollection();
        $this->meetings = new ArrayCollection();
    }

    public function getIsExample(): ?bool
    {
        return $this->isExample;
    }

    public function setIsExample(?bool $isExample): self
    {
        $this->isExample = $isExample;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgent(): ?User
    {
        return $this->agent;
    }

    public function setAgent(?User $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(User $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client[] = $client;
            $client->setContactClient($this);
        }

        return $this;
    }

    public function removeClient(User $client): self
    {
        if ($this->client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getContactClient() === $this) {
                $client->setContactClient(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getInformation(): ?ContactInformation
    {
        return $this->information;
    }

    public function setInformation(?ContactInformation $information): self
    {
        $this->information = $information;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getSecteur(): ?Secteur
    {
        return $this->secteur;
    }

    public function setSecteur(?Secteur $secteur): self
    {
        $this->secteur = $secteur;

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

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function getTagIds(): array
    {
        $ids = [];
        foreach ($this->tags->toArray() as $tag) {
            array_push($ids, $tag->getId());
        }
        return $ids;
    }

    public function clearTags()
    {
        foreach ($this->tags->toArray() as $tag) {
            $this->removeTag($tag);
        }
        return $this;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addContact($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeContact($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Meeting>
     */
    public function getMeetings(): Collection
    {
        return $this->meetings;
    }

    public function addMeeting(Meeting $meeting): self
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings[] = $meeting;
            $meeting->setUserToMeet($this);
        }

        return $this;
    }

    public function removeMeeting(Meeting $meeting): self
    {
        if ($this->meetings->removeElement($meeting)) {
            // set the owning side to null (unless already changed)
            if ($meeting->getUserToMeet() === $this) {
                $meeting->setUserToMeet(null);
            }
        }

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }
}
