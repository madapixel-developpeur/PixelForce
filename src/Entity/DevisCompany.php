<?php

namespace App\Entity;

use App\Repository\DevisCompanyRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DevisCompanyRepository::class)
 */
class DevisCompany
{
    const DEVIS_STATUS_INT = [
        'CREATED' => 0,
        'REJECTED' => -1,
        'SIGNED' => 1
    ];


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $company_info;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $company_logo;

    private $company_logo_encode_img_base64;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client_mail;

    /**
     * @ORM\Column(type="text")
     */
    private $client_info;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=DevisCompanyDetail::class, mappedBy="devisCompany")
     */
    private $devis_company_detail;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="devisCompanies")
     */
    private $agent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pj_filename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $devis_ref_seq;

    /**
     * @Assert\Range(
     *       min= 1,
     *       max= 100,
     *       minMessage = "Vous devez entrer un valeur supérieur à {{ min }}",
     *       maxMessage = "Vous devez entrer un valeur inférieur à {{ max }}"
     * )
     * @ORM\Column(type="integer")
     */
    private $payment_condition;

    /**
     * @ORM\Column(type="float")
     */
    private $devis_total_ht;

    /**
     * @ORM\Column(type="float")
     */
    private $devis_total_ttc;

//    /**
//     * @ORM\Column(type="string", length=255)
//     */
//    private $client_firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client_lastname;

    /**
     * @ORM\Column(type="datetime")
     */
    private $client_rdv;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateSignature;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $anonymous_client_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $anonymous_client_mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $anonymous_client_phone;

    /**
     * @ORM\OneToOne(targetEntity=OrderDigitalDevisCompany::class, mappedBy="devisCompany", cascade={"persist", "remove"})
     */
    private $orderDigitalDevisCompany;

    /**
     * @ORM\Column(type="integer")
     */
    private $iteration_payment;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class)
     */
    private $secteur;

    public function __construct()
    {
        $this->created_at = new DateTime();
        $this->devis_company_detail = new ArrayCollection();
        $this->payment_condition = 100;
        $this->status = self::DEVIS_STATUS_INT['CREATED'];
        $this->iteration_payment = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyInfo(): ?string
    {
        return $this->company_info;
    }

    public function setCompanyInfo(string $company_info): self
    {
        $this->company_info = $company_info;

        return $this;
    }

    public function getCompanyLogo(): ?string
    {
        return $this->company_logo;
    }

    public function setCompanyLogo(?string $company_logo): self
    {
        $this->company_logo = $company_logo;

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

    public function getClientInfo(): ?string
    {
        return $this->client_info;
    }

    public function setClientInfo(string $client_info): self
    {
        $this->client_info = $client_info;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, DevisCompanyDetail>
     */
    public function getDevisCompanyDetail(): Collection
    {
        return $this->devis_company_detail;
    }

    public function addDevisCompanyDetail(DevisCompanyDetail $devisCompanyDetail): self
    {
        if (!$this->devis_company_detail->contains($devisCompanyDetail)) {
            $this->devis_company_detail[] = $devisCompanyDetail;
            $devisCompanyDetail->setDevisCompany($this);
        }

        return $this;
    }

    public function removeDevisCompanyDetail(DevisCompanyDetail $devisCompanyDetail): self
    {
        if ($this->devis_company_detail->removeElement($devisCompanyDetail)) {
            // set the owning side to null (unless already changed)
            if ($devisCompanyDetail->getDevisCompany() === $this) {
                $devisCompanyDetail->setDevisCompany(null);
            }
        }

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

    public function getPjFilename(): ?string
    {
        return $this->pj_filename;
    }

    public function setPjFilename(string $pj_filename): self
    {
        $this->pj_filename = $pj_filename;

        return $this;
    }

    public function getDevisRefSeq(): ?string
    {
        return $this->devis_ref_seq;
    }

    public function setDevisRefSeq(string $devis_ref_seq): self
    {
        $this->devis_ref_seq = $devis_ref_seq;

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

    public function getDevisTotalHt(): ?float
    {
        return $this->devis_total_ht;
    }

    public function setDevisTotalHt(float $devis_total_ht): self
    {
        $this->devis_total_ht = $devis_total_ht;

        return $this;
    }

    public function getDevisTotalTtc(): ?float
    {
        return $this->devis_total_ttc;
    }

    public function setDevisTotalTtc(float $devis_total_ttc): self
    {
        $this->devis_total_ttc = $devis_total_ttc;

        return $this;
    }

//    public function getClientFirstname(): ?string
//    {
//        return $this->client_firstname;
//    }
//
//    public function setClientFirstname(string $client_firstname): self
//    {
//        $this->client_firstname = $client_firstname;
//
//        return $this;
//    }

    public function getClientLastname(): ?string
    {
        return $this->client_lastname;
    }

    public function setClientLastname(string $client_lastname): self
    {
        $this->client_lastname = $client_lastname;

        return $this;
    }

    public function getClientRdv(): ?\DateTimeInterface
    {
        return $this->client_rdv;
    }

    public function setClientRdv(\DateTimeInterface $client_rdv): self
    {
        $this->client_rdv = $client_rdv;

        return $this;
    }



    public function getCompany_logo_encode_img_base64()
    {
        return $this->company_logo_encode_img_base64;
    }


    public function setCompany_logo_encode_img_base64( $company_logo_encode_img_base64): self
    {
        $this->company_logo_encode_img_base64 = $company_logo_encode_img_base64;

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

    public function getStatusString()
    {
        switch ($this->status) {
            case self::DEVIS_STATUS_INT['CREATED'] :
                $status = 'créé';
                break;
            case self::DEVIS_STATUS_INT['REJECTED'] :
                $status = 'rejeté';
                break;
            case self::DEVIS_STATUS_INT['SIGNED'] :
                $status = 'signé';
                break;
            default :
                $status = ' ';
                break;
        }
        
        return $status;
            
        
    }

    public function getStatusColor()
    {
        switch ($this->status) {
            case self::DEVIS_STATUS_INT['CREATED'] :
                $color = 'primary';
                break;
            case self::DEVIS_STATUS_INT['REJECTED'] :
                $color = 'danger';
                break;
            case self::DEVIS_STATUS_INT['SIGNED'] :
                $color = 'success';
                break;
            default :
                $color = 'null';
                break;
        }
        
        return $color;
    }

    public function getDateSignature(): ?\DateTimeInterface
    {
        return $this->dateSignature;
    }

    public function setDateSignature(?\DateTimeInterface $dateSignature): self
    {
        $this->dateSignature = $dateSignature;

        return $this;
    }

    public function getAnonymousClientName(): ?string
    {
        return $this->anonymous_client_name;
    }

    public function setAnonymousClientName(?string $anonymous_client_name): self
    {
        $this->anonymous_client_name = $anonymous_client_name;

        return $this;
    }

    public function getAnonymousClientMail(): ?string
    {
        return $this->anonymous_client_mail;
    }

    public function setAnonymousClientMail(?string $anonymous_client_mail): self
    {
        $this->anonymous_client_mail = $anonymous_client_mail;

        return $this;
    }

    public function getAnonymousClientPhone(): ?string
    {
        return $this->anonymous_client_phone;
    }

    public function setAnonymousClientPhone(?string $anonymous_client_phone): self
    {
        $this->anonymous_client_phone = $anonymous_client_phone;

        return $this;
    }

    public function getOrderDigitalDevisCompany(): ?OrderDigitalDevisCompany
    {
        return $this->orderDigitalDevisCompany;
    }

    public function setOrderDigitalDevisCompany(OrderDigitalDevisCompany $orderDigitalDevisCompany): self
    {
        // set the owning side of the relation if necessary
        if ($orderDigitalDevisCompany->getDevisCompany() !== $this) {
            $orderDigitalDevisCompany->setDevisCompany($this);
        }

        $this->orderDigitalDevisCompany = $orderDigitalDevisCompany;

        return $this;
    }

    public function getIterationPayment(): ?int
    {
        return $this->iteration_payment;
    }

    public function setIterationPayment(int $iteration_payment): self
    {
        $this->iteration_payment = $iteration_payment;

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

  
}
