<?php

namespace App\Entity;

use App\Repository\SubscriptionPlanAgentAccountRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubscriptionPlanAgentAccountRepository::class)
 */
class SubscriptionPlanAgentAccount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="subscriptionPlanAgentAccounts")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userEmail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stripeSubscriptionId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stripeCustumerId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stripePriceId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stripeProductId;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $stripeSubscriptionInterval;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $stripeSubscriptionStatus;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\ManyToOne(targetEntity=PlanAgentAccount::class, inversedBy="subscriptions")
     */
    private $planAgentAccount;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $stripePriceName;

    /**
     * @ORM\Column(type="array")
     */
    private $stripeData = [];

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $oldPriceAmount;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $typeChange;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $oldStripePriceId;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
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

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): self
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getStripeSubscriptionId(): ?string
    {
        return $this->stripeSubscriptionId;
    }

    public function setStripeSubscriptionId(string $stripeSubscriptionId): self
    {
        $this->stripeSubscriptionId = $stripeSubscriptionId;

        return $this;
    }

    public function getStripeCustumerId(): ?string
    {
        return $this->stripeCustumerId;
    }

    public function setStripeCustumerId(?string $stripeCustumerId): self
    {
        $this->stripeCustumerId = $stripeCustumerId;

        return $this;
    }

    public function getStripePriceId(): ?string
    {
        return $this->stripePriceId;
    }

    public function setStripePriceId(string $stripePriceId): self
    {
        $this->stripePriceId = $stripePriceId;

        return $this;
    }

    public function getStripeProductId(): ?string
    {
        return $this->stripeProductId;
    }

    public function setStripeProductId(string $stripeProductId): self
    {
        $this->stripeProductId = $stripeProductId;

        return $this;
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

    public function getStripeSubscriptionInterval(): ?string
    {
        return $this->stripeSubscriptionInterval;
    }

    public function setStripeSubscriptionInterval(string $stripeSubscriptionInterval): self
    {
        $this->stripeSubscriptionInterval = $stripeSubscriptionInterval;

        return $this;
    }

    public function getStripeSubscriptionStatus(): ?string
    {
        return $this->stripeSubscriptionStatus;
    }

    public function setStripeSubscriptionStatus(string $stripeSubscriptionStatus): self
    {
        $this->stripeSubscriptionStatus = $stripeSubscriptionStatus;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getPlanAgentAccount(): ?PlanAgentAccount
    {
        return $this->planAgentAccount;
    }

    public function setPlanAgentAccount(?PlanAgentAccount $planAgentAccount): self
    {
        $this->planAgentAccount = $planAgentAccount;

        return $this;
    }

    public function getStripePriceName(): ?string
    {
        return $this->stripePriceName;
    }

    public function setStripePriceName(string $stripePriceName): self
    {
        $this->stripePriceName = $stripePriceName;

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

    public function getOldPriceAmount(): ?float
    {
        return $this->oldPriceAmount;
    }

    public function setOldPriceAmount(?float $oldPriceAmount): self
    {
        $this->oldPriceAmount = $oldPriceAmount;

        return $this;
    }

    public function getTypeChange(): ?string
    {
        return $this->typeChange;
    }

    public function setTypeChange(?string $typeChange): self
    {
        $this->typeChange = $typeChange;

        return $this;
    }

    public function getOldStripePriceId(): ?string
    {
        return $this->oldStripePriceId;
    }

    public function setOldStripePriceId(?string $oldStripePriceId): self
    {
        $this->oldStripePriceId = $oldStripePriceId;

        return $this;
    }
}
