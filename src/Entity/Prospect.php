<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProspectRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=ProspectRepository::class)
 */
class Prospect
{

      
    const TYPE_DEFAULT = 1;
    const TYPE_AUDIT = 2;
    const TYPE_CLIENT = 3;

    const TYPE_ARRAY_FORM = [
        self::TYPE_DEFAULT => 'Normal', 
        self::TYPE_CLIENT => 'Client', 
    ];

    const EUROPE_PLATFORM = 1;
    const AFRICA_PLATFORM = 2;

    
    const NEWS_LETTERS_OK = 0 ;
    const NEWS_LETTERS_NEED_TO_SEND = 1 ;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


      /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $agent;
    
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

   
    /**
     * @ORM\Column(type="integer",options={"default" : 1})
     */
    private $type = self::TYPE_DEFAULT;

        /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

      /**
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $account;


      /**
     * @ORM\Column(type="integer",options={"default" : 1})
     */
    private $platform = self::EUROPE_PLATFORM;

         /**
     * @ORM\Column(type="integer", nullable=true, options={"default": 0 })
     */
    private $newsLettersState = 0;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $emailAgent;


    

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


    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

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
     *
     * @return  self
     */ 
    public function setAgent($agent)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get the value of note
     */ 
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set the value of note
     *
     * @return  self
     */ 
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get the value of rue
     */ 
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * Set the value of rue
     *
     * @return  self
     */ 
    public function setRue($rue)
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * Get the value of account
     */ 
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set the value of account
     *
     * @return  self
     */ 
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get the value of platform
     */ 
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Set the value of platform
     *
     * @return  self
     */ 
    public function setPlatform($platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * Get the value of newsLettersState
     */ 
    public function getNewsLettersState()
    {
        return $this->newsLettersState;
    }

    /**
     * Set the value of newsLettersState
     *
     * @return  self
     */ 
    public function setNewsLettersState($newsLettersState)
    {
        $this->newsLettersState = $newsLettersState;

        return $this;
    }

    /**
     * Get the value of emailAgent
     */ 
    public function getEmailAgent()
    {
        return $this->emailAgent;
    }

    /**
     * Set the value of emailAgent
     *
     * @return  self
     */ 
    public function setEmailAgent($emailAgent)
    {
        $this->emailAgent = $emailAgent;

        return $this;
    }
}
