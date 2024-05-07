<?php

namespace App\Entity;

use App\Repository\OrderDigitalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderDigitalRepository::class)
 */
class OrderDigital
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
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orderDigitals")
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orderDigitals")
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity=Devis::class, inversedBy="orderDigital", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $devis;


    /**
     * @ORM\Column(type="array")
     */
    private $stripeData = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $agentEmail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clientEmail;

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

    public function __construct()
    {
        $this->createdAt = new \DateTime();
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

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    public function setDevis(Devis $devis): self
    {
        $this->devis = $devis;

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

    public function getAgentEmail(): ?string
    {
        return $this->agentEmail;
    }

    public function setAgentEmail(string $agentEmail): self
    {
        $this->agentEmail = $agentEmail;

        return $this;
    }

    public function getClientEmail(): ?string
    {
        return $this->clientEmail;
    }

    public function setClientEmail(string $clientEmail): self
    {
        $this->clientEmail = $clientEmail;

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

    public function getTva(){
        return 20.;
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

}
