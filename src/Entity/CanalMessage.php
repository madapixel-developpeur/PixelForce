<?php

namespace App\Entity;

use App\Repository\CanalMessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CanalMessageRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class CanalMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"chat", "chat_getMessage"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"chat", "chat_getMessage"})
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"chat", "chat_getMessage"})
     */
    private $nom;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"chat", "chat_getMessage"})
     */
    private $isGroup;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="canalMessage")
     */
    private $messages;
    /**
     * @Groups({"chat"})
     */
    private $lastMessage;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="canalMessages")
     */
    private $users;
    private $newUsers = [];

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"chat", "chat_getMessage"})
     */
    private $vus = [];

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->users = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getIsGroup(): ?bool
    {
        return $this->isGroup;
    }

    public function setIsGroup(?bool $isGroup): self
    {
        $this->isGroup = $isGroup;

        return $this;
    }

    public function getLastMessage()
    {

       $lastMessage = $this->getMessages()->last();
       if($lastMessage instanceof Message) {
           $user = $lastMessage->getUser();
           $user->clearCanalMessages();
           $user->clearMessages();
           $lastMessage->setUser($user);
           $this->lastMessage = $lastMessage;
       }
       return $this->lastMessage;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setCanalMessage($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getCanalMessage() === $this) {
                $message->setCanalMessage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $this->newUsers[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    public function getNewUsers(): array
    {
        return $this->newUsers;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeImmutable|null $updatedAt
     * @return $this
     */
    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getVus(): ?array
    {
        return $this->vus;
    }

    public function setVus(?array $vus): self
    {
        $this->vus = $vus;

        return $this;
    }

    public function addVus($idUser): self
    {
        if(!in_array($idUser, $this->vus)) {
            $this->vus[] = $idUser;
        }

        return $this;
    }

    public function isIsGroup(): ?bool
    {
        return $this->isGroup;
    }
}
