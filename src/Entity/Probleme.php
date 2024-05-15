<?php
namespace App\Entity;

use App\Repository\ProblemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProblemeRepository::class)
 */
class Probleme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

     /**
     * @ORM\Column(type="integer")
     */
    private $noteRisque;

     /**
     * @ORM\ManyToOne(targetEntity=Audit::class)
     * @ORM\JoinColumn(name="audit_id", referencedColumnName="id", nullable=true)
     */
    private $audit;

    /**
     * @ORM\ManyToOne(targetEntity=ProblemeCategory::class)
     * @ORM\JoinColumn(name="problemeCategory_id", referencedColumnName="id", nullable=true)
     */
    private $problemeCategory;

     /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateAjout;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $auteur;
    
    /**
     * @ORM\OneToMany(targetEntity=Solution::class, mappedBy="probleme")
     */
    private $allSolutions;

    public function __construct()
    {
        $this->allSolutions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

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

    public function getNoteRisque(): ?int
    {
        return $this->noteRisque;
    }

    public function setNoteRisque(int $noteRisque): static
    {
        $this->noteRisque = $noteRisque;

        return $this;
    }

    public function getAudit(): ?Audit
    {
        return $this->audit;
    }

    public function setAudit(?Audit $audit): static
    {
        $this->audit = $audit;

        return $this;
    }

    public function getProblemeCategory(): ?ProblemeCategory
    {
        return $this->problemeCategory;
    }

    public function setProblemeCategory(?ProblemeCategory $problemeCategory): static
    {
        $this->problemeCategory = $problemeCategory;

        return $this;
    }

    /**
     * @return Collection<int, Solution>
     */
    public function getAllSolutions(): Collection
    {
        return $this->allSolutions;
    }

    public function addAllSolution(Solution $allSolution): static
    {
        if (!$this->allSolutions->contains($allSolution)) {
            $this->allSolutions->add($allSolution);
            $allSolution->setProbleme($this);
        }

        return $this;
    }

    public function removeAllSolution(Solution $allSolution): static
    {
        if ($this->allSolutions->removeElement($allSolution)) {
            // set the owning side to null (unless already changed)
            if ($allSolution->getProbleme() === $this) {
                $allSolution->setProbleme(null);
            }
        }

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

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

}
