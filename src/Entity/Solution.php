<?php

namespace App\Entity;

use App\Repository\SolutionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SolutionRepository::class)
 */
class Solution
{
    const STATUS_VERIFIED = 1;
    const ROLE_UNVERIFIED = 0;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Probleme::class)
     * @ORM\JoinColumn(name="probleme_id", referencedColumnName="id", nullable=true)
     */
    private $probleme;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }
    public function getStringStatus(): ?string
    {
        switch ($this->status) {
            case self::STATUS_VERIFIED:
                return "Certifié";
            case self::ROLE_UNVERIFIED:
                return "Non Certifié";
        }
        return "Status inconnu";
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getProbleme(): ?Probleme
    {
        return $this->probleme;
    }

    public function setProbleme(?Probleme $probleme): static
    {
        $this->probleme = $probleme;

        return $this;
    }
    

}