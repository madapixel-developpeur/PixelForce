<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use App\Util\GenericUtil;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DevisRepository::class)
 */
class Devis
{
    const DEVIS_STATUS = [
        'CREATED' => 'Créé',
        'REJECTED' => 'Rejeté',
        'PAID' => 'Payé'
    ];

    const DEVIS_STATUS_INT = [
        'CREATED' => 0,
        'REJECTED' => -1,
        'PAID' => 1
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
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $files = [];

    /**
     * @ORM\ManyToOne(targetEntity=DemandeDevis::class, inversedBy="devis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $demandeDevis;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contratFileName;

    /**
     * @ORM\OneToOne(targetEntity=OrderDigital::class, mappedBy="devis", cascade={"persist", "remove"})
     */
    private $orderDigital;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $statusInt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFiles(): ?array
    {
        return $this->files;
    }

    public function setFiles(?array $files): self
    {
        $this->files = $files;

        return $this;
    }

    public function getDemandeDevis(): ?DemandeDevis
    {
        return $this->demandeDevis;
    }

    public function setDemandeDevis(?DemandeDevis $demandeDevis): self
    {
        $this->demandeDevis = $demandeDevis;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getStatusColor()
    {
        switch ($this->status) {
            case self::DEVIS_STATUS['CREATED'] :
                $color = 'primary';
                break;
            case self::DEVIS_STATUS['REJECTED'] :
                $color = 'danger';
                break;
            case self::DEVIS_STATUS['PAID'] :
                $color = 'success';
                break;
        }
        
        return $color;
    }

    public function getContratFileName(): ?string
    {
        return $this->contratFileName;
    }

    public function setContratFileName(?string $contratFileName): self
    {
        $this->contratFileName = $contratFileName;

        return $this;
    }

    public function getOrderDigital(): ?OrderDigital
    {
        return $this->orderDigital;
    }

    public function setOrderDigital(OrderDigital $orderDigital): self
    {
        // set the owning side of the relation if necessary
        if ($orderDigital->getDevis() !== $this) {
            $orderDigital->setDevis($this);
        }

        $this->orderDigital = $orderDigital;

        return $this;
    }

    public function getFilesShortName(){
        if(!$this->getFiles())
            return null;
        $filesSN = [];
        for($i=0; $i<count($this->getFiles()); $i++){
            $filesSN[] = GenericUtil::getFileName($this->getFiles()[$i]);
        }
        return $filesSN; 
    }

    public function getStatusInt(): ?int
    {
        return $this->statusInt;
    }

    public function setStatusInt(?int $statusInt): self
    {
        $this->statusInt = $statusInt;

        return $this;
    }
}
