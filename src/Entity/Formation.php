<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    const STATUS_CREATED = 0;
    const STATUS_DRAFT = -1;
    const STATUS_DELETED = -2;

    const STATUT_BLOQUEE = 'bloquee';
    const STATUT_DISPONIBLE = 'disponible';
    const STATUT_TERMINER = 'terminer';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description_deblocage;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video_id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $debloqueAgent;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="formations")
     */
    private $coach;

    /**
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="formation", fetch="EAGER")
     */
    private $medias;

    /**
     * @ORM\OneToMany(targetEntity=FormationAgent::class, mappedBy="formation", fetch="EAGER")
     */
    private $formationAgents;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $brouillon;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class, inversedBy="formations")
     */
    private $secteur;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieFormation::class, inversedBy="formations")
     */
    private $CategorieFormation;

    /**
     * @ORM\OneToOne(targetEntity=RFormationCategorie::class, mappedBy="formation", cascade={"persist", "remove"})
     */
    private $rFormationCategorie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $statut;

    public function __construct()
    {
        $this->medias = new ArrayCollection();
        $this->formationAgents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescriptionDeblocage(): ?string
    {
        return $this->description_deblocage;
    }

    public function setDescriptionDeblocage(?string $description_deblocage): self
    {
        $this->description_deblocage = $description_deblocage;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->video_id;
    }

    public function setVideoId(?string $video_id): self
    {
        $this->video_id = $video_id;

        return $this;
    }

    public function getCoach(): ?User
    {
        return $this->coach;
    }

    public function setCoach(?User $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
            $media->setFormation($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getFormation() === $this) {
                $media->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FormationAgent>
     */
    public function getFormationAgents(): Collection
    {
        return $this->formationAgents;
    }

    public function addFormationAgent(FormationAgent $formationAgent): self
    {
        if (!$this->formationAgents->contains($formationAgent)) {
            $this->formationAgents[] = $formationAgent;
            $formationAgent->setFormation($this);
        }

        return $this;
    }

    public function removeFormationAgent(FormationAgent $formationAgent): self
    {
        if ($this->formationAgents->removeElement($formationAgent)) {
            // set the owning side to null (unless already changed)
            if ($formationAgent->getFormation() === $this) {
                $formationAgent->setFormation(null);
            }
        }

        return $this;
    }

    public function getFormationAgentsByAgent()
    {
        $formationsAgents = $this->formationAgents;
        
    }

    public function getBrouillon(): ?bool
    {
        return $this->getStatut() == self::STATUS_DRAFT;
    }

    public function getBrouillonVal(): ?bool
    {
        return $this->brouillon;
    }

    public function setBrouillon(?bool $brouillon): self
    {
        $this->brouillon = $brouillon;

        return $this;
    }


    public function getDebloqueAgent(): bool
    {
        return $this->debloqueAgent;
    }


    public function setDebloqueAgent($debloqueAgent): self
    {
        $this->debloqueAgent = $debloqueAgent;
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

    public function getCategorieFormation(): ?CategorieFormation
    {
        return $this->CategorieFormation;
    }

    public function setCategorieFormation(?CategorieFormation $CategorieFormation): self
    {
        $this->CategorieFormation = $CategorieFormation;

        return $this;
    }

    public function getRFormationCategorie(): ?RFormationCategorie
    {
        return $this->rFormationCategorie;
    }

    public function setRFormationCategorie(RFormationCategorie $rFormationCategorie): self
    {
        // set the owning side of the relation if necessary
        if ($rFormationCategorie->getFormation() !== $this) {
            $rFormationCategorie->setFormation($this);
        }

        $this->rFormationCategorie = $rFormationCategorie;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(?int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }


    public function testStatut(){
        $this->setStatut($this->getBrouillonVal() ? self::STATUS_DRAFT : self::STATUS_CREATED);
    }

    public function isDebloqueAgent(): ?bool
    {
        return $this->debloqueAgent;
    }

    public function isBrouillon(): ?bool
    {
        return $this->brouillon;
    }
}
