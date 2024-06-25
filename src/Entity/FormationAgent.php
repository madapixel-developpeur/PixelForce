<?php

namespace App\Entity;

use App\Repository\FormationAgentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationAgentRepository::class)
 */
class FormationAgent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="formationAgents")
     */
    private $formation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="formationAgents")
     */
    private $agent;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $lastResultSnapshot = [];

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $lastResultScore;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $maxResultSnapshot = [];

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $maxResultScore;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

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

    public function getLastResultSnapshot(): ?array
    {
        return $this->lastResultSnapshot;
    }

    public function setLastResultSnapshot(?array $lastResultSnapshot): self
    {
        $this->lastResultSnapshot = $lastResultSnapshot;

        return $this;
    }

    public function getLastResultScore(): ?string
    {
        return $this->lastResultScore;
    }

    public function setLastResultScore(?string $lastResultScore): self
    {
        $this->lastResultScore = $lastResultScore;

        return $this;
    }

    public function getMaxResultSnapshot(): ?array
    {
        return $this->maxResultSnapshot;
    }

    public function setMaxResultSnapshot(?array $maxResultSnapshot): self
    {
        $this->maxResultSnapshot = $maxResultSnapshot;

        return $this;
    }

    public function getMaxResultScore(): ?string
    {
        return $this->maxResultScore;
    }

    public function setMaxResultScore(?string $maxResultScore): self
    {
        $this->maxResultScore = $maxResultScore;

        return $this;
    }
}
