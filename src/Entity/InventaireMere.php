<?php

namespace App\Entity;

use App\Repository\InventaireMereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventaireMereRepository::class)
 */
class InventaireMere
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInventaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=InventaireFille::class, mappedBy="mere")
     */
    private $inventaireFilles;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $secteur;

    public function __construct()
    {
        $this->inventaireFilles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInventaire(): ?\DateTimeInterface
    {
        return $this->dateInventaire;
    }

    public function setDateInventaire(\DateTimeInterface $dateInventaire): self
    {
        $this->dateInventaire = $dateInventaire;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, InventaireFille>
     */
    public function getInventaireFilles()
    {
        return $this->inventaireFilles;
    }

    public function addInventaireFille(InventaireFille $inventaireFille): self
    {
        if (!$this->inventaireFilles->contains($inventaireFille)) {
            $this->inventaireFilles[] = $inventaireFille;
            $inventaireFille->setMere($this);
        }

        return $this;
    }

    /*
    public function removeInventaireFille(InventaireFille $inventaireFille): self
    {
        if ($this->inventaireFilles->removeElement($inventaireFille)) {
            // set the owning side to null (unless already changed)
            if ($inventaireFille->getMere() === $this) {
                $inventaireFille->setMere(null);
            }
        }

        return $this;
    }
    */

    public function initFilles(int $count){
        foreach ($this->inventaireFilles as $fille ){
            $fille->setCheck(1);
        }
        
        for($i=0; $i<$count; $i++){
            $fille = new InventaireFille();
            $fille->setCheck(1);
            $this->addInventaireFille($fille);
        }
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

    /**
     * Set the value of inventaireFilles
     *
     * @return  self
     */ 
    public function setInventaireFilles($inventaireFilles)
    {
        $this->inventaireFilles = $inventaireFilles;

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

    public function removeInventaireFille(InventaireFille $inventaireFille): static
    {
        if ($this->inventaireFilles->removeElement($inventaireFille)) {
            // set the owning side to null (unless already changed)
            if ($inventaireFille->getMere() === $this) {
                $inventaireFille->setMere(null);
            }
        }

        return $this;
    }
}
