<?php

namespace App\Entity;

use App\Repository\ContactInformationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactInformationRepository::class)
 */
class ContactInformation
{
    
    const TYPE_DEFAULT = 1;
    const TYPE_AUDIT = 2;
    const TYPE_CLIENT = 3;

    const TYPE_ARRAY_FORM = [
        self::TYPE_DEFAULT => 'Normal', 
        self::TYPE_AUDIT => 'Audit', 
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
     * @ORM\OneToOne(targetEntity=Contact::class, mappedBy="information", cascade={"persist", "remove"})
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rue;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $compositionFoyer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrPersonne;

    /**
     * @ORM\ManyToOne(targetEntity=TypeLogement::class)
     */
    private $typeLogement;

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

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        // unset the owning side of the relation if necessary
        if ($contact === null && $this->contact !== null) {
            $this->contact->setInformation(null);
        }

        // set the owning side of the relation if necessary
        if ($contact !== null && $contact->getInformation() !== $this) {
            $contact->setInformation($this);
        }

        $this->contact = $contact;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;

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

    public function getCompositionFoyer(): ?string
    {
        return $this->compositionFoyer;
    }

    public function setCompositionFoyer(?string $compositionFoyer): self
    {
        $this->compositionFoyer = $compositionFoyer;

        return $this;
    }

    public function getNbrPersonne(): ?int
    {
        return $this->nbrPersonne;
    }

    public function setNbrPersonne(?int $nbrPersonne): self
    {
        $this->nbrPersonne = $nbrPersonne;

        return $this;
    }

    public function getTypeLogement(): ?TypeLogement
    {
        return $this->typeLogement;
    }

    public function setTypeLogement(?TypeLogement $typeLogement): self
    {
        $this->typeLogement = $typeLogement;

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
