<?php

namespace App\Entity;

use App\Repository\ProduitSecuRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\CategorieSecu;
use Exception;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=ProduitSecuRepository::class)
 */
class ProduitSecu implements JsonSerializable
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
     * @ORM\Column(type="string", length=800, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $secteur;

    /**
     * @ORM\Column(type="integer")
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity="CategorieSecu", inversedBy="products")
     * @ORM\JoinColumn(name="id_categorie", referencedColumnName="id")
     */
    private $categorie;

    private $estFavori;

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


    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
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

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }



    /**
     * Get the value of categorie
     */ 
    public function getCategorie(): ?CategorieSecu
    {
        return $this->categorie;
    }

    /**
     * Set the value of categorie
     *
     * @return  self
     */ 
    public function setCategorie(CategorieSecu $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function checkValid(){
        if($this->getStatut() == 0)
            throw new Exception("Produit invalide");
    }
    

    /**
     * Get the value of estFavori
     */ 
    public function getEstFavori()
    {
        return $this->estFavori;
    }

    /**
     * Set the value of estFavori
     *
     * @return  self
     */ 
    public function setEstFavori($estFavori)
    {
        $this->estFavori = $estFavori;

        return $this;
    }
}
