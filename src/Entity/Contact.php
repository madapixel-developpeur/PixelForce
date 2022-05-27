<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $informations = [];

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contact")
     * @ORM\JoinColumn(nullable=false)
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

    public function __construct()
    {
        $this->client = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInformations(): ?array
    {
        return $this->informations;
    }

    public function setInformations(?array $informations): self
    {
        $this->informations = $informations;

        return $this;
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
}
