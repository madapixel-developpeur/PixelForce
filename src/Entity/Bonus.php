<?php

namespace App\Entity;

use App\Repository\BonusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BonusRepository::class)
 */
class Bonus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Pack::class, inversedBy="packBonus")
     */
    private $packMin;

    /**
     * @ORM\Column(type="float")
     */
    private $packMinVal;

   /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $statut;


    /**
     * @ORM\Column(type="float")
     */
    private $valeur_bonus;
    /**
     * @ORM\Column(type="float")
     */
    private $valeur_bonus_100_premier;

    /**
     * @ORM\ManyToOne(targetEntity=TypeBonus::class)
     */
    private $type_bonus;
    

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getPackMin(): ?Pack
    {
        return $this->packMin;
    }

    public function setPackMin(?Pack $packMin): self
    {
        $this->packMin = $packMin;

        return $this;
    }
    public function getPackMinVal(): ?float
    {
        return $this->packMinVal;
    }

    public function setPackMinVal(float $packMinVal): self
    {
        $this->packMinVal = $packMinVal;

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

    public function getValeurBonus(): ?float
    {
        return $this->valeur_bonus;
    }

    public function setValeurBonus(float $valeur_bonus): self
    {
        $this->valeur_bonus = $valeur_bonus;

        return $this;
    }

    public function getValeurBonus100Premier(): ?float
    {
        return $this->valeur_bonus_100_premier;
    }

    public function setValeurBonus100Premier(float $valeur_bonus_100_premier): self
    {
        $this->valeur_bonus_100_premier = $valeur_bonus_100_premier;

        return $this;
    }
    public function getTypeBonus(): ?TypeBonus
    {
        return $this->type_bonus;
    }

    public function setTypeBonus(?TypeBonus $type_bonus): self
    {
        $this->type_bonus = $type_bonus;

        return $this;
    }
}
