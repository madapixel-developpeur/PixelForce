<?php

namespace App\Entity;

use App\Repository\SocialMediaInfoRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocialMediaInfoRepository::class)
 * @UniqueEntity(fields={"name"}, message="Ce réseau social a déjà été ajouté.")
 */
class SocialMediaInfo
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
    private $name;

    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

     /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;


     
    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class, inversedBy="formations")
     */
    private $secteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set the value of link
     */
    public function setLink($link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get the value of logo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set the value of logo
     */
    public function setLogo($logo): self
    {
        $this->logo = $logo;

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
}
