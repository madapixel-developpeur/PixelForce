<?php

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RemunerationHistorySecuRepository;

/**
 * @ORM\Entity(repositoryClass=RemunerationHistorySecuRepository::class)
 */
class RemunerationHistorySecu implements JsonSerializable
{

    public const TYPE_COMMISION_BASE = 1;
    public const TYPE_REMUNERATION_EQUIPE = 2;
    public const TYPE_BONUS_PALIER = 3;
    public const TYPE_BONUS_LANCEMENT = 4;


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $idAgent;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $dateReference;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $updatedAt = null;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private float $amount;

    /**
     * @ORM\Column(type="integer")
     */
    private int $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $label;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class)
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=true)
     */
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class)
     */
    private $secteur;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of idAgent
     *
     * @return string
     */
    public function getIdAgent(): string
    {
        return $this->idAgent;
    }

    /**
     * Set the value of idAgent
     *
     * @param string $idAgent
     *
     * @return self
     */
    public function setIdAgent(string $idAgent): self
    {
        $this->idAgent = $idAgent;

        return $this;
    }

    /**
     * Get the value of dateReference
     *
     * @return \DateTime
     */
    public function getDateReference(): \DateTime
    {
        return $this->dateReference;
    }

    /**
     * Set the value of dateReference
     *
     * @param \DateTime $dateReference
     *
     * @return self
     */
    public function setDateReference(\DateTime $dateReference): self
    {
        $this->dateReference = $dateReference;

        return $this;
    }

    /**
     * Get the value of updatedAt
     *
     * @return ?\DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param ?\DateTime $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of amount
     *
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @param float $amount
     *
     * @return self
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of type
     *
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param int $type
     *
     * @return self
     */
    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of label
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set the value of label
     *
     * @param string $label
     *
     * @return self
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the value of order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of order
     */
    public function setOrder($order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getTypeStr()
    {
        switch ($this->getType()) {
            case self::TYPE_BONUS_PALIER:
                return "Bonus palier";
            case self::TYPE_REMUNERATION_EQUIPE:
                return "Rémunération équipe";
            default:
                return "Commission achat";
        }
    }



    public function jsonSerialize(): array
    {
        $vars = get_object_vars($this);
        // unset($vars["infoClient"]);
        $vars['dateReference'] = $this->getDateReference()->format('Y-m-d H:i:s');
        $vars['typeStr'] = $this->getTypeStr();
        unset($vars["stripePaymentIntentId"]);
        unset($vars["stripeSubscriptionId"]);
        return $vars;
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
}
