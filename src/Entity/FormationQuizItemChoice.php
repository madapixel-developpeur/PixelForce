<?php

namespace App\Entity;

use App\Repository\FormationQuizItemChoiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationQuizItemChoiceRepository::class)
 */
class FormationQuizItemChoice
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
    private $choix;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $vrai;

    /**
     * @ORM\Column(type="integer")
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=FormationQuizItem::class, inversedBy="formationQuizItemChoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formationQuizItem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChoix(): ?string
    {
        return $this->choix;
    }

    public function setChoix(string $choix): self
    {
        $this->choix = $choix;

        return $this;
    }

    public function isVrai(): ?bool
    {
        return $this->vrai;
    }

    public function setVrai(?bool $vrai): self
    {
        $this->vrai = $vrai;

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

    public function getFormationQuizItem(): ?FormationQuizItem
    {
        return $this->formationQuizItem;
    }

    public function setFormationQuizItem(?FormationQuizItem $formationQuizItem): self
    {
        $this->formationQuizItem = $formationQuizItem;

        return $this;
    }
}
