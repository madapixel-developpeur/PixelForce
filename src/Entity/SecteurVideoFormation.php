<?php

namespace App\Entity;

use App\Repository\SecteurVideoFormationRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=SecteurVideoFormationRepository::class)
 */
class SecteurVideoFormation
{
     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

       /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlVideo;
    
    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class, inversedBy="formations")
     */
    private $secteur;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * Get the value of urlVideo
     */ 
    public function getUrlVideo()
    {
        return $this->urlVideo;
    }

    /**
     * Set the value of urlVideo
     *
     * @return  self
     */ 
    public function setUrlVideo($urlVideo)
    {
        $this->urlVideo = $urlVideo;

        return $this;
    }
}
