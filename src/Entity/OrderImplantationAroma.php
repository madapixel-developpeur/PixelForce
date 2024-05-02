<?php

namespace App\Entity;

use App\Repository\OrderImplantationAromaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderImplantationAromaRepository::class)
 */
class OrderImplantationAroma
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="integer")
     */
    private $qty;

    /**
     * @ORM\ManyToOne(targetEntity=OrderAroma::class, inversedBy="orderImplantations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderParent;

    /**
     * @ORM\ManyToOne(targetEntity=ImplantationAroma::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $implantation;

    
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $remiseImplantation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $qteElmtImplantation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $reassortImplantation;

    /**
     * @ORM\OneToMany(targetEntity=OrderImplantationElmtAroma::class, mappedBy="orderImplantationParent")
     */
    private $orderImplantationElmts;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=6)
     */
    private $prixImplantation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ugImplantation;

    public function __construct()
    {
        $this->orderImplantationElmts = new ArrayCollection();
    }
   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    

    public function getOrderParent(): ?OrderAroma
    {
        return $this->orderParent;
    }

    public function setOrderParent(?OrderAroma $orderParent): self
    {
        $this->orderParent = $orderParent;

        return $this;
    }

    
    
    public function getImplantation(): ?ImplantationAroma
    {
        return $this->implantation;
    }

    public function setImplantation(?ImplantationAroma $implantation): self
    {
        $this->implantation = $implantation;

        return $this;
    }

    public function getRemiseImplantation(): ?string
    {
        return $this->remiseImplantation;
    }

    public function setRemiseImplantation(?string $remiseImplantation): self
    {
        $this->remiseImplantation = $remiseImplantation;

        return $this;
    }

    public function getQteElmtImplantation(): ?int
    {
        return $this->qteElmtImplantation;
    }

    public function setQteElmtImplantation(?int $qteElmtImplantation): self
    {
        $this->qteElmtImplantation = $qteElmtImplantation;

        return $this;
    }

    public function isReassortImplantation(): ?bool
    {
        return $this->reassortImplantation;
    }

    public function setReassortImplantation(?bool $reassortImplantation): self
    {
        $this->reassortImplantation = $reassortImplantation;

        return $this;
    }

    /**
     * @return Collection<int, OrderImplantationElmtAroma>
     */
    public function getOrderImplantationElmts(): Collection
    {
        return $this->orderImplantationElmts;
    }

    public function addOrderImplantationElmt(OrderImplantationElmtAroma $orderImplantationElmt): self
    {
        if (!$this->orderImplantationElmts->contains($orderImplantationElmt)) {
            $this->orderImplantationElmts[] = $orderImplantationElmt;
            $orderImplantationElmt->setOrderImplantationParent($this);
        }

        return $this;
    }

    public function removeOrderImplantationElmt(OrderImplantationElmtAroma $orderImplantationElmt): self
    {
        if ($this->orderImplantationElmts->removeElement($orderImplantationElmt)) {
            // set the owning side to null (unless already changed)
            if ($orderImplantationElmt->getOrderImplantationParent() === $this) {
                $orderImplantationElmt->setOrderImplantationParent(null);
            }
        }

        return $this;
    }

    public function getPrixImplantation(): ?string
    {
        return $this->prixImplantation;
    }

    public function setPrixImplantation(string $prixImplantation): self
    {
        $this->prixImplantation = $prixImplantation;

        return $this;
    }

    public function getUgImplantation(): ?int
    {
        return $this->ugImplantation;
    }

    public function setUgImplantation(?int $ugImplantation): self
    {
        $this->ugImplantation = $ugImplantation;

        return $this;
    }

    public function getCost(){
        return $this->getPrixImplantation() * $this->getQty();
    }
}
