<?php

namespace App\Entity;

use App\Repository\AnnouncementRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnouncementRepository::class)
 */
class Announcement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
    */
    private ?int $id = null;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filepath;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\GreaterThan(propertyPath="startDate", message="La date de fin doit être postérieure à la date de début.")
     */
    private $endDate;

    
    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class, inversedBy="formations")
     */
    private $secteur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;


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
     */
    public function setNom($nom): self
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
     */
    public function setFilepath($filepath): self
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
     */
    public function setDescription($description): self
    {
        $this->description = $description;

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
     */
    public function setEndDate($endDate): self
    {
        $this->endDate = $endDate;

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
     */
    public function setStartDate($startDate): self
    {
        $this->startDate = $startDate;

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
     */
    public function setSecteur($secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTypeStr(){
        try {
            //code...
            return array_flip(User::SIGNING_UP_ROLES)[$this->getType()];
        } catch (\Throwable $th) {
            //throw $th;
            return '';
        }
    }
}
