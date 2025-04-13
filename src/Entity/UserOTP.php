<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserOTPRepository;


/**
 * @ORM\Entity(repositoryClass=UserOTPRepository::class)
 */
class UserOTP
{
    const LINKED_ACCOUNT_CONFIRMATION = 1;


    const STATUS_CREATED = 1;
    const STATUS_INVALID = 0;


   /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?User $user = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $value = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $operationType = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $status = null;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private ?\DateTimeImmutable $createdAt = null;

    // This field is not persisted
    private ?string $clearValue = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $email = null;


    /**
     * Get the value of id
     *
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param ?int $id
     *
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of user
     *
     * @return ?User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @param ?User $user
     *
     * @return self
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of value
     *
     * @return ?string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @param ?string $value
     *
     * @return self
     */
    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of operationType
     *
     * @return ?int
     */
    public function getOperationType(): ?int
    {
        return $this->operationType;
    }

    /**
     * Set the value of operationType
     *
     * @param ?int $operationType
     *
     * @return self
     */
    public function setOperationType(?int $operationType): self
    {
        $this->operationType = $operationType;

        return $this;
    }

    /**
     * Get the value of status
     *
     * @return ?int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param ?int $status
     *
     * @return self
     */
    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of createdAt
     *
     * @return ?\DateTimeImmutable
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param ?\DateTimeImmutable $createdAt
     *
     * @return self
     */
    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of clearValue
     *
     * @return ?string
     */
    public function getClearValue(): ?string
    {
        return $this->clearValue;
    }

    /**
     * Set the value of clearValue
     *
     * @param ?string $clearValue
     *
     * @return self
     */
    public function setClearValue(?string $clearValue): self
    {
        $this->clearValue = $clearValue;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return ?string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param ?string $email
     *
     * @return self
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
