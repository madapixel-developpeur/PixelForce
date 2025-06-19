<?php
namespace App\DTO;

use JsonSerializable;

class PackageTypeDTO implements JsonSerializable
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $typeProjectId = null;

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

    public function getTypeProjectId(): ?string
    {
        return $this->typeProjectId;
    }
    public function setTypeProjectId(?string $typeProjectId): void
    {
        $this->typeProjectId = $typeProjectId;
    }

     public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
