<?php

namespace App\Entity;

use App\Repository\ProduitSecuFavoriRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitSecuFavoriRepository::class)
 */
class ProduitSecuFavori
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ProduitSecu::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateFavori;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="integer")
     */
    private $statut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?ProduitSecu
    {
        return $this->produit;
    }

    public function setProduit(?ProduitSecu $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getDateFavori(): ?\DateTimeInterface
    {
        return $this->dateFavori;
    }

    public function setDateFavori(\DateTimeInterface $dateFavori): self
    {
        $this->dateFavori = $dateFavori;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

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
