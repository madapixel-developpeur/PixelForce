<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CodePromoRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=CodePromoRepository::class)
 * @UniqueEntity(fields="code", message="Ce code promo a déjà été utilisé. Veuillez en essayer un autre.")
 */
class CodePromo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
    */
    private $id;

    
     /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $title;

     /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $code;

     /**
     * @ORM\Column(type="integer")
     */
    private $discount;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $secteur;


    /**
     * @ORM\Column(type="datetime")
    */
    private $startDate;

    

     /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\GreaterThan(propertyPath="startDate", message="La date de fin doit être postérieure à la date de début.")
     */
    private $endDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CodePromoCountry", mappedBy="codePromo", cascade={"persist", "remove"}, orphanRemoval=true)
    */
    private $codePromoCountries;


    public function __construct()
    {
        $this->codePromoCountries = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of endDate
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set the value of endDate
     */
    public function setEndDate($endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get the value of startDate
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set the value of startDate
     */
    public function setStartDate($startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the value of secteur
     */
    public function getSecteur()
    {
        return $this->secteur;
    }

    /**
     * Set the value of secteur
     */
    public function setSecteur($secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * Get the value of discount
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set the value of discount
     */
    public function setDiscount($discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get the value of code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     */
    public function setCode($code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }


    /**
     * @return Collection|CodePromoCountry[]
     */
    public function getCodePromoCountries(): Collection
    {
        return $this->codePromoCountries;
    }

    public function addCodePromoCountry(CodePromoCountry $codePromoCountry): self
    {
        if (!$this->codePromoCountries->contains($codePromoCountry)) {
            $this->codePromoCountries[] = $codePromoCountry;
            $codePromoCountry->setCodePromo($this);
        }

        return $this;
    }

    public function removeCodePromoCountry(CodePromoCountry $codePromoCountry): self
    {
        if ($this->codePromoCountries->contains($codePromoCountry)) {
            $this->codePromoCountries->removeElement($codePromoCountry);
            if ($codePromoCountry->getCodePromo() === $this) {
                $codePromoCountry->setCodePromo(null);
            }
        }

        return $this;
    }


    public function getCountryNameList(): array
    {
        $countryNames = [];
        /** @var CodePromoCountry $codePromoCountry */
        foreach ($this->codePromoCountries as $codePromoCountry) {
            $countryNames[] = \Symfony\Component\Intl\Countries::getName($codePromoCountry->getCountryCode(),'fr');
        }

        return $countryNames;
    }

    /**
     * Get the string list of countries.
     *
     * @return string
     */
    public function getCountryNameListString(): string
    {
        return implode(', ', $this->getCountryNameList());
    }

    /**
     * Get the array list of country codes.
     *
     * @return array
     */
    public function getCountryCodeList(): array
    {
        $countryCodes = [];
        /** @var CodePromoCountry $codePromoCountry */
        foreach ($this->codePromoCountries as $codePromoCountry) {
            $countryCodes[] = $codePromoCountry->getCountryCode();
        }

        return $countryCodes;
    }

}
