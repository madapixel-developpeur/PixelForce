<?php

namespace App\Entity;

use App\Repository\AuditRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuditRepository::class)
 */
class Audit
{
    const ACTIVE_YES = 1;
    const ACTIVE_NO = 0;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomProjet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlSite;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAjout;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", options={"default": 1})
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $propriétaire;

    /**
     * @ORM\OneToMany(targetEntity=Probleme::class, mappedBy="audit")
     */
    private $allProblemes;

    /**
     * @return Collection|Probleme[]
     */
    public function getActiveProblemes(): Collection
    {
        return $this->allProblemes->filter(function(Probleme $probleme) {
            return $probleme->getIsActive()==Probleme::ACTIVE_YES;
        });
    }


    public function __construct()
    {
        $this->allProblemes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProjet(): ?string
    {
        return $this->nomProjet;
    }

    public function setNomProjet(string $nomProjet): static
    {
        $this->nomProjet = $nomProjet;

        return $this;
    }

    public function getUrlSite(): ?string
    {
        return $this->urlSite;
    }

    public function setUrlSite(string $urlSite): static
    {
        $this->urlSite = $urlSite;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): static
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Probleme>
     */
    public function getAllProblemes(): Collection
    {
        return $this->allProblemes;
    }

    public function addAllProbleme(Probleme $allProbleme): static
    {
        if (!$this->allProblemes->contains($allProbleme)) {
            $this->allProblemes->add($allProbleme);
            $allProbleme->setAudit($this);
        }

        return $this;
    }

    public function removeAllProbleme(Probleme $allProbleme): static
    {
        if ($this->allProblemes->removeElement($allProbleme)) {
            // set the owning side to null (unless already changed)
            if ($allProbleme->getAudit() === $this) {
                $allProbleme->setAudit(null);
            }
        }

        return $this;
    }

    public function getPropriétaire(): ?User
    {
        return $this->propriétaire;
    }

    public function setPropriétaire(?User $propriétaire): static
    {
        $this->propriétaire = $propriétaire;

        return $this;
    }

    public function getIsActive(): ?int
    {
        return $this->isActive;
    }

    public function setIsActive(int $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

}
