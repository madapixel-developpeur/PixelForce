<?php

namespace App\Entity;

use App\Repository\CategorieFormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * @ORM\Entity(repositoryClass=CategorieFormationRepository::class)
 */
class CategorieFormation
{
    const STATUT = [
        1 => 'valide',
        -1 => 'supprimé'
    ];

    const ORDRE_BIENVENUE = 1;
    const ORDRE_OUTIL_PIXELFORCE = 2;
    const ORDRE_LISTE_DE_CONTACT = 3;
    const ORDRE_ADDITIONNEL = 4;

    const CONDITION_LISTE_DE_CONTACT = 100;

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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ordreCatFormation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * valeur par défaut = 1
     *  1 = valide
     * -1 = supprimé
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="CategorieFormation")
     */
    private $formations;

    /**
     * @ORM\OneToMany(targetEntity=CategorieFormationAgent::class, mappedBy="categorieFormation")
     */
    private $categorieFormationAgents;

    /**
     * @ORM\OneToMany(targetEntity=RFormationCategorie::class, mappedBy="categorie")
     */
    private $rFormationCategories;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $fonctionnalites = [];

     /**
     * @ORM\Column(type="boolean", nullable=false , options={"default": true})
     * 
     */
    private $isInProgression;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->statut = 1;
        $this->categorieFormationAgents = new ArrayCollection();
        $this->rFormationCategories = new ArrayCollection();
    }

    public function getFonctionnalites(): array
    {
        $fonctionnalites = $this->fonctionnalites ?? [];
        return array_unique($fonctionnalites);
    }

    public function setFonctionnalites(array $fonctionnalites): self
    {
        $this->fonctionnalites = $fonctionnalites;

        return $this;
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOrdreCatFormation(): ?int
    {
        return $this->ordreCatFormation;
    }

    public function setOrdreCatFormation(?int $ordreCatFormation): self
    {
        $this->ordreCatFormation = $ordreCatFormation;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(?int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setCategorieFormation($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getCategorieFormation() === $this) {
                $formation->setCategorieFormation(null);
            }
        }

        return $this;
    }

    public function getStatutType(): string
    {
        return self::STATUT[$this->statut];
    }

    /**
     * @return Collection<int, CategorieFormationAgent>
     */
    public function getCategorieFormationAgents(): Collection
    {
        return $this->categorieFormationAgents;
    }

    public function addCategorieFormationAgent(CategorieFormationAgent $categorieFormationAgent): self
    {
        if (!$this->categorieFormationAgents->contains($categorieFormationAgent)) {
            $this->categorieFormationAgents[] = $categorieFormationAgent;
            $categorieFormationAgent->setCategorieFormation($this);
        }

        return $this;
    }

    public function removeCategorieFormationAgent(CategorieFormationAgent $categorieFormationAgent): self
    {
        if ($this->categorieFormationAgents->removeElement($categorieFormationAgent)) {
            // set the owning side to null (unless already changed)
            if ($categorieFormationAgent->getCategorieFormation() === $this) {
                $categorieFormationAgent->setCategorieFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RFormationCategorie>
     */
    public function getRFormationCategories(): Collection
    {
        return $this->rFormationCategories;
    }

    public function addRFormationCategory(RFormationCategorie $rFormationCategory): self
    {
        if (!$this->rFormationCategories->contains($rFormationCategory)) {
            $this->rFormationCategories[] = $rFormationCategory;
            $rFormationCategory->setCategorie($this);
        }

        return $this;
    }

    public function removeRFormationCategory(RFormationCategorie $rFormationCategory): self
    {
        if ($this->rFormationCategories->removeElement($rFormationCategory)) {
            // set the owning side to null (unless already changed)
            if ($rFormationCategory->getCategorie() === $this) {
                $rFormationCategory->setCategorie(null);
            }
        }

        return $this;
    }



    public function getIsInProgression()
    {
        return $this->isInProgression;
    }

    public function setIsInProgression(string $isInProgression): self
    {
        $this->isInProgression = $isInProgression;

        return $this;
    }

    public function getIsInProgressionStateString(){
        if($this->getIsInProgression()){
            return "Prise en compte";
        }
        return "Non prise en compte";
    }
}
