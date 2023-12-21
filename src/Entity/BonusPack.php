<?php

namespace App\Entity;

use App\Repository\BonusPackRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BonusPackRepository::class)
 */
class BonusPack
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Pack::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $pack;


    /**
     * @ORM\ManyToOne(targetEntity=HistoriqueChallengeDuo30Days::class, inversedBy="packs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bonusParent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPack(): ?Pack
    {
        return $this->pack;
    }

    public function setPack(?Pack $pack): self
    {
        $this->pack = $pack;

        return $this;
    }

    public function getBonusParent(): ?HistoriqueChallengeDuo30Days
    {
        return $this->bonusParent;
    }

    public function setBonusParent(?HistoriqueChallengeDuo30Days $bonusParent): self
    {
        $this->bonusParent = $bonusParent;

        return $this;
    }
}
