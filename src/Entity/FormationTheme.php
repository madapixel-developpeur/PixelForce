<?php

namespace App\Entity;

use App\Repository\FormationThemeRepository;
use App\Util\Status;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=FormationThemeRepository::class)
 */
class FormationTheme implements JsonSerializable
{

    

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
     * @ORM\ManyToOne(targetEntity=Secteur::class)
     */
    private $secteur;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieFormation::class)
     */
    private $categorieFormation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $statut;

    public function __construct()
    {
        
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
        return $this->categorieFormation;
    }

    public function setCategorieFormation(?CategorieFormation $categorieFormation): self
    {
        $this->categorieFormation = $categorieFormation;

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

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        unset($vars['secteur']);
        unset($vars['categorieFormation']);
        $vars['secteurId'] = $this->getSecteur()->getId();
        $vars['categorieFormationId'] = $this->getCategorieFormation()->getId();
        return $vars;
    }

    
}
