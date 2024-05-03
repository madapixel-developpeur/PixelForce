<?php

namespace App\Entity;

use App\Repository\InformationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InformationsRepository::class)]
class Informations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[ORM\Column(type: 'string', length: 255, nullable:true)]
    private $nom;
    
    #[ORM\Column(type: 'string', length: 255, nullable:true)]
    private $filepath;

    #[ORM\Column(type: 'string', length: 255, nullable:true)]
    private $description;

    #[ORM\Column(type: 'datetime',nullable:true)]
    private $date_creation;

    #[ORM\Column(type: 'datetime',nullable:true)]
    private $date_fin;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom($nom): static
    {
       
        $this->nom = $nom;

        return $this;
    }

    public function getFilepath(): ?string
    {
        return $this->filepath;
    }

    public function setFilepath($filepath): static
    {
       
        $this->filepath = $filepath;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): static
    {
       
        $this->description = $description;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(?\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }


    
}


