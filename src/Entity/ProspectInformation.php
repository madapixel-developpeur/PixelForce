<?php

namespace App\Entity;

use App\Repository\ProspectInformationRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=ProspectInformationRepository::class)
 */
class ProspectInformation
{
    
    const TYPE_DEFAULT = 1;
    const TYPE_AUDIT = 2;
    const TYPE_CLIENT = 3;

    const TYPE_ARRAY_FORM = [
        self::TYPE_DEFAULT => 'Normal', 
        self::TYPE_CLIENT => 'Client', 
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\OneToOne(targetEntity=Prospect::class, mappedBy="information", cascade={"persist", "remove"})
     */
    private $prospect;

   

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

   
      /**
     * @ORM\Column(type="integer",options={"default" : 1})
     */
    private $type = self::TYPE_DEFAULT;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getprospect(): ?Prospect
    {
        return $this->prospect;
    }

    public function setProspect(?Prospect $prospect): self
    {
        // unset the owning side of the relation if necessary
        if ($prospect === null && $this->prospect !== null) {
            $this->prospect->setInformation(null);
        }

        // set the owning side of the relation if necessary
        if ($prospect !== null && $prospect->getInformation() !== $this) {
            $prospect->setInformation($this);
        }

        $this->prospect = $prospect;

        return $this;
    }

   

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function fullName()
    {
        return $this->firstname .' '. $this->lastname;
    }


    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }


    public function getStringType(){
        return self::TYPE_ARRAY_FORM[$this->getType()];
    }

}
