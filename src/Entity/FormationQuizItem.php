<?php

namespace App\Entity;

use App\Repository\FormationQuizItemRepository;
use App\Util\Status;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    /**
     * @ORM\OneToMany(targetEntity=FormationQuizItemChoice::class, mappedBy="formationQuizItem")
     */
    private $formationQuizItemChoices;

    public function __construct()
    {
        $this->formationQuizItemChoices = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, FormationQuizItemChoice>
     */
    public function getFormationQuizItemChoices(): Collection
    {
        return $this->formationQuizItemChoices;
    }

    public function addFormationQuizItemChoice(FormationQuizItemChoice $formationQuizItemChoice): self
    {
        if (!$this->formationQuizItemChoices->contains($formationQuizItemChoice)) {
            $this->formationQuizItemChoices[] = $formationQuizItemChoice;
            $formationQuizItemChoice->setFormationQuizItem($this);
        }

        return $this;
    }

    public function removeFormationQuizItemChoice(FormationQuizItemChoice $formationQuizItemChoice): self
    {
        if ($this->formationQuizItemChoices->removeElement($formationQuizItemChoice)) {
            // set the owning side to null (unless already changed)
            if ($formationQuizItemChoice->getFormationQuizItem() === $this) {
                $formationQuizItemChoice->setFormationQuizItem(null);
            }
        }

        return $this;
    }

    public function getValidFormationQuizItemChoices()
    {
        $result = [];
        foreach ($this->getFormationQuizItemChoices() as $formationQuizItemChoice) {
            if($formationQuizItemChoice->getStatut() === Status::VALID){
                $result[] = $formationQuizItemChoice;
            }
        }
        return $result;
    }
}
