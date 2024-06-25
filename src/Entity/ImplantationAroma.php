<?php

namespace App\Entity;

use App\Repository\ImplantationAromaRepository;
use App\Util\Status;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImplantationAromaRepository::class)
 */
class ImplantationAroma
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
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $statut;


    /**
     * @ORM\Column(type="integer")
     */
    private $qteElmt;

    /**
     * @ORM\OneToMany(targetEntity=ImplantationElmtAroma::class, mappedBy="mere")
     */
    private $filles;
    
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $remise;

    private $remiseFinale;
    private $montant;

    /**
     * @ORM\OneToOne(targetEntity=ViewImplantationAromaTotalFull::class, mappedBy="implantation", cascade={"persist", "remove"})
     */
    private $allTotal;

    /**
     * @ORM\ManyToOne(targetEntity=ImplantationMereAroma::class, inversedBy="filles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mere;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $reassort;

    public function __construct()
    {
        $this->filles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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

    

    public function getQteElmt(): ?int
    {
        return $this->qteElmt ? $this->qteElmt : 0;
    }

    public function setQteElmt(int $qteElmt): self
    {
        $this->qteElmt = $qteElmt;

        return $this;
    }

    
    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(?string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    
    
    /**
     * @return Collection<int, ImplantationElmtAroma>
     */
    public function getFilles(): Collection
    {
        return $this->filles;
    }

    public function addFille(ImplantationElmtAroma $fille): self
    {
        if (!$this->filles->contains($fille)) {
            $this->filles[] = $fille;
            $fille->setMere($this);
        }

        return $this;
    }

    public function removeFille(ImplantationElmtAroma $fille): self
    {
        if ($this->filles->removeElement($fille)) {
            // set the owning side to null (unless already changed)
            if ($fille->getMere() === $this) {
                $fille->setMere(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of remise
     */ 
    public function getRemise()
    {
        return $this->remise ? $this->remise : 0;
    }

    /**
     * Set the value of remise
     *
     * @return  self
     */ 
    public function setRemise($remise)
    {
        $this->remise = $remise;

        return $this;
    }


    
    

    
    public function initFilles(int $count){
        for($i=0; $i<$count; $i++){
            $fille = new ImplantationElmtAroma();
            $fille->setStatut(1);
            $this->addFille($fille);
        }
    }

    
    /**
     * Set the value of filles
     *
     * @return  self
     */ 
    public function setFilles($filles)
    {
        $this->filles = $filles;

        return $this;
    }


    public function calculerTotal(){
        $total = 0;
        foreach($this->getFilles() as $fille){
            if($fille->getStatut() == Status::VALID){
                $total += $fille->getPrixFinal() * $this->getQteElmt();
            }
        }
        return $total;
    }

    
    public function calculerUG(){
        $ug = 0;
        foreach($this->getFilles() as $fille){
            if($fille->getStatut() == Status::VALID){
                $ug += $fille->getQteGratuit();
            }
        }
        return $ug;
    }

    
    public function getAllTotal(): ?ViewImplantationAromaTotalFull
    {
        return $this->allTotal;
    }

    public function setAllTotal(ViewImplantationAromaTotalFull $allTotal): self
    {
        // set the owning side of the relation if necessary
        if ($allTotal->getImplantation() !== $this) {
            $allTotal->setImplantation($this);
        }

        $this->allTotal = $allTotal;

        return $this;
    }

    /**
     * Get the value of remiseFinale
     */ 
    public function getRemiseFinale()
    {
        return $this->remiseFinale;
    }

    /**
     * Set the value of remiseFinale
     *
     * @return  self
     */ 
    public function setRemiseFinale($remiseFinale)
    {
        $this->remiseFinale = $remiseFinale;

        return $this;
    }

    public function getMere(): ?ImplantationMereAroma
    {
        return $this->mere;
    }

    public function setMere(?ImplantationMereAroma $mere): self
    {
        $this->mere = $mere;

        return $this;
    }

    public function isReassort(): ?bool
    {
        return $this->reassort;
    }

    public function setReassort(?bool $reassort): self
    {
        $this->reassort = $reassort;

        return $this;
    }

    public function isValid(){
        return $this->getStatut() === null || $this->getStatut() != Status::INVALID;
    }

    public function getFillesValid(){
        $fillesValid = new ArrayCollection();
        foreach($this->getFilles() as $f){
            if($f->isValid()) $fillesValid->add($f);
        } 
        return $fillesValid;
    }
}
