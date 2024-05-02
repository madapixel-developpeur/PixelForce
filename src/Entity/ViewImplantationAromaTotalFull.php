<?php

namespace App\Entity;

use App\Repository\ViewImplantationAromaTotalFullRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ViewImplantationAromaTotalFullRepository::class)
 */
class ViewImplantationAromaTotalFull
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=6, nullable=true)
     */
    private $total;

    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ug;

   
    /**
     * @ORM\OneToOne(targetEntity=ImplantationAroma::class, inversedBy="allTotal", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $implantation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(?string $total): self
    {
        $this->total = $total;

        return $this;
    }

    
    public function getUg(): ?string
    {
        return $this->ug;
    }

    public function setUg(?string $ug): self
    {
        $this->ug = $ug;

        return $this;
    }

    
    public function getImplantation(): ?ImplantationAroma
    {
        return $this->implantation;
    }

    public function setImplantation(ImplantationAroma $implantation): self
    {
        $this->implantation = $implantation;

        return $this;
    }
}
