<?php

namespace App\Entity;

use App\Repository\FormationQuizItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationQuizItemRepository::class)
 */
class FormationQuizItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $question;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $multipleChoix;

    /**
     * @ORM\Column(type="integer")
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="formationQuizItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function isMultipleChoix(): ?bool
    {
        return $this->multipleChoix;
    }

    public function setMultipleChoix(?bool $multipleChoix): self
    {
        $this->multipleChoix = $multipleChoix;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): self
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
}
