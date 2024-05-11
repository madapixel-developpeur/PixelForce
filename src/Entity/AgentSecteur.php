<?php

namespace App\Entity;

use App\Repository\AgentSecteurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgentSecteurRepository::class)
 */
class AgentSecteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="agentSecteurs",fetch="EAGER")
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class, inversedBy="agentSecteurs",fetch="EAGER")
     */
    private $secteur;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateValidation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $currentFormationRank;

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

    public function getSecteur(): ?Secteur
    {
        return $this->secteur;
    }

    public function setSecteur(?Secteur $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->dateValidation;
    }

    public function setDateValidation(?\DateTimeInterface $dateValidation): self
    {
        $this->dateValidation = $dateValidation;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function getCurrentFormationRank(): ?int
    {
        return $this->currentFormationRank;
    }

    public function setCurrentFormationRank(int $currentFormationRank): self
    {
        $this->currentFormationRank = $currentFormationRank;

        return $this;
    }
}
