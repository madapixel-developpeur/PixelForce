<?php

namespace App\Entity;

use App\Repository\FormationPageConfigurationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationPageConfigurationRepository::class)
 */
class FormationPageConfiguration
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
    private $introductionVideo;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $introductionPhoto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $heureFormation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class, inversedBy="formations")
     */
    private $secteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of introductionVideo
     */ 
    public function getIntroductionVideo()
    {
        return $this->introductionVideo;
    }

    /**
     * Set the value of introductionVideo
     *
     * @return  self
     */ 
    public function setIntroductionVideo($introductionVideo)
    {
        $this->introductionVideo = $introductionVideo;

        return $this;
    }

    /**
     * Get the value of introductionPhoto
     */ 
    public function getIntroductionPhoto()
    {
        return $this->introductionPhoto;
    }

    /**
     * Set the value of introductionPhoto
     *
     * @return  self
     */ 
    public function setIntroductionPhoto($introductionPhoto)
    {
        $this->introductionPhoto = $introductionPhoto;

        return $this;
    }

    /**
     * Get the value of heureFormation
     */ 
    public function getHeureFormation()
    {
        return $this->heureFormation;
    }

    /**
     * Set the value of heureFormation
     *
     * @return  self
     */ 
    public function setHeureFormation($heureFormation)
    {
        $this->heureFormation = $heureFormation;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of secteur
     */ 
    public function getSecteur()
    {
        return $this->secteur;
    }

    /**
     * Set the value of secteur
     *
     * @return  self
     */ 
    public function setSecteur($secteur)
    {
        $this->secteur = $secteur;

        return $this;
    }
}
