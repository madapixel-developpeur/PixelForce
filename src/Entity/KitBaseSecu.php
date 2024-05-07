<?php

namespace App\Entity;

use App\Repository\KitBaseSecuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * @ORM\Entity(repositoryClass=KitBaseSecuRepository::class)
 */
class KitBaseSecu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity=KitBaseElmtSecu::class, mappedBy="kitBase")
     */
    private $elmts;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $secteur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function __construct()
    {
        $this->elmts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, KitBaseElmtSecu>
     */
    public function getElmts(): Collection
    {
        return $this->elmts;
    }

    public function addElmt(KitBaseElmtSecu $elmt): self
    {
        if (!$this->elmts->contains($elmt)) {
            $this->elmts[] = $elmt;
            $elmt->setKitBase($this);
        }

        return $this;
    }

    public function removeElmt(KitBaseElmtSecu $elmt): self
    {
        if ($this->elmts->removeElement($elmt)) {
            // set the owning side to null (unless already changed)
            if ($elmt->getKitBase() === $this) {
                $elmt->setKitBase(null);
            }
        }

        return $this;
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

    public function getSecteur(): ?Secteur
    {
        return $this->secteur;
    }

    public function setSecteur(?Secteur $secteur): self
    {
        $this->secteur = $secteur;

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


    public function initFilles(int $count){
        foreach ($this->getElmts() as $fille ){
            $fille->setCheck(1);
            $count--;
        }
        
        for($i=0; $i<$count; $i++){
            $fille = new KitBaseElmtSecu();
            $fille->setCheck(1);
            $this->addElmt($fille);
        }
    }

    /**
     * Set the value of elmts
     *
     * @return  self
     */ 
    public function setElmts($elmts)
    {
        $this->elmts = $elmts;

        return $this;
    }

    public function checkValid(){
        if($this->getStatus() == 0)
            throw new Exception("Kit de base invalide");
    }
    
}
