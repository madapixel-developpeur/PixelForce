<?php

namespace App\Entity;

use App\Repository\AgentCaTrackingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgentCaTrackingRepository::class)
 */
class AgentCaTracking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="agentSecteurs",fetch="EAGER")
     */
    private $agent;

    /**
     * @ORM\Column(type="json")
     */
    private $details = [];

       /**
     * @ORM\Column(type="decimal", precision=10, scale=3)
     */
    private $amount;



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     */
    public function setAmount($amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of details
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set the value of details
     */
    public function setDetails($details): self
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get the value of agent
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set the value of agent
     */
    public function setAgent($agent): self
    {
        $this->agent = $agent;

        return $this;
    }
}
