<?php

namespace App\Entity;

use App\Repository\OrderImplantationElmtAromaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderImplantationElmtAromaRepository::class)
 */
class OrderImplantationElmtAroma
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ImplantationElmtAroma::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $implantationElmt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $qteGratuitImplantationElmt;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=6)
     */
    private $prixProduitImplantationElmt;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=6, nullable=true)
     */
    private $prixConseilleProduitImplantationElmt;

    /**
     * @ORM\ManyToOne(targetEntity=OrderImplantationAroma::class, inversedBy="orderImplantationElmts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderImplantationParent;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=6)
     */
    private $prixProduitApresReductionImplantationElmt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImplantationElmt(): ?ImplantationElmtAroma
    {
        return $this->implantationElmt;
    }

    public function setImplantationElmt(?ImplantationElmtAroma $implantationElmt): self
    {
        $this->implantationElmt = $implantationElmt;

        return $this;
    }

    public function getQteGratuitImplantationElmt(): ?int
    {
        return $this->qteGratuitImplantationElmt;
    }

    public function setQteGratuitImplantationElmt(?int $qteGratuitImplantationElmt): self
    {
        $this->qteGratuitImplantationElmt = $qteGratuitImplantationElmt;

        return $this;
    }

    public function getPrixProduitImplantationElmt(): ?string
    {
        return $this->prixProduitImplantationElmt;
    }

    public function setPrixProduitImplantationElmt(string $prixProduitImplantationElmt): self
    {
        $this->prixProduitImplantationElmt = $prixProduitImplantationElmt;

        return $this;
    }

    public function getPrixConseilleProduitImplantationElmt(): ?string
    {
        return $this->prixConseilleProduitImplantationElmt;
    }

    public function setPrixConseilleProduitImplantationElmt(?string $prixConseilleProduitImplantationElmt): self
    {
        $this->prixConseilleProduitImplantationElmt = $prixConseilleProduitImplantationElmt;

        return $this;
    }

    public function getOrderImplantationParent(): ?OrderImplantationAroma
    {
        return $this->orderImplantationParent;
    }

    public function setOrderImplantationParent(?OrderImplantationAroma $orderImplantationParent): self
    {
        $this->orderImplantationParent = $orderImplantationParent;

        return $this;
    }

    public function getPrixProduitApresReductionImplantationElmt(): ?string
    {
        return $this->prixProduitApresReductionImplantationElmt;
    }

    public function setPrixProduitApresReductionImplantationElmt(string $prixProduitApresReductionImplantationElmt): self
    {
        $this->prixProduitApresReductionImplantationElmt = $prixProduitApresReductionImplantationElmt;

        return $this;
    }

    public function getMontant(){
        return $this->getPrixProduitApresReductionImplantationElmt() * $this->getOrderImplantationParent()->getQteElmtImplantation();
    }
}
