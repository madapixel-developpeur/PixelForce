<?php

namespace App\Entity;

use App\Repository\OrderDigitalDevisCompanyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderDigitalDevisCompanyRepository::class)
 */
class OrderDigitalDevisCompany
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $total_amount_ht;

    /**
     * @ORM\Column(type="float")
     */
    private $total_amount_ttc;

    /**
     * @ORM\Column(type="integer")
     */
    private $payment_condition;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client_mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client_phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $stripeData = [];

    /**
     * @ORM\OneToOne(targetEntity=DevisCompany::class, inversedBy="orderDigitalDevisCompany", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $devisCompany;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stripeChargeId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $iteration_payment;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount_with_condition_payment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stripe_customer_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stripe_sub_sched_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stripe_price_id;

    public function __construct()
    {
        $this->createdAt = new \Datetime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalAmountHt(): ?float
    {
        return $this->total_amount_ht;
    }

    public function setTotalAmountHt(float $total_amount_ht): self
    {
        $this->total_amount_ht = $total_amount_ht;

        return $this;
    }

    public function getTotalAmountTtc(): ?float
    {
        return $this->total_amount_ttc;
    }

    public function setTotalAmountTtc(float $total_amount_ttc): self
    {
        $this->total_amount_ttc = $total_amount_ttc;

        return $this;
    }

    public function getPaymentCondition(): ?int
    {
        return $this->payment_condition;
    }

    public function setPaymentCondition(int $payment_condition): self
    {
        $this->payment_condition = $payment_condition;

        return $this;
    }

    public function getClientName(): ?string
    {
        return $this->client_name;
    }

    public function setClientName(string $client_name): self
    {
        $this->client_name = $client_name;

        return $this;
    }

    public function getClientMail(): ?string
    {
        return $this->client_mail;
    }

    public function setClientMail(string $client_mail): self
    {
        $this->client_mail = $client_mail;

        return $this;
    }

    public function getClientPhone(): ?string
    {
        return $this->client_phone;
    }

    public function setClientPhone(string $client_phone): self
    {
        $this->client_phone = $client_phone;

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

    public function getStripeData(): ?array
    {
        return $this->stripeData;
    }

    public function setStripeData(?array $stripeData): self
    {
        $this->stripeData = $stripeData;

        return $this;
    }

    public function getDevisCompany(): ?DevisCompany
    {
        return $this->devisCompany;
    }

    public function setDevisCompany(DevisCompany $devisCompany): self
    {
        $this->devisCompany = $devisCompany;

        return $this;
    }

    public function getStripeChargeId(): ?string
    {
        return $this->stripeChargeId;
    }

    public function setStripeChargeId(?string $stripeChargeId): self
    {
        $this->stripeChargeId = $stripeChargeId;

        return $this;
    }

    public function getIterationPayment(): ?int
    {
        return $this->iteration_payment;
    }

    public function setIterationPayment(?int $iteration_payment): self
    {
        $this->iteration_payment = $iteration_payment;

        return $this;
    }

    public function getAmountWithConditionPayment(): ?float
    {
        return $this->amount_with_condition_payment;
    }

    public function setAmountWithConditionPayment(?float $amount_with_condition_payment): self
    {
        $this->amount_with_condition_payment = $amount_with_condition_payment;

        return $this;
    }

    public function getStripeCustomerId(): ?string
    {
        return $this->stripe_customer_id;
    }

    public function setStripeCustomerId(?string $stripe_customer_id): self
    {
        $this->stripe_customer_id = $stripe_customer_id;

        return $this;
    }

    public function getStripeSubSchedId(): ?string
    {
        return $this->stripe_sub_sched_id;
    }

    public function setStripeSubSchedId(?string $stripe_sub_sched_id): self
    {
        $this->stripe_sub_sched_id = $stripe_sub_sched_id;

        return $this;
    }

    public function getStripePriceId(): ?string
    {
        return $this->stripe_price_id;
    }

    public function setStripePriceId(?string $stripe_price_id): self
    {
        $this->stripe_price_id = $stripe_price_id;

        return $this;
    }
}
