<?php

namespace App\Entity;

use App\Repository\OrderPackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderPackRepository::class)
 */
class OrderPack
{
    // Subscription : 49 euros par an
    public const SUBSCRIPTION_AMOUNT = 49;
    public const SUBSCRIPTION_INTERVAL = "year";
    public const SUBSCRIPTION_LABEL = "Abonnement Pack Greenlife Ultimate";
    public const SUBSCRIPTION_ITERATION = 1;

    

    public const CREATED = 100;
    public const PAIED = 1;
    public const VALIDATED = 2;

    public static function IntervaltoLocale($interval){
        if($interval == "year") return "an";
        else if($interval == "month") return "mois";
        else if($interval == "day") return "jour";
        else return $interval;
    }

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
    // const TO_CHANGE = [
    //     "quantity" => "quantityToChange",
    //     "amount" => "amountToChange",
    //     "refProd" => "refProdToChange" 
    // ];
    const TO_CHANGE = [
        "quantity" => "quantityToChange",
        "amount" => "amountToChange",
        "refProd" => "refProdToChange" 
    ];
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orderPacks")
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity=Pack::class, inversedBy="orderPacks")
     */
    private $pack;


    /**
     * @ORM\Column(type="array")
     */
    private $stripeData = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stripeChargeId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $invoicePath;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullname;

     /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tva;
    
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $fraisLivraison;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $montantSansFraisLivraison;
    /**
     * @ORM\OneToMany(targetEntity=OrderPackProduct::class, mappedBy="orderParent")
     */
    private $orderProducts;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $statut_duo;

    /**
     * 
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $parrain;



    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->orderProducts = new ArrayCollection();
    }

/**
     * @return Collection<int, OrderProduct>
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderPackProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
            $orderProduct->setOrderParent($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderPackProduct $orderProduct): self
    {
        if ($this->orderProducts->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderProduct->getOrderParent() === $this) {
                $orderProduct->setOrderParent(null);
            }
        }

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getPack(): ?Pack
    {
        return $this->pack;
    }

    public function setPack(?Pack $pack): self
    {
        $this->pack = $pack;

        return $this;
    }


    public function getStripeData(): ?array
    {
        return $this->stripeData;
    }

    public function setStripeData(array $stripeData): self
    {
        $this->stripeData = $stripeData;

        return $this;
    }


    public function getStripeChargeId(): ?string
    {
        return $this->stripeChargeId;
    }

    public function setStripeChargeId(string $stripeChargeId): self
    {
        $this->stripeChargeId = $stripeChargeId;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(?int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva ?? 20.;
    }

    public function setTva(?float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getAmountHt(){
        return $this->getAmount() * (1. - $this->getTva()/100);
    }

    public function getTvaAmount(){
        return $this->getAmount() * $this->getTva()/100;
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

    
    public function getMinimumNumberOfPack(): int
    {
        return 1;
    }
    public function getFraisLivraison(): ?string
    {
        return $this->fraisLivraison;
    }

    public function setFraisLivraison(?string $fraisLivraison): self
    {
        $this->fraisLivraison = $fraisLivraison;

        return $this;
    }
    public function getMontantSansFraisLivraison(): ?string
    {
        return $this->montantSansFraisLivraison;
    }

    public function setMontantSansFraisLivraison(?string $montantSansFraisLivraison): self
    {
        $this->montantSansFraisLivraison = $montantSansFraisLivraison;

        return $this;
    }
    public function getModeExpedition()
    {
        return 1;
    }
    public function getOrderProductsQuantity()
    {
       return $this->getNbrProductInOrder() > 1 ? self::TO_CHANGE['quantity'] : $this->getNbrProductInOrder();
    }

    public function getItemsAmount()
    {
        return $this->getNbrProductInOrder() > 1 ? self::TO_CHANGE['amount']  : $this->amount;
    }
    public function getProductsInOrder()
    {
       return $this->getOrderProductsArray();
    }
    public function getOrderProductsArray(){
        return $this->getPack()->getProducts()->toArray();
    }
    public function getNbrProductInOrder()
    {
        return count($this->getOrderProductsArray());
    }
    public function getStatutDuo(): ?int
    {
        return $this->statut_duo;
    }

    public function setStatutDuo(?int $statut_duo): self
    {
        $this->statut_duo = $statut_duo;

        return $this;
    }
    public function getParrain(): ?User
    {
        return $this->parrain;
    }

    public function setParrain(?User $parrain): self
    {
        $this->parrain = $parrain;

        return $this;
    }


}
