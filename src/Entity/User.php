<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity("email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    const ROLE_AGENT = 'ROLE_AGENT';
    const ROLE_MADA = 'ROLE_MADA';
    const ROLE_COACH = 'ROLE_COACH';
    const ROLE_ADMINISTRATEUR = 'ROLE_ADMINISTRATEUR';
    const ROLE_CLIENT = 'ROLE_CLIENT';
    const ROLES = [
      self::ROLE_AGENT => self::ROLE_AGENT,
      self::ROLE_MADA => self::ROLE_MADA,
      self::ROLE_COACH => self::ROLE_AGENT,
      self::ROLE_ADMINISTRATEUR => self::ROLE_ADMINISTRATEUR,
      self::ROLE_CLIENT => self::ROLE_CLIENT,
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

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
     * @Assert\NotNull(message="Vous devez entrer votre nom")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotNull(message="Vous devez entrer votre prénom")
     */
    private $prenom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\NotNull(message="Votre date de naissance est obligatoire")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotNull(message="Vous devez avoir une adresse")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotNull(message="Veuillez entrer votre Numéro de sécurité")
     */
    private $numeroSecurite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotNull(message="On a besoin de votre RIB")
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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    public function __construct()
    {
        $this->coachAgents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
//        $roles[] = self::ROLE_AGENT;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
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
        if($setNull) {
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

    public function validateSixDigitCode($sixDigitCode):bool
    {
        if($this->sixDigitCode === (int) $sixDigitCode) {
            return true;
        }
        return false;
    }

    public function validateForgottenPassToken($forgotten_pass)
    {
        if($this->forgottenPassToken ===  $forgotten_pass) {
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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
