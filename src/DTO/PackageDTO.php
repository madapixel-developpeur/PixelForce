<?php
namespace App\DTO;

use JsonSerializable;

class PackageDTO implements JsonSerializable
{



    public const VALID = 1;
    public const INVALID = -1;

    private ?int $id = null;
    private ?string $name = null;
    private ?string $service = null;
    private ?int $bv = null;
    private ?float $amount = null;
    private ?string $period = null;
    private ?int $statut = null;
    private ?int $packageType = null;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getService(): ?string
    {
        return $this->service;
    }
    public function setService(?string $service): void
    {
        $this->service = $service;
    }

    public function getBv(): ?int
    {
        return $this->bv;
    }
    public function setBv(?int $bv): void
    {
        $this->bv = $bv;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }
    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    public function getPeriod(): ?string
    {
        return $this->period;
    }
    public function setPeriod(?string $period): void
    {
        $this->period = $period;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }
    public function setStatut(?int $statut): void
    {
        $this->statut = $statut;
    }

    /**
     * Get the value of packageType
     *
     * @return ?int
     */
    public function getPackageType(): ?int
    {
        return $this->packageType;
    }

    /**
     * Set the value of packageType
     *
     * @param ?int $packageType
     *
     * @return self
     */
    public function setPackageType(?int $packageType): self
    {
        $this->packageType = $packageType;

        return $this;
    }

      public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
