<?php

namespace App\Entity;

use App\Repository\OrderPackProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderPackProductRepository::class)
 */
class OrderPackProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=3)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $qty;

    /**
     * @ORM\ManyToOne(targetEntity=OrderPack::class, inversedBy="orderProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderParent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Produit
    {
        return $this->product;
    }

    public function setProduct(?Produit $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
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

    public function getOrderParent(): ?OrderPack
    {
        return $this->orderParent;
    }

    public function setOrderParent(?OrderPack $orderParent): self
    {
        $this->orderParent = $orderParent;

        return $this;
    }

    public function getAmount() {
        return $this->getPrice() * $this->getQty();
    } 
}
