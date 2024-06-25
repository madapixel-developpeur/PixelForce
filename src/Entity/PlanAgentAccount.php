<?php

namespace App\Entity;

use App\Repository\PlanAgentAccountRepository;
use App\Services\StripeService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlanAgentAccountRepository::class)
 */
class PlanAgentAccount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $stipeProductId;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $stripePriceId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stripePriceName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $priceIntervalUnit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=SubscriptionPlanAgentAccount::class, mappedBy="planAgentAccount")
     */
    private $subscriptions;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $statusChange;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $priceMetadata = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $oldStripePriceId;


    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
        $this->statusChange = StripeService::STATUS_CHANGE['ACTIVE'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStipeProductId(): ?string
    {
        return $this->stipeProductId;
    }

    public function setStipeProductId(string $stipeProductId): self
    {
        $this->stipeProductId = $stipeProductId;

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

    public function getStripePriceName(): ?string
    {
        return $this->stripePriceName;
    }

    public function setStripePriceName(string $stripePriceName): self
    {
        $this->stripePriceName = $stripePriceName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getPriceIntervalUnit(): ?string
    {
        return $this->priceIntervalUnit;
    }

    public function setPriceIntervalUnit(string $priceIntervalUnit): self
    {
        $this->priceIntervalUnit = $priceIntervalUnit;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, SubscriptionPlanAgentAccount>
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(SubscriptionPlanAgentAccount $subscription): self
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions[] = $subscription;
            $subscription->setPlanAgentAccount($this);
        }

        return $this;
    }

    public function removeSubscription(SubscriptionPlanAgentAccount $subscription): self
    {
        if ($this->subscriptions->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getPlanAgentAccount() === $this) {
                $subscription->setPlanAgentAccount(null);
            }
        }

        return $this;
    }

    public function getStatusChange(): ?string
    {
        return $this->statusChange;
    }

    public function setStatusChange(?string $statusChange): self
    {
        $this->statusChange = $statusChange;

        return $this;
    }

    public function getPriceMetadata(): ?array
    {
        return $this->priceMetadata;
    }

    public function setPriceMetadata(?array $priceMetadata): self
    {
        $this->priceMetadata = $priceMetadata;

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
