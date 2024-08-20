<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Services\StripeService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use JsonSerializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity("username", message="Nom d'utilisateur déjà utilisé")
 * @UniqueEntity("email", message="Adresse email déjà utilisé")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface, JsonSerializable
{

    const ROLE_AGENT = 'ROLE_AGENT';
    const ROLE_MADA = 'ROLE_MADA';
    const ROLE_COACH = 'ROLE_COACH';
    const ROLE_AMBASSADEUR = 'ROLE_AMBASSADEUR';
    const ROLE_ADMINISTRATEUR = 'ROLE_ADMINISTRATEUR';
    const ROLE_CLIENT = 'ROLE_CLIENT';
    const ROLE_DOCUMENT_OWNER = 'ROLE_DOCUMENT_OWNER';
    const ROLES = [
        self::ROLE_AGENT => self::ROLE_AGENT,
        self::ROLE_MADA => self::ROLE_MADA,
        self::ROLE_COACH => self::ROLE_AGENT,
        self::ROLE_ADMINISTRATEUR => self::ROLE_ADMINISTRATEUR,
        self::ROLE_CLIENT => self::ROLE_CLIENT,
        self::ROLE_DOCUMENT_OWNER => self::ROLE_DOCUMENT_OWNER,
        self::ROLE_AMBASSADEUR => self::ROLE_AMBASSADEUR,
    ];

    const INACTIVE_STATE = -1 ;
    const HAVENT_SEEN_SECTOR_VIDEO = 0;
    const HAVE_SEEN_SECTOR_VIDEO = 1;

    /**
     *  Clés disponibles :
     *  - UNPAID : l'user n'a pas encore procédé au paiement
     *  - TRIAL : Statut éssaie (14 jours) 
     *  - ACTIVE : Statut après 2ème paiement (Qui n'est plus TRIAL)
     * 
     *  - EXPIRED : "Qui nous sert seulement de teste ! " - Statut lorsque le compte a dépassé un tel délai (14jrs ou autres...)
     */
    const ACCOUNT_STATUS = [
        'UNPAID' => 'Impaye',
        'TRIAL' => 'Essai',
        'ACTIVE' => 'Actif',
        'EXPIRED' => 'Expiré'
    ];

    const ACCOUNT_PRICE_TRIAL = 1.0;
    const ACCOUNT_PRICE_INTEGRAL = 20.0;
    const ACCOUNT_PRICE_ONE_SECTOR = 97.0;
    const ACCOUNT_PRICE_MANY_SECTOR = 297.0;

    /**
     *  Clés disponibles :
     *  - TRIAL 
     *  - INTEGRAL
     *  - ONE_SECTOR
     *  - MANY_SECTOR
     */
    const ACCOUNT_PRICE = [
        'TRIAL' => self::ACCOUNT_PRICE_TRIAL,
        'INTEGRAL' => self::ACCOUNT_PRICE_INTEGRAL,
        'ONE_SECTOR' => self::ACCOUNT_PRICE_ONE_SECTOR,
        'MANY_SECTOR' => self::ACCOUNT_PRICE_MANY_SECTOR
    ];

    const EXPIRY_DATE = 14;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"chat"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"chat"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="parrain_id", referencedColumnName="id", nullable=true)
     */
    private $parrain;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="parrain")
     */
    private $fils;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"chat"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"chat"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroSecurite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rib;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sixDigitCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $forgottenPassToken;

    /**
     * @ORM\OneToMany(targetEntity=CoachAgent::class, mappedBy="coach")
     */
    private $coachAgents;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=LiveChatVideo::class, mappedBy="userA")
     */
    private $liveChatVideosFromUserA;
    /**
     * @ORM\OneToMany(targetEntity=LiveChatVideo::class, mappedBy="userB")
     */
    private $liveChatVideosFromUserB;

    /**
     * @ORM\OneToMany(targetEntity=VideoFormation::class, mappedBy="user")
     */
    private $videoFormations;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="user")
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="user")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=CanalMessage::class, mappedBy="users")
     */
    private $canalMessages;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ApiToken;
    /**
     * @Groups({"chat"})
     */
    private $chatCode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="agent", orphanRemoval=true)
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity=Contact::class, inversedBy="client")
     */
    private $contact_client;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="coach")
     */
    private $formations;

    /**
     * @ORM\OneToMany(targetEntity=FormationAgent::class, mappedBy="agent")
     */
    private $formationAgents;

    /**
     * @ORM\OneToMany(targetEntity=CoachSecteur::class, mappedBy="coach")
     */
    private $coachSecteurs;

    /**
     * @ORM\OneToMany(targetEntity=AgentSecteur::class, mappedBy="agent", fetch="EAGER", cascade={"persist"})
     */
    private $agentSecteurs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lienCalendly;

    /**
     * @ORM\OneToMany(targetEntity="CalendarEvent", mappedBy="user")
     */
    private $calendarEvents;

    /**
     * @ORM\OneToMany(targetEntity=CategorieFormationAgent::class, mappedBy="agent", orphanRemoval=true)
     */
    private $categorieFormationAgents;

    /**
     * @ORM\OneToMany(targetEntity="Meeting", mappedBy="user")
     */
    private $meetings;

    /**
     * @ORM\OneToMany(targetEntity="Meeting", mappedBy="userToMeet")
     */
    private $meetingGuests;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $clientAgent;

    private $plainPassword;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $stripe_data = [];

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $accountStatus;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $accountStartDate;

    /**
     * @ORM\OneToMany(targetEntity=SubscriptionPlanAgentAccount::class, mappedBy="user")
     */
    private $subscriptionPlanAgentAccounts;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $stripeCustomerId;

    /**
     * @ORM\OneToMany(targetEntity=OrderDigital::class, mappedBy="agent")
     */
    private $orderDigitals;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numero_rue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pays;

    /*
     * @ORM\OneToMany(targetEntity=DevisCompany::class, mappedBy="agent")
     */
    private $devisCompanies;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ambassadorUsername;

    private $accessibleFonctionnalites = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

     /**
     * @ORM\Column(type="integer", nullable=true ,options={"default"=0})
     */
    private $haveSeenSectorVideo = self::HAVENT_SEEN_SECTOR_VIDEO;


    
     /**
     * @ORM\Column(type="integer", nullable=true ,options={"default"=0})
     */
    private $finishedOneVideoFormation = true;

    public function __construct()
    {
        $this->coachAgents = new ArrayCollection();
        $this->liveChatVideosFromUserA = new ArrayCollection();
        $this->liveChatVideosFromUserB = new ArrayCollection();
        $this->videoFormations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->canalMessages = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->contact = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->formationAgents = new ArrayCollection();
        $this->coachSecteurs = new ArrayCollection();
        $this->agentSecteurs = new ArrayCollection();
        $this->calendarEvents = new ArrayCollection();
        $this->categorieFormationAgents = new ArrayCollection();
        $this->meetings = new ArrayCollection();
        $this->meetingGuests = new ArrayCollection();
        $this->subscriptionPlanAgentAccounts = new ArrayCollection();
        $this->orderDigitals = new ArrayCollection();
        $this->devisCompanies = new ArrayCollection();
        $this->fils = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccessibleFonctionnalites($secteurId): ?array
    {
        $key = ''. $secteurId;
        return isset($this->accessibleFonctionnalites[$key]) && $this->accessibleFonctionnalites[$key] ? $this->accessibleFonctionnalites[$key] : null;
    }

    public function setAccessibleFonctionnalites($secteurId, array $accessibleFonctionnalitesSecteur): self
    {
        $key = ''. $secteurId;
        $this->accessibleFonctionnalites[$key] = $accessibleFonctionnalitesSecteur;

        return $this;
    }
    
    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAmbassadorUsername(): ?string
    {
        return $this->ambassadorUsername;
    }

    public function setAmbassadorUsername(string $ambassadorUsername): self
    {
        $this->ambassadorUsername = $ambassadorUsername;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //        $roles[] = self::ROLE_AGENT;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getStringRole()
    {
        switch ($this->roles[0]) {
            case self::ROLE_AGENT:
                return 'Agent';
                break;
            case self::ROLE_COACH:
                return 'Coach';
                break;
            case self::ROLE_ADMINISTRATEUR:
                return 'Administrateur';
                break;
            case self::ROLE_CLIENT:
                return 'Client';
                break;
            case self::ROLE_DOCUMENT_OWNER:
                return 'Propriétaire de document';
                break;
        }
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNumeroSecurite(): ?string
    {
        return $this->numeroSecurite;
    }

    public function setNumeroSecurite(?string $numeroSecurite): self
    {
        $this->numeroSecurite = $numeroSecurite;

        return $this;
    }

    public function getRib(): ?string
    {
        return $this->rib;
    }

    public function setRib(?string $rib): self
    {
        $this->rib = $rib;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo = null, $setNull = false): self
    {
        $this->photo = $photo ? $photo : $this->photo;
        if ($setNull) {
            $this->photo = null;
        }

        return $this;
    }

    public function getSixDigitCode(): ?int
    {
        return $this->sixDigitCode;
    }

    public function setSixDigitCode(?int $sixDigitCode): self
    {
        $this->sixDigitCode = $sixDigitCode;

        return $this;
    }

    public function getForgottenPassToken(): ?string
    {
        return $this->forgottenPassToken;
    }

    public function setForgottenPassToken(?string $forgottenPassToken): self
    {
        $this->forgottenPassToken = $forgottenPassToken;

        return $this;
    }

    public function validateSixDigitCode($sixDigitCode): bool
    {
        if ($this->sixDigitCode === (int) $sixDigitCode) {
            return true;
        }
        return false;
    }

    public function validateForgottenPassToken($forgotten_pass)
    {
        if ($this->forgottenPassToken ===  $forgotten_pass) {
            return true;
        }
        return false;
    }

    /**
     * @return Collection<int, CoachAgent>
     */
    public function getCoachAgents(): Collection
    {
        return $this->coachAgents;
    }

    public function addCoachAgent(CoachAgent $coachAgent): self
    {
        if (!$this->coachAgents->contains($coachAgent)) {
            $this->coachAgents[] = $coachAgent;
            $coachAgent->setCoach($this);
        }

        return $this;
    }

    public function removeCoachAgent(CoachAgent $coachAgent): self
    {
        if ($this->coachAgents->removeElement($coachAgent)) {
            // set the owning side to null (unless already changed)
            if ($coachAgent->getCoach() === $this) {
                $coachAgent->setCoach(null);
            }
        }

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(?int $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, LiveChatVideo>
     */
    public function getLiveChatVideosFromA(): Collection
    {
        return $this->liveChatVideosFromUserA;
    }

    public function addLiveChatVideoFromA(LiveChatVideo $liveChatVideo): self
    {
        if (!$this->liveChatVideosFromUserA->contains($liveChatVideo)) {
            $this->liveChatVideosFromUserA[] = $liveChatVideo;
            $liveChatVideo->setUserA($this);
        }

        return $this;
    }

    public function removeLiveChatVideoFromA(LiveChatVideo $liveChatVideo): self
    {
        if ($this->liveChatVideosFromUserA->removeElement($liveChatVideo)) {
            // set the owning side to null (unless already changed)
            if ($liveChatVideo->getUserA() === $this) {
                $liveChatVideo->setUserA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LiveChatVideo>
     */
    public function getLiveChatVideosFromB(): Collection
    {
        return $this->liveChatVideosFromUserB;
    }

    public function addLiveChatVideoFromB(LiveChatVideo $liveChatVideo): self
    {
        if (!$this->liveChatVideosFromUserB->contains($liveChatVideo)) {
            $this->liveChatVideosFromUserB[] = $liveChatVideo;
            $liveChatVideo->setUserB($this);
        }

        return $this;
    }

    public function removeLiveChatVideoFromB(LiveChatVideo $liveChatVideo): self
    {
        if ($this->liveChatVideosFromUserB->removeElement($liveChatVideo)) {
            // set the owning side to null (unless already changed)
            if ($liveChatVideo->getUserB() === $this) {
                $liveChatVideo->setUserB(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, VideoFormation>
     */
    public function getVideoFormations(): Collection
    {
        return $this->videoFormations;
    }

    public function addVideoFormation(VideoFormation $videoFormation): self
    {
        if (!$this->videoFormations->contains($videoFormation)) {
            $this->videoFormations[] = $videoFormation;
            $videoFormation->setUser($this);
        }

        return $this;
    }

    public function removeVideoFormation(VideoFormation $videoFormation): self
    {
        if ($this->videoFormations->removeElement($videoFormation)) {
            // set the owning side to null (unless already changed)
            if ($videoFormation->getUser() === $this) {
                $videoFormation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }

    public function clearMessages()
    {
        $this->messages->clear();
    }

    /**
     * @return Collection<int, CanalMessage>
     */
    public function getCanalMessages(): Collection
    {
        return $this->canalMessages;
    }

    public function addCanalMessage(CanalMessage $canalMessage): self
    {
        if (!$this->canalMessages->contains($canalMessage)) {
            $this->canalMessages[] = $canalMessage;
            $canalMessage->addUser($this);
        }

        return $this;
    }

    public function removeCanalMessage(CanalMessage $canalMessage): self
    {
        if ($this->canalMessages->removeElement($canalMessage)) {
            $canalMessage->removeUser($this);
        }

        return $this;
    }

    public function clearCanalMessages()
    {
        $this->canalMessages->clear();
    }

    public function getApiToken(): ?string
    {
        return $this->ApiToken;
    }

    public function setApiToken(?string $ApiToken): self
    {
        $this->ApiToken = $ApiToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChatCode()
    {
        return $this->chatCode ? $this->chatCode : $this->id;
    }

    /**
     * @param mixed $chatCode
     * @return User
     */
    public function setChatCode($chatCode)
    {
        $this->chatCode = $chatCode;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function fullName()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact[] = $contact;
            $contact->setAgent($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contact->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getAgent() === $this) {
                $contact->setAgent(null);
            }
        }

        return $this;
    }

    public function getContactClient(): ?Contact
    {
        return $this->contact_client;
    }

    public function setContactClient(?Contact $contact_client): self
    {
        $this->contact_client = $contact_client;

        return $this;
    }

    public function removeAllAgentSecteur()
    {
        $this->agentSecteurs->clear();
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
            $formation->setCoach($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getCoach() === $this) {
                $formation->setCoach(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FormationAgent>
     */
    public function getFormationAgents(): Collection
    {
        return $this->formationAgents;
    }

    public function addFormationAgent(FormationAgent $formationAgent): self
    {
        if (!$this->formationAgents->contains($formationAgent)) {
            $this->formationAgents[] = $formationAgent;
            $formationAgent->setAgent($this);
        }

        return $this;
    }

    public function removeFormationAgent(FormationAgent $formationAgent): self
    {
        if ($this->formationAgents->removeElement($formationAgent)) {
            // set the owning side to null (unless already changed)
            if ($formationAgent->getAgent() === $this) {
                $formationAgent->setAgent(null);
            }
        }

        return $this;
    }

    // public function getFormationStatut(Formation $formation)
    // {
    //    $formationAgents =  $formation->getFormationAgents();
    //    foreach($formationAgents->toArray() as $formationAgent) {
    //        if($formationAgent->getAgent()->getId() === $this->getId()) {
    //            return $formationAgent->getStatut();
    //        }
    //    }
    //    return '';
    // }
    public function getFormationStatut(Formation $formation)
    {
        $formationAgents =  $formation->getFormationAgents();
        foreach ($formationAgents->toArray() as $formationAgent) {
            if ($formationAgent->getAgent()->getId() === $this->getId()) {
                return $formationAgent->getStatut();
            }
        }
        return Formation::STATUT_DISPONIBLE;
    }

    /**
     * Permet de renvoyer un string contenant les secteurs d'un agent en les cocaténant par une virgule
     *
     * @param array $secteurs
     * @return string
     */
    public function allSecteursOfUser(array $agentSecteurs)
    {
        $mySecteurs = [];
        /** @var AgentSecteur $secteur */
        foreach ($agentSecteurs as $agentSecteur) {
            $mySecteurs[] = $agentSecteur->getSecteur()->getNom();
        }

        $joinSecteur = join(', ', $mySecteurs);
        return $joinSecteur;
    }

    public function pricePlanAccountBySecteurChoice(array $agentSecteurs)
    {
        $nbrSector = count($agentSecteurs);
        if ($nbrSector <= 1) {
            $price = self::ACCOUNT_PRICE_ONE_SECTOR;
        } else {
            $price = self::ACCOUNT_PRICE_MANY_SECTOR;
        }

        return $price;
    }

    public function typePlanAccountBySecteurChoice(array $agentSecteurs)
    {
        $nbrSector = count($agentSecteurs);
        if ($nbrSector <= 1) {
            $type = StripeService::ACCOUNT_SUBSCRIPTION_TYPE['ONE_SECTOR'];
        } else {
            $type = StripeService::ACCOUNT_SUBSCRIPTION_TYPE['MANY_SECTOR'];
        }

        return $type;
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
            $coachSecteur->setCoach($this);
        }
        return $this;
    }

    public function removeCoachSecteur(CoachSecteur $coachSecteur): self
    {
        if ($this->coachSecteurs->removeElement($coachSecteur)) {
            // set the owning side to null (unless already changed)
            if ($coachSecteur->getCoach() === $this) {
                $coachSecteur->setCoach(null);
            }
        }

        return $this;
    }

    public function getSecteurByCoach()
    {
        if (in_array(self::ROLE_COACH, $this->roles) && $this->coachSecteurs->count() > 0) {
            return $this->coachSecteurs->toArray()[0]->getSecteur();
        }
        return null;
    }

    public function getSecteursIdsByAgent()
    {
        $agentSecteurs = $this->getAgentSecteurs();
        $secteurs_ids = [];
        foreach ($agentSecteurs->toArray() as $agentSecteur) {
            $secteurs_ids[] = $agentSecteur->getSecteur()->getId();
        }
        return $secteurs_ids;
    }

    public function getSecteursByAgent()
    {
        $agentSecteurs = $this->getAgentSecteurs();
        $secteurs_ids = [];
        foreach ($agentSecteurs->toArray() as $agentSecteur) {
            $secteurs_ids[] = $agentSecteur->getSecteur();
        }
        return $secteurs_ids;
    }

    /**
     * @return Collection<int, AgentSecteur>
     */
    public function getAgentSecteurs(): Collection
    {
        if (in_array(self::ROLE_AGENT, $this->roles)) {
            return $this->agentSecteurs;
        }
        $this->agentSecteurs->clear();
        return $this->agentSecteurs;
    }

    public function addAgentSecteur(AgentSecteur $agentSecteur): self
    {
        if (!$this->agentSecteurs->contains($agentSecteur)) {
            $this->agentSecteurs[] = $agentSecteur;
            $agentSecteur->setAgent($this);
        }

        return $this;
    }

    public function removeAgentSecteur(AgentSecteur $agentSecteur): self
    {
        if ($this->agentSecteurs->removeElement($agentSecteur)) {
            // set the owning side to null (unless already changed)
            if ($agentSecteur->getAgent() === $this) {
                $agentSecteur->setAgent(null);
            }
        }

        return $this;
    }

    public function getLienCalendly(): ?string
    {
        return $this->lienCalendly;
    }

    public function setLienCalendly(?string $lienCalendly): self
    {
        $this->lienCalendly = $lienCalendly;

        return $this;
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
            $categorieFormationAgent->setAgent($this);
        }

        return $this;
    }

    public function removeCategorieFormationAgent(CategorieFormationAgent $categorieFormationAgent): self
    {
        if ($this->categorieFormationAgents->removeElement($categorieFormationAgent)) {
            // set the owning side to null (unless already changed)
            if ($categorieFormationAgent->getAgent() === $this) {
                $categorieFormationAgent->setAgent(null);
            }
        }

        return $this;
    }

    public function getUniqueCoachSecteur(): ?Secteur
    {
        if (count($this->getCoachSecteurs()) == 0) {
            throw new Exception("Pas de secteur");
        }
        return $this->getCoachSecteurs()[0]->getSecteur();
    }

    public function getAgentToken()
    {
        return sha1($this->getId());
    }

    public function getClientAgent(): ?self
    {
        return $this->clientAgent;
    }

    public function setClientAgent(?self $clientAgent): self
    {
        $this->clientAgent = $clientAgent;

        return $this;
    }

    /**
     * Get the value of plainPassword
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getStripeData(): ?array
    {
        return $this->stripe_data;
    }

    public function setStripeData(?array $stripe_data): self
    {
        $this->stripe_data = $stripe_data;

        return $this;
    }

    public function getAccountStatus(): ?string
    {
        return $this->accountStatus;
    }

    public function setAccountStatus(?string $accountStatus): self
    {
        $this->accountStatus = $accountStatus;

        return $this;
    }

    public function getAccountStartDate(): ?\DateTimeInterface
    {
        return $this->accountStartDate;
    }

    public function setAccountStartDate(?\DateTimeInterface $accountStartDate): self
    {
        $this->accountStartDate = $accountStartDate;

        return $this;
    }

    /**
     * @return Collection<int, SubscriptionPlanAgentAccount>
     */
    public function getSubscriptionPlanAgentAccounts(): Collection
    {
        return $this->subscriptionPlanAgentAccounts;
    }

    public function addSubscriptionPlanAgentAccount(SubscriptionPlanAgentAccount $subscriptionPlanAgentAccount): self
    {
        if (!$this->subscriptionPlanAgentAccounts->contains($subscriptionPlanAgentAccount)) {
            $this->subscriptionPlanAgentAccounts[] = $subscriptionPlanAgentAccount;
            $subscriptionPlanAgentAccount->setUser($this);
        }

        return $this;
    }

    public function removeSubscriptionPlanAgentAccount(SubscriptionPlanAgentAccount $subscriptionPlanAgentAccount): self
    {
        if ($this->subscriptionPlanAgentAccounts->removeElement($subscriptionPlanAgentAccount)) {
            // set the owning side to null (unless already changed)
            if ($subscriptionPlanAgentAccount->getUser() === $this) {
                $subscriptionPlanAgentAccount->setUser(null);
            }
        }

        return $this;
    }

    public function getStripeCustomerId(): ?string
    {
        return $this->stripeCustomerId;
    }

    public function setStripeCustomerId(?string $stripeCustomerId): self
    {
        $this->stripeCustomerId = $stripeCustomerId;

        return $this;
    }

    /**
     * @return Collection<int, OrderDigital>
     */
    public function getOrderDigitals(): Collection
    {
        return $this->orderDigitals;
    }

    public function addOrderDigital(OrderDigital $orderDigital): self
    {
        if (!$this->orderDigitals->contains($orderDigital)) {
            $this->orderDigitals[] = $orderDigital;
            $orderDigital->setAgent($this);
        }

        return $this;
    }

    public function removeOrderDigital(OrderDigital $orderDigital): self
    {
        if ($this->orderDigitals->removeElement($orderDigital)) {
            // set the owning side to null (unless already changed)
            if ($orderDigital->getAgent() === $this) {
                $orderDigital->setAgent(null);
            }
        }

        return $this;
    }

    public function getNumeroRue(): ?string
    {
        return $this->numero_rue;
    }

    public function setNumeroRue(?string $numero_rue): self
    {
        $this->numero_rue = $numero_rue;

        return $this;
    }

    /**
     * @return Collection<int, DevisCompany>
     */
    public function getDevisCompanies(): Collection
    {
        return $this->devisCompanies;
    }

    public function addDevisCompany(DevisCompany $devisCompany): self
    {
        if (!$this->devisCompanies->contains($devisCompany)) {
            $this->devisCompanies[] = $devisCompany;
            $devisCompany->setAgent($this);
        }

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

    public function removeDevisCompany(DevisCompany $devisCompany): self
    {
        if ($this->devisCompanies->removeElement($devisCompany)) {
            // set the owning side to null (unless already changed)
            if ($devisCompany->getAgent() === $this) {
                $devisCompany->setAgent(null);
            }
        }

        return $this;
    }

    public function getParrain(): ?self
    {
        return $this->parrain;
    }

    public function setParrain(?self $parrain): static
    {
        $this->parrain = $parrain;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFils(): Collection
    {
        return $this->fils;
    }

    public function addFil(User $fil): static
    {
        if (!$this->fils->contains($fil)) {
            $this->fils->add($fil);
            $fil->setParrain($this);
        }

        return $this;
    }

    public function removeFil(User $fil): static
    {
        if ($this->fils->removeElement($fil)) {
            // set the owning side to null (unless already changed)
            if ($fil->getParrain() === $this) {
                $fil->setParrain(null);
            }
        }

        return $this;
    }
    public function countFils()
    {
        return count($this->fils);
    }

    public function jsonSerialize()
    {
        /* $vars = get_object_vars($this);
        unset($vars['password']);
        unset($vars['roles']);
        unset($vars['coachAgents']);
        unset($vars['liveChatVideosFromUserA']);
        unset($vars['liveChatVideosFromUserB']);
        unset($vars['videoFormations']);
        unset($vars['commentaires']);
        unset($vars['messages']);
        unset($vars['canalMessages']);
        unset($vars['created_at']);
        unset($vars['contact']);
        unset($vars['formations']);
        unset($vars['formationAgents']);
        unset($vars['coachSecteurs']);
        unset($vars['agentSecteurs']);
        unset($vars['calendarEvents']);
        unset($vars['categorieFormationAgents']);
        unset($vars['meetings']);
        unset($vars['meetingGuests']);
        unset($vars['subscriptionPlanAgentAccounts']);
        unset($vars['orderDigitals']);
        unset($vars['devisCompanies']);*/

        $vars = [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'userIdentifer' => $this->getUserIdentifier(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'role' => $this->getRoles()
        ];
        return $vars;
    }

    /**
     * @return Collection<int, LiveChatVideo>
     */
    public function getLiveChatVideosFromUserA(): Collection
    {
        return $this->liveChatVideosFromUserA;
    }

    public function addLiveChatVideosFromUserA(LiveChatVideo $liveChatVideosFromUserA): static
    {
        if (!$this->liveChatVideosFromUserA->contains($liveChatVideosFromUserA)) {
            $this->liveChatVideosFromUserA->add($liveChatVideosFromUserA);
            $liveChatVideosFromUserA->setUserA($this);
        }

        return $this;
    }

    public function removeLiveChatVideosFromUserA(LiveChatVideo $liveChatVideosFromUserA): static
    {
        if ($this->liveChatVideosFromUserA->removeElement($liveChatVideosFromUserA)) {
            // set the owning side to null (unless already changed)
            if ($liveChatVideosFromUserA->getUserA() === $this) {
                $liveChatVideosFromUserA->setUserA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LiveChatVideo>
     */
    public function getLiveChatVideosFromUserB(): Collection
    {
        return $this->liveChatVideosFromUserB;
    }

    public function addLiveChatVideosFromUserB(LiveChatVideo $liveChatVideosFromUserB): static
    {
        if (!$this->liveChatVideosFromUserB->contains($liveChatVideosFromUserB)) {
            $this->liveChatVideosFromUserB->add($liveChatVideosFromUserB);
            $liveChatVideosFromUserB->setUserB($this);
        }

        return $this;
    }

    public function removeLiveChatVideosFromUserB(LiveChatVideo $liveChatVideosFromUserB): static
    {
        if ($this->liveChatVideosFromUserB->removeElement($liveChatVideosFromUserB)) {
            // set the owning side to null (unless already changed)
            if ($liveChatVideosFromUserB->getUserB() === $this) {
                $liveChatVideosFromUserB->setUserB(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CalendarEvent>
     */
    public function getCalendarEvents(): Collection
    {
        return $this->calendarEvents;
    }

    public function addCalendarEvent(CalendarEvent $calendarEvent): static
    {
        if (!$this->calendarEvents->contains($calendarEvent)) {
            $this->calendarEvents->add($calendarEvent);
            $calendarEvent->setUser($this);
        }

        return $this;
    }

    public function removeCalendarEvent(CalendarEvent $calendarEvent): static
    {
        if ($this->calendarEvents->removeElement($calendarEvent)) {
            // set the owning side to null (unless already changed)
            if ($calendarEvent->getUser() === $this) {
                $calendarEvent->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Meeting>
     */
    public function getMeetings(): Collection
    {
        return $this->meetings;
    }

    public function addMeeting(Meeting $meeting): static
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings->add($meeting);
            $meeting->setUser($this);
        }

        return $this;
    }

    public function removeMeeting(Meeting $meeting): static
    {
        if ($this->meetings->removeElement($meeting)) {
            // set the owning side to null (unless already changed)
            if ($meeting->getUser() === $this) {
                $meeting->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Meeting>
     */
    public function getMeetingGuests(): Collection
    {
        return $this->meetingGuests;
    }

    public function addMeetingGuest(Meeting $meetingGuest): static
    {
        if (!$this->meetingGuests->contains($meetingGuest)) {
            $this->meetingGuests->add($meetingGuest);
            $meetingGuest->setUserToMeet($this);
        }

        return $this;
    }

    public function removeMeetingGuest(Meeting $meetingGuest): static
    {
        if ($this->meetingGuests->removeElement($meetingGuest)) {
            // set the owning side to null (unless already changed)
            if ($meetingGuest->getUserToMeet() === $this) {
                $meetingGuest->setUserToMeet(null);
            }
        }

        return $this;
    }

    public function canAccessFonct(string $fonct, $secteurId): bool{
        return in_array($fonct, $this->getAccessibleFonctionnalites($secteurId) ?? [] );
    }


    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get the value of haveSeenSectorVideo
     */ 
    public function getHaveSeenSectorVideo()
    {
        return $this->haveSeenSectorVideo;
    }

    /**
     * Set the value of haveSeenSectorVideo
     *
     * @return  self
     */ 
    public function setHaveSeenSectorVideo($haveSeenSectorVideo)
    {
        $this->haveSeenSectorVideo = $haveSeenSectorVideo;

        return $this;
    }

    /**
     * Get the value of finishedOneVideoFormation
     */ 
    public function getFinishedOneVideoFormation()
    {
        return $this->finishedOneVideoFormation;
    }

    /**
     * Set the value of finishedOneVideoFormation
     *
     * @return  self
     */ 
    public function setFinishedOneVideoFormation($finishedOneVideoFormation)
    {
        $this->finishedOneVideoFormation = $finishedOneVideoFormation;

        return $this;
    }

    public function getRoleLabel() {

        if(in_array(self::ROLE_AGENT, $this->getRoles())){
             return 'Agent';
        } else if(in_array(self::ROLE_COACH, $this->getRoles())){
            return 'Coach';
        } else if(in_array(self::ROLE_ADMINISTRATEUR, $this->getRoles())){
            return 'Administrateur';
        } else if(in_array(self::ROLE_CLIENT, $this->getRoles())){
            return 'Client';
        } else if(in_array(self::ROLE_DOCUMENT_OWNER, $this->getRoles())){
            return 'Propriétaire de document';
        } else if(in_array(self::ROLE_AMBASSADEUR, $this->getRoles())){
            return 'Ambassadeur';
        } else if(in_array(self::ROLE_MADA, $this->getRoles())){
            return 'Mada';
        } 
        return '';
    }
}
