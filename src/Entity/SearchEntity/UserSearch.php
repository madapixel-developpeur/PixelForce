<?php
namespace App\Entity\SearchEntity;

use App\Entity\Secteur;
use DateTime;

class UserSearch {

    /**
     * @var string|null
     */
    private $prenom;
    
    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $telephone;

    /**
     * @var string|null
     */
    private $secteur;

    /**
     * @var string|null|DateTime
     */
    private $dateInscriptionMin;

    /**
     * @var string|null|DateTime
     */
    private $dateInscriptionMax;

    /**
     * @var string|null
     */
    private $adresse;

    private $active = 1;

    private $tag;

      /**
     * @var integer|1
     */
    private $type;

    /**
     * Get the value of prenom
     *
     * @return  string|null
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @param  string|null  $prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return  string|null
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string|null  $email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of telephone
     *
     * @return  string|null
     */ 
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @param  string|null  $telephone
     *
     * @return  self
     */ 
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get the value of secteur
     *
     * @return  Secteur|null
     */ 
    public function getSecteur()
    {
        return $this->secteur;
    }

    /**
     * Set the value of secteur
     *
     * @param  string|null  $secteur
     *
     * @return  self
     */ 
    public function setSecteur($secteur)
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * Get the value of dateInscriptionMin
     *
     * @return  string|null|DateTime
     */ 
    public function getDateInscriptionMin()
    {
        return $this->dateInscriptionMin;
    }

    /**
     * Set the value of dateInscriptionMin
     *
     * @param  string|null|DateTime  $dateInscriptionMin
     *
     * @return  self
     */ 
    public function setDateInscriptionMin($dateInscriptionMin)
    {
        $this->dateInscriptionMin = $dateInscriptionMin;

        return $this;
    }

    /**
     * Get the value of dateInscriptionMax
     *
     * @return  string|null|DateTime
     */ 
    public function getDateInscriptionMax()
    {
        return $this->dateInscriptionMax;
    }

    /**
     * Set the value of dateInscriptionMax
     *
     * @param  string|null|DateTime  $dateInscriptionMax
     *
     * @return  self
     */ 
    public function setDateInscriptionMax($dateInscriptionMax)
    {
        $this->dateInscriptionMax = $dateInscriptionMax;

        return $this;
    }

    /**
     * Get the value of adresse
     *
     * @return  string|null
     */ 
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @param  string|null  $adresse
     *
     * @return  self
     */ 
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     * @return UserSearch
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     * @return UserSearch
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }





    /**
     * Get the value of type
     *
     * @return  integer|1
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param  integer|1  $type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
