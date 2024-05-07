<?php

namespace App\Entity;

use App\Repository\MouvementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MouvementRepository::class)
 */
class Mouvement
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
    private $dateMouvement;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $entree;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $sortie;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;

    private $check;
    private $realCheck;

    /**
     * @ORM\Column(type="integer")
     */
    private $statut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMouvement(): ?\DateTimeInterface
    {
        return $this->dateMouvement;
    }

    public function setDateMouvement(\DateTimeInterface $dateMouvement): self
    {
        $this->dateMouvement = $dateMouvement;

        return $this;
    }

    public function getEntree(): ?float
    {
        return $this->entree;
    }

    public function setEntree(?float $entree): self
    {
        $this->entree = $entree;

        return $this;
    }

    public function getSortie(): ?float
    {
        return $this->sortie;
    }

    public function setSortie(?float $sortie): self
    {
        $this->sortie = $sortie;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get the value of check
     */ 
    public function getCheck(): ?int
    {
        return $this->check;
    }

    /**
     * Set the value of check
     *
     * @return  self
     */ 
    public function setCheck(?int $check)
    {
        $this->check = $check;

        return $this;
    }

    /**
     * Get the value of realCheck
     */ 
    public function getRealCheck(): ?bool
    {
        return $this->realCheck;
    }

    /**
     * Set the value of realCheck
     *
     * @return  self
     */ 
    public function setRealCheck(?bool $realCheck)
    {
        $this->realCheck = $realCheck;

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
}
