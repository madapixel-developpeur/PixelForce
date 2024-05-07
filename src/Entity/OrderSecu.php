<?php

namespace App\Entity;

use App\Repository\OrderSecuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=OrderSecuRepository::class)
 */
class OrderSecu implements JsonSerializable
{
    public const CREATED = 100;
    public const PAIED = 1;
    public const VALIDATED = 2;
    public const REJECTED = -1;

    public const STATUS = [
        self::CREATED => "Créée", 
        self::PAIED => "Payée",
        self::VALIDATED => "Livrée",
        self::REJECTED => "Rejetée"
    ];

    public const STATUS_DATA_FORM = [
        "Créée" => self::CREATED, 
        "Payée" => self::PAIED,
        "Livrée" => self::VALIDATED,
        "Rejetée" => self::REJECTED
    ];


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ProduitSecu::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=TypeAbonnementSecu::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $typeAbonnement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codePromo;

    /**
     * @ORM\Column(type="float")
     */
    private $prixProduit;

    /**
     * @ORM\Column(type="integer")
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    private $sessionKey;

    /**
     * @ORM\OneToMany(targetEntity=OrderSecuAccomp::class, mappedBy="orderSecu")
     */
    private $accomps;

    private $accompsSession;

    /**
     * @ORM\ManyToOne(targetEntity=TypeInstallationSecu::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $typeInstallation;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $secteur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCommande;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $installationFrais;

    /**
     * @ORM\Column(type="float")
     */
    private $accompMontant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chargeId;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $contratRempli;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $contratSigned;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $sepa = [];

    /**
     * @ORM\ManyToOne(targetEntity=KitBaseSecu::class)
     */
    private $kitbase;

    /**
     * @ORM\ManyToOne(targetEntity=TvaSecu::class)
     */
    private $tva;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $tvaPourcentage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $invoicePath;

    

    public function __construct()
    {
        $this->accomps = new ArrayCollection();
        $this->accompsSession = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?ProduitSecu
    {
        return $this->produit;
    }

    public function setProduit(?ProduitSecu $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getTypeAbonnement(): ?TypeAbonnementSecu
    {
        return $this->typeAbonnement;
    }

    public function setTypeAbonnement(?TypeAbonnementSecu $typeAbonnement): self
    {
        $this->typeAbonnement = $typeAbonnement;

        return $this;
    }

    public function getCodePromo(): ?string
    {
        return $this->codePromo;
    }

    public function setCodePromo(?string $codePromo): self
    {
        $this->codePromo = $codePromo;

        return $this;
    }

    public function getPrixProduit(): ?float
    {
        return $this->prixProduit;
    }

    public function setPrixProduit(float $prixProduit): self
    {
        $this->prixProduit = $prixProduit;

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

    public function getAgent(): ?User
    {
        return $this->agent;
    }

    public function setAgent(?User $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get the value of sessionKey
     */ 
    public function getSessionKey()
    {
        return $this->sessionKey;
    }

    /**
     * Set the value of sessionKey
     *
     * @return  self
     */ 
    public function setSessionKey($sessionKey)
    {
        $this->sessionKey = $sessionKey;

        return $this;
    }

    /**
     * @return Collection<int, OrderSecuAccomp>
     */
    public function getAccomps(): Collection
    {
        return $this->accomps;
    }

    public function addAccomp(OrderSecuAccomp $accomp): self
    {
        if (!$this->accomps->contains($accomp)) {
            $this->accomps[] = $accomp;
            $accomp->setOrderSecu($this);
        }

        return $this;
    }

    public function removeAccomp(OrderSecuAccomp $accomp): self
    {
        if ($this->accomps->removeElement($accomp)) {
            // set the owning side to null (unless already changed)
            if ($accomp->getOrderSecu() === $this) {
                $accomp->setOrderSecu(null);
            }
        }

        return $this;
    }



    //session
    public function add(OrderSecuAccomp $accomp){
        $accompsSession = $this->getAccompsSession();
        $index = $this->indexOf($accomp->getProduit()->getId());
        if($index!=-1){
            $qty = $accompsSession[$index]->getQte() + $accomp->getQte();
            $accomp->setQte($qty);
            array_splice($accompsSession, $index, 1);
        } 
        $accompsSession[] = $accomp;
        $this->setAccompsSession($accompsSession);
    }

    public function indexOf($productId){
        $index = -1;
        $accompsSession = $this->getAccompsSession();
        for($i=0; $i<count($accompsSession) ; $i++){
            $accomp = $accompsSession[$i];
            
            if($accomp->getProduit()->getId()==$productId) {
                $index = $i;
                break;
            }
        }
        return $index;
    }
    
    // public function checkBasketItem(BasketItem $basketItem){
    //     $basketItem->getProduit()->checkQty($basketItem->getQuantity());
    // }

    public function update(OrderSecuAccomp $accomp){
        //$this->checkBasketItem($basketItem);
        $accompsSession = $this->getAccompsSession();
        $index = $this->indexOf($accomp->getProduit()->getId());
        if($index!=-1) array_splice($accompsSession, $index, 1);
        $accompsSession[] = $accomp;
        $this->setAccompsSession($accompsSession);
    }

    public function remove($productId){
        $accompsSession = $this->getAccompsSession();
        $index = $this->indexOf($productId);
        if($index!=-1)  array_splice($accompsSession, $index, 1);
        $this->setAccompsSession($accompsSession);
    }

    public function getMontantAccomp(){
        $montant = 0;
        for($i=0; $i<count($this->getAccompsSession()) ; $i++){
            $montant += $this->getAccompsSession()[$i]->getMontant();
        }  
        return $montant;
    }

    public function getMontantHt(){
        return $this->getPrixProduit() + $this->getMontantAccomp();
    }

    public function getMontantTva(){
        return $this->getMontantHt() * $this->getTva()->getValeur()/100;
    }

    public function getMontantTtc(){
        return $this->getMontantHt() + $this->getMontantTva();
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }

    /**
     * Get the value of accompsSession
     */ 
    public function getAccompsSession()
    {
        return $this->accompsSession;
    }

    /**
     * Set the value of accompsSession
     *
     * @return  self
     */ 
    public function setAccompsSession($accompsSession)
    {
        $this->accompsSession = $accompsSession;

        return $this;
    }

    public function getTypeInstallation(): ?TypeInstallationSecu
    {
        return $this->typeInstallation;
    }

    public function setTypeInstallation(?TypeInstallationSecu $typeInstallation): self
    {
        $this->typeInstallation = $typeInstallation;

        return $this;
    }



    public function getFraisInstallation(){
        return $this->getTypeInstallation() ? $this->getTypeInstallation()->getPrix() : 0;
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

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    

    public function refresh(EntityManagerInterface $em){
        /* if($this->getProduit()){
            $this->setProduit($em->getRepository(ProduitSecu::class)->find($this->getProduit()->getId()));
        }
        if($this->getTypeAbonnement()){
            $this->setTypeAbonnement($em->getRepository(TypeAbonnementSecu::class)->find($this->getTypeAbonnement()->getId()));
        }
        if($this->getTypeInstallation()){
            $this->setTypeInstallation($em->getRepository(TypeInstallationSecu::class)->find($this->getTypeInstallation()->getId()));
        } */
        if($this->getKitbase()){
            $this->setKitbase($em->getRepository(KitBaseSecu::class)->find($this->getKitbase()->getId()));
        }
        if($this->getTva()){
            $this->setTva($em->getRepository(TvaSecu::class)->find($this->getTva()->getId()));
        }
    }

    public function getInstallationFrais(): ?float
    {
        return $this->installationFrais;
    }

    public function setInstallationFrais(float $installationFrais): self
    {
        $this->installationFrais = $installationFrais;

        return $this;
    }

    public function getAccompMontant(): ?float
    {
        return $this->accompMontant;
    }

    public function setAccompMontant(float $accompMontant): self
    {
        $this->accompMontant = $accompMontant;

        return $this;
    }

    public function getChargeId(): ?string
    {
        return $this->chargeId;
    }

    public function setChargeId(string $chargeId): self
    {
        $this->chargeId = $chargeId;

        return $this;
    }

    public function getStatusStr(): ?string 
    {
        return OrderSecu::STATUS[$this->getStatut()];
    }


    public function getTotalHt(){
        return $this->getPrixProduit() + $this->getAccompMontant();
    }

    public function getTvaMontantBase(){
        return $this->getTotalHt() * $this->getTvaPourcentage()/100; 
    }

    public function getTotalTtc(){
       return  $this->getTotalHt() + $this->getTvaMontantBase();
    }

    public function getContratRempli(): ?string
    {
        return $this->contratRempli;
    }

    public function setContratRempli(string $contratRempli): self
    {
        $this->contratRempli = $contratRempli;

        return $this;
    }

    public function getContratSigned(): ?string
    {
        return $this->contratSigned;
    }

    public function setContratSigned(?string $contratSigned): self
    {
        $this->contratSigned = $contratSigned;

        return $this;
    }

    public function getSepa(): ?array
    {
        return $this->sepa;
    }

    public function setSepa(?array $sepa): self
    {
        $this->sepa = $sepa;

        return $this;
    }

    public function getKitbase(): ?KitBaseSecu
    {
        return $this->kitbase;
    }

    public function setKitbase(?KitBaseSecu $kitbase): self
    {
        $this->kitbase = $kitbase;

        return $this;
    }

    public function getTva(): ?TvaSecu
    {
        return $this->tva;
    }

    public function setTva(?TvaSecu $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getTvaPourcentage(): ?string
    {
        return $this->tvaPourcentage;
    }

    public function setTvaPourcentage(?string $tvaPourcentage): self
    {
        $this->tvaPourcentage = $tvaPourcentage;

        return $this;
    }

    public function getInvoicePath(): ?string
    {
        return $this->invoicePath;
    }

    public function setInvoicePath(?string $invoicePath): self
    {
        $this->invoicePath = $invoicePath;

        return $this;
    }
}
