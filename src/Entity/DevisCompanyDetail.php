<?php

namespace App\Entity;

use App\Repository\DevisCompanyDetailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DevisCompanyDetailRepository::class)
 */
class DevisCompanyDetail
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
    private $reference;

    /**
     * @ORM\Column(type="text")
     */
    private $designation;

    /**
     * @ORM\Column(type="float")
     */
    private $quantite;

    /**
     * @ORM\Column(type="float")
     */
    private $pu_vente;

    /**
     * @ORM\Column(type="float")
     */
    private $tva;


    private $image_encode_img_base64;


    /**
     * @Assert\Image()
     *
     */
    public $fileImage;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=DevisCompany::class, inversedBy="devis_company_detail")
     * @ORM\JoinColumn(nullable=false)
     */
    private $devisCompany;

    /**
     * @ORM\Column(type="float")
     */
    private $montant_ht;

    /**
     * @ORM\Column(type="float")
     */
    private $total_ttc;

    private $imageHidden;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPuVente(): ?float
    {
        return $this->pu_vente;
    }

    public function setPuVente(float $pu_vente): self
    {
        $this->pu_vente = $pu_vente;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function setFileImage(UploadedFile $fileImage = null)
    {
        $this->fileImage = $fileImage;
    }
 
    public function getFileImage()
    {
        return $this->fileImage;
    }


    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDevisCompany(): ?DevisCompany
    {
        return $this->devisCompany;
    }

    public function setDevisCompany(?DevisCompany $devisCompany): self
    {
        $this->devisCompany = $devisCompany;

        return $this;
    }

    public function getMontantHt(): ?float
    {
        return $this->montant_ht;
    }

    public function setMontantHt(float $montant_ht): self
    {
        $this->montant_ht = $montant_ht;

        return $this;
    }

    public function getTotalTtc(): ?float
    {
        return $this->total_ttc;
    }

    public function setTotalTtc(float $total_ttc): self
    {
        $this->total_ttc = $total_ttc;

        return $this;
    }


    public function getImage_encode_img_base64()
    {
        return $this->image_encode_img_base64;
    }

    public function setImage_encode_img_base64($image_encode_img_base64): self
    {
        $this->image_encode_img_base64 = $image_encode_img_base64;

        return $this;
    }

    /**
     * Get the value of imageHidden
     */ 
    public function getImageHidden()
    {
        return $this->imageHidden;
    }

    /**
     * Set the value of imageHidden
     *
     * @return  self
     */ 
    public function setImageHidden($imageHidden)
    {
        $this->imageHidden = $imageHidden;

        return $this;
    }
}
