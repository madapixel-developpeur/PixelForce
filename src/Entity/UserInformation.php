<?php

namespace App\Entity;

use App\Util\Search\Constants;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserInformationRepository;

/**
 * @ORM\Entity(repositoryClass=UserInformationRepository::class)
 */
class UserInformation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
    */
    private ?int $id = null;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="information",cascade={"persist", "remove"})
     */
    private $user;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $portfolioLink;

         /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $portfolioFile;

    /**
     * @ORM\Column(type="text", nullable=true)
    */
    private $competence;

    
    /**
     * @ORM\Column(type="text", nullable=true)
    */
    private $langues;

    /**
     * @ORM\Column(type="text", nullable=true)
    */
    private $competenceTechnique;

    /**
     * @ORM\Column(type="datetime", nullable=true)
    */
    private $validationDate;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     */
    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of portfolioLink
     */
    public function getPortfolioLink()
    {
        return $this->portfolioLink;
    }

    /**
     * Set the value of portfolioLink
     */
    public function setPortfolioLink($portfolioLink): self
    {
        $this->portfolioLink = $portfolioLink;

        return $this;
    }

    /**
     * Get the value of portfolioFile
     */
    public function getPortfolioFile()
    {
        return $this->portfolioFile;
    }

    /**
     * Set the value of portfolioFile
     */
    public function setPortfolioFile($portfolioFile): self
    {
        $this->portfolioFile = $portfolioFile;

        return $this;
    }

    /**
     * Get the value of competence
     */
    public function getCompetence()
    {
        return $this->competence;
    }

    /**
     * Set the value of competence
     */
    public function setCompetence($competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get the value of langues
     */
    public function getLangues()
    {
        return $this->langues;
    }

    /**
     * Set the value of langues
     */
    public function setLangues($langues): self
    {
        $this->langues = $langues;

        return $this;
    }

    /**
     * Get the value of competenceTechnique
     */
    public function getCompetenceTechnique()
    {
        return $this->competenceTechnique;
    }

    /**
     * Set the value of competenceTechnique
     */
    public function setCompetenceTechnique($competenceTechnique): self
    {
        $this->competenceTechnique = $competenceTechnique;

        return $this;
    }

    /**
     * Get the value of validationDate
     */
    public function getValidationDate()
    {
        return $this->validationDate;
    }

    /**
     * Set the value of validationDate
     */
    public function setValidationDate($validationDate): self
    {
        $this->validationDate = $validationDate;

        return $this;
    }

    public function getPortfolioFileName(){
        return str_replace(Constants::PORTFOLIO_FOLDER.'/','',$this->getPortfolioFile());
    }
}
