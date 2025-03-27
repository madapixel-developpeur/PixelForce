<?php

namespace App\Entity;

use App\Repository\RankHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RankHistoryRepository::class)
 */
class RankHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
    */
    private ?int $id = null;

       /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $secteur;


    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;

      /**
     * @ORM\Column(type="integer")
     */
    private $userRank;

       /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $rankName;



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of rankName
     */
    public function getRankName()
    {
        return $this->rankName;
    }

    /**
     * Set the value of rankName
     */
    public function setRankName($rankName): self
    {
        $this->rankName = $rankName;

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
     */
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

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
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     */
    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of userRank
     */
    public function getUserRank()
    {
        return $this->userRank;
    }

    /**
     * Set the value of userRank
     */
    public function setUserRank($userRank): self
    {
        $this->userRank = $userRank;

        return $this;
    }
}
