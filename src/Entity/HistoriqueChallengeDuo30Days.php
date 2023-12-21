<?php

namespace App\Entity;

use App\Repository\HistoriqueChallengeDuo30DaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoriqueChallengeDuo30DaysRepository::class)
 */
class HistoriqueChallengeDuo30Days
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=BonusPack::class, mappedBy="bonusParent")
     */
    private $bonusPacks;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="challengeDuo30Days")
     */
    private $agent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->bonusPacks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



/**
     * @return Collection<int, BonusPack>
     */
    public function getBonusPacks(): Collection
    {
        return $this->bonusPacks;
    }

    public function addBonusPack(BonusPack $bonusPack): self
    {
        if (!$this->bonusPacks->contains($bonusPack)) {
            $this->bonusPacks[] = $bonusPack;
            $bonusPack->setBonusParent($this);
        }

        return $this;
    }

    public function removeBonusPack(BonusPack $bonusPack): self
    {
        if ($this->bonusPacks->removeElement($bonusPack)) {
            // set the owning side to null (unless already changed)
            if ($bonusPack->getBonusParent() === $this) {
                $bonusPack->setBonusParent(null);
            }
        }

        return $this;
    }
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
    public function getAgent(): ?User
    {
        return $this->agent;
    }

    public function setAgent(?User $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}
