<?php

namespace App\Entity;

use App\Repository\DocumentRecipientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentRecipientRepository::class)
 */
class DocumentRecipient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $signedFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $paid;

    /**
     * @ORM\ManyToOne(targetEntity=Document::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $document;

    /**
     * @ORM\Column(type="integer")
     */
    private $statut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateSend;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateSigned;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $conseiller;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paymentIntentId;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSignedFile(): ?string
    {
        return $this->signedFile;
    }

    public function setSignedFile(?string $signedFile): self
    {
        $this->signedFile = $signedFile;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(?bool $paid): self
    {
        $this->paid = $paid;

        return $this;
    }

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function setDocument(?Document $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateSend(): ?\DateTimeInterface
    {
        return $this->dateSend;
    }

    public function setDateSend(\DateTimeInterface $dateSend): self
    {
        $this->dateSend = $dateSend;

        return $this;
    }

    public function getDateSigned(): ?\DateTimeInterface
    {
        return $this->dateSigned;
    }

    public function setDateSigned(?\DateTimeInterface $dateSigned): self
    {
        $this->dateSigned = $dateSigned;

        return $this;
    }

    public function getConseiller(): ?string
    {
        return $this->conseiller;
    }

    public function setConseiller(string $conseiller): self
    {
        $this->conseiller = $conseiller;

        return $this;
    }

    public function getPaymentIntentId(): ?string
    {
        return $this->paymentIntentId;
    }

    public function setPaymentIntentId(?string $paymentIntentId): self
    {
        $this->paymentIntentId = $paymentIntentId;

        return $this;
    }

    
}
