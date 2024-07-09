<?php

namespace App\Entity\SearchEntity;

class CategorieFormationSearch {
    
    /**
     * @var string|null
     */
    private $nom;
  
    /**
     * @var string|null
     */
    private $description;

    /**
     * @var int|null
     */
    private $ordre;

    /**
     * @var int|null
     */
    private $statut;


       /**
     * @var boolean|null
     */
    private $isInProgression;

    /**
     * Get the value of nom
     *
     * @return  string|null
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @param  string|null  $nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of description
     *
     * @return  string|null
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string|null  $description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of ordre
     *
     * @return  int|null
     */ 
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set the value of ordre
     *
     * @param  int|null  $ordre
     *
     * @return  self
     */ 
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get the value of statut
     *
     * @return  int|null
     */ 
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set the value of statut
     *
     * @param  int|null  $statut
     *
     * @return  self
     */ 
    public function setStatut($statut)
    {
        $this->statut = $statut;

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
}