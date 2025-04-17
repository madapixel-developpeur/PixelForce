<?php

namespace App\Entity;

use App\Repository\OrderSecuLineV2Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderSecuLineV2Repository::class)
 */
class OrderSecuLineV2
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=KitBaseSecu::class)
     */
    private $kit;

    /**
     * @ORM\ManyToOne(targetEntity=ProduitSecuAccomp::class)
     */
    private $produit;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=OrderSecuV2::class, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderParent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKit(): ?KitBaseSecu
    {
        return $this->kit;
    }

    public function setKit(?KitBaseSecu $kit): self
    {
        $this->kit = $kit;

        return $this;
    }

    public function getProduit(): ?ProduitSecuAccomp
    {
        return $this->produit;
    }

    public function setProduit(?ProduitSecuAccomp $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getOrderParent(): ?OrderSecuV2
    {
        return $this->orderParent;
    }

    public function setOrderParent(?OrderSecuV2 $orderParent): self
    {
        $this->orderParent = $orderParent;

        return $this;
    }
}
