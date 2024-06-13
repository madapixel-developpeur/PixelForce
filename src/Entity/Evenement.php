<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
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
    private $nom;
    
     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filepath;

       /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couvertureFilePath;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
    */
    private $createdAt;

      /**
     * @ORM\Column(type="datetime", nullable=true)
    */
    private $startDate;
    /**
     * @ORM\Column(type="datetime", nullable=true)
    */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
    */
    private $coach;

     /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $ville;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of filepath
     */ 
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * Set the value of filepath
     *
     * @return  self
     */ 
    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;

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
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of startDate
     */ 
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set the value of startDate
     *
     * @return  self
     */ 
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the value of endDate
     */ 
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set the value of endDate
     *
     * @return  self
     */ 
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get the value of coach
     */ 
    public function getCoach()
    {
        return $this->coach;
    }

    /**
     * Set the value of coach
     *
     * @return  self
     */ 
    public function setCoach($coach)
    {
        $this->coach = $coach;

        return $this;
    }

    /**
     * Get the value of ville
     */ 
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set the value of ville
     *
     * @return  self
     */ 
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get the value of couvertureFilePath
     */ 
    public function getCouvertureFilePath()
    {
        return $this->couvertureFilePath;
    }

    /**
     * Set the value of couvertureFilePath
     *
     * @return  self
     */ 
    public function setCouvertureFilePath($couvertureFilePath)
    {
        $this->couvertureFilePath = $couvertureFilePath;

        return $this;
    }
}
