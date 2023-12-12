<?php

namespace App\Entity;

use App\Repository\PackRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=PackRepository::class)
 */
class Pack implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=3)
     */
    private $cost;

    /**
     * @ORM\ManyToOne(targetEntity="PackCategory", inversedBy="packs")
     * @ORM\JoinColumn(name="id_pack_category", referencedColumnName="id")
     */
    private $packCategory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=OrderPack::class, mappedBy="agent")
     */
    private $orderPacks;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $document;

    /**
     * @ORM\OneToMany(targetEntity=PackProduct::class, mappedBy="pack", cascade={"persist"} )
     */
    private $products;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getCost(): ?string
    {
        return $this->cost;
    }

    public function setCost(string $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getPackCategory(): ?PackCategory
    {
        return $this->packCategory;
    }

    public function setPackCategory(PackCategory $packCategory): self
    {
        $this->packCategory = $packCategory;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(?string $document): self
    {
        $this->document = $document;

        return $this;
    }


    public function __construct(){
        $this->orderPacks = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }

    
    public function getSlugCatPack()
    {
        return (new Slugify())->slugify($this->packCategory->getName()) ;

    }
    public function getSlugPack()
    {
       return  (new Slugify())->slugify($this->getName())  ;
    }

    /**
     * @return Collection<int, OrderPack>
     */
    public function getOrderPacks(): Collection
    {
        return $this->orderPacks;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, PackProduct>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(PackProduct $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setPack($this);
        }

        return $this;
    }

    public function removeOrderProduct(PackProduct $product): self
    {
        if ($this->pro->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getPack() === $this) {
                $product->setPack(null);
            }
        }

        return $this;
    }
}
