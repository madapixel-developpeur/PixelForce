<?php

namespace App\Entity;

use App\Repository\SecteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=SecteurRepository::class)
 */
class Secteur implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couverture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $liens;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $videoInfo;

    /**
     * @ORM\OneToMany(targetEntity=AgentSecteur::class, mappedBy="secteur")
     */
    private $agentSecteurs;

    /**
     * @ORM\OneToMany(targetEntity=CoachSecteur::class, mappedBy="secteur")
     */
    private $coachSecteurs;


    /**
     * @var array
     */
    private $agents;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="secteur")
     */
    private $formations;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="secteur")
     */
    private $contacts_agent;

    /**
     * @ORM\OneToMany(targetEntity=LiveChatVideo::class, mappedBy="secteur")
     */
    private $liveChatVideos;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="secteur")
     */
    private $produits;

    /**
     * @ORM\ManyToOne(targetEntity=TypeSecteur::class)
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity=ContratSecu::class, mappedBy="secteur", cascade={"persist", "remove"})
     */
    private $contratSecu;



    public function __construct()
    {
        $this->agentSecteurs = new ArrayCollection();
        $this->coachSecteurs = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->contacts_agent = new ArrayCollection();
        $this->liveChatVideos = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->active = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
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

    /**
     * @return Collection<int, AgentSecteur>
     */
    public function getAgentSecteurs(): Collection
    {
        return $this->agentSecteurs;
    }

    public function addAgentSecteur(AgentSecteur $agentSecteur): self
    {
        if (!$this->agentSecteurs->contains($agentSecteur)) {
            $this->agentSecteurs[] = $agentSecteur;
            $agentSecteur->setSecteur($this);
        }

        return $this;
    }

    public function removeAgentSecteur(AgentSecteur $agentSecteur): self
    {
        if ($this->agentSecteurs->removeElement($agentSecteur)) {
            // set the owning side to null (unless already changed)
            if ($agentSecteur->getSecteur() === $this) {
                $agentSecteur->setSecteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CoachSecteur>
     */
    public function getCoachSecteurs(): Collection
    {
        return $this->coachSecteurs;
    }

    public function addCoachSecteur(CoachSecteur $coachSecteur): self
    {
        if (!$this->coachSecteurs->contains($coachSecteur)) {
            $this->coachSecteurs[] = $coachSecteur;
            $coachSecteur->setSecteur($this);
        }

        return $this;
    }

    public function removeCoachSecteur(CoachSecteur $coachSecteur): self
    {
        if ($this->coachSecteurs->removeElement($coachSecteur)) {
            // set the owning side to null (unless already changed)
            if ($coachSecteur->getSecteur() === $this) {
                $coachSecteur->setSecteur(null);
            }
        }

        return $this;
    }


    public function getAgents()
    {
        /** @var  $agentSecteur AgentSecteur */
       $agentSecteurs = $this->agentSecteurs->toArray();
       foreach($agentSecteurs as $agentSecteur) {
           $this->agents[] = $agentSecteur->getAgent();
       }

       return $this->agents;
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
            $formation->setSecteur($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getSecteur() === $this) {
                $formation->setSecteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContactsAgent(): Collection
    {
        return $this->contacts_agent;
    }

    public function addContactsAgent(Contact $contactsAgent): self
    {
        if (!$this->contacts_agent->contains($contactsAgent)) {
            $this->contacts_agent[] = $contactsAgent;
            $contactsAgent->setSecteur($this);
        }

        return $this;
    }

    public function removeContactsAgent(Contact $contactsAgent): self
    {
        if ($this->contacts_agent->removeElement($contactsAgent)) {
            // set the owning side to null (unless already changed)
            if ($contactsAgent->getSecteur() === $this) {
                $contactsAgent->setSecteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LiveChatVideo>
     */
    public function getLiveChatVideos(): Collection
    {
        return $this->liveChatVideos;
    }

    public function addLiveChatVideo(LiveChatVideo $liveChatVideo): self
    {
        if (!$this->liveChatVideos->contains($liveChatVideo)) {
            $this->liveChatVideos[] = $liveChatVideo;
            $liveChatVideo->setSecteur($this);
        }

        return $this;
    }

    public function removeLiveChatVideo(LiveChatVideo $liveChatVideo): self
    {
        if ($this->liveChatVideos->removeElement($liveChatVideo)) {
            // set the owning side to null (unless already changed)
            if ($liveChatVideo->getSecteur() === $this) {
                $liveChatVideo->setSecteur(null);
            }
        }

        return $this;
    }

    public function getCoachs()
    {
       $coachs = [];
       $coachSecteurs = $this->coachSecteurs->toArray();
        /** @var CoachSecteur $coachSecteur */
        foreach($coachSecteurs as $coachSecteur) {
           $coachs[] = $coachSecteur->getCoach();
       }

        return $coachs;
    }

    public function getActive(): ?int
    {
        return !is_null($this->active) ? $this->active : 1;
    }

    public function setActive(?int $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setSecteur($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getSecteur() === $this) {
                $produit->setSecteur(null);
            }
        }

        return $this;
    }

    public function getType(): ?TypeSecteur
    {
        return $this->type;
    }

    public function setType(?TypeSecteur $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }

    public function getContratSecu(): ?ContratSecu
    {
        return $this->contratSecu;
    }

    public function setContratSecu(ContratSecu $contratSecu): self
    {
        // set the owning side of the relation if necessary
        if ($contratSecu->getSecteur() !== $this) {
            $contratSecu->setSecteur($this);
        }

        $this->contratSecu = $contratSecu;

        return $this;
    }

    public function getCouverture(): ?string
    {
        return $this->couverture;
    }

    public function setCouverture(?string $couverture): static
    {
        $this->couverture = $couverture;

        return $this;
    }

    public function getLiens(): ?string
    {
        return $this->liens;
    }

    public function setLiens(?string $liens): static
    {
        $this->liens = $liens;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getVideoInfo(): ?string
    {
        return $this->videoInfo;
    }

    public function setVideoInfo(?string $videoInfo): static
    {
        $this->videoInfo = $videoInfo;

        return $this;
    }

    
}
