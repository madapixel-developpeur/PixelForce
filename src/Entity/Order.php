<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{

    public const CREATED = 100;
    public const PAIED = 1;
    public const VALIDATED = 2;

    public const STATUS = [
        self::CREATED => "Créée", 
        self::PAIED => "Payée",
        self::VALIDATED => "Livrée"
    ];

    public const STATUS_DATA_FORM = [
        "Créée" => self::CREATED, 
        "Payée" => self::PAIED,
        "Livrée" => self::VALIDATED
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderDate;

    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=3)
     */
    private $amount;

    /**
     * @ORM\OneToOne(targetEntity=OrderAddress::class, cascade={"persist", "remove"})
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=OrderProduct::class, mappedBy="orderParent")
     */
    private $orderProducts;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $chargeId;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $secteur;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $tva;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $invoicePath;

    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAddress(): ?OrderAddress
    {
        return $this->address;
    }

    public function setAddress(?OrderAddress $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, OrderProduct>
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
            $orderProduct->setOrderParent($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderProduct->getOrderParent() === $this) {
                $orderProduct->setOrderParent(null);
            }
        }

        return $this;
    }

    public function getStatusStr(): ?string 
    {
        return Order::STATUS[$this->getStatus()];
    }

    public function getChargeId(): ?string
    {
        return $this->chargeId;
    }

    public function setChargeId(?string $chargeId): self
    {
        $this->chargeId = $chargeId;

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

    public function getSecteur(): ?Secteur
    {
        return $this->secteur;
    }

    public function setSecteur(?Secteur $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getTva(): ?string
    {
        return $this->tva ?? 20.;
    }

    public function setTva(?string $tva): self
    {
        $this->tva = $tva;

        return $this;
    }


    public function getMontantTva(){
        return $this->getAmount() * $this->getTva() / (100 + $this->getTva());
    }

    public function getMontantHt(){
        return $this->getAmount() / (1. + $this->getTva()/100);
    }

    public function getInvoicePath(): ?string
    {
        return $this->invoicePath;
    }

    public function setInvoicePath(?string $invoicePath): self
    {
        $this->invoicePath = $invoicePath;

        return $this;
    }
}
