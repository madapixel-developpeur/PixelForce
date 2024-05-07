<?php

namespace App\Entity;

use App\Repository\LiveChatVideoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LiveChatVideoRepository::class)
 */
class LiveChatVideo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="liveChatVideosFromUserA")
     */
    private $userA;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="liveChatVideosFromUserB")
     */
    private $userB;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isSpeedLive;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateDebutLive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $theme;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isInProcess;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class, inversedBy="liveChatVideos")
     */
    private $secteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserA(): ?User
    {
        return $this->userA;
    }

    public function setUserA(?User $userA): self
    {
        $this->userA = $userA;

        return $this;
    }

    public function getUserB(): ?User
    {
        return $this->userB;
    }

    public function setUserB(?User $userB): self
    {
        $this->userB = $userB;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getIsSpeedLive(): ?bool
    {
        return $this->isSpeedLive;
    }

    public function setIsSpeedLive(?bool $is_speedLive): self
    {
        $this->isSpeedLive = $is_speedLive;

        return $this;
    }

    public function getDateDebutLive(): ?\DateTimeInterface
    {
        return $this->dateDebutLive;
    }

    public function setDateDebutLive(?\DateTimeInterface $dateDebutLive): self
    {
        $this->dateDebutLive = $dateDebutLive;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsInProcess(): ?bool
    {
        return $this->isInProcess;
    }

    public function setIsInProcess(?bool $isInProcess): self
    {
        $this->isInProcess = $isInProcess;

        return $this;
    }

    public function getSecteur(): ?Secteur
    {
        return $this->secteur;
    }

    public function setSecteur(?Secteur $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function isIsSpeedLive(): ?bool
    {
        return $this->isSpeedLive;
    }

    public function isIsInProcess(): ?bool
    {
        return $this->isInProcess;
    }
}
