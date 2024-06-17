<?php

namespace App\Entity;

use App\Repository\NewsLettersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsLettersRepository::class)
 */
class NewsLetters
{
    const CREATED = 0;
    const PROCCESSING = 1;
    const SENT = 2;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;
    
     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $objet;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $content;

     /**
     * @ORM\Column(type="datetime", nullable=true)
    */
    private $createdAt;

      /**
     * @ORM\Column(type="integer", options={"default": 0 })
     */
    private $state = 0;

       /**
     * @ORM\OneToMany(targetEntity=PiecesJointesNewsLetters::class, mappedBy="newsLetters", orphanRemoval=true)
     */
    private $piecesJointes;




    public function getId(): ?int
    {
        return $this->id;
    }

      /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    
      /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }


    
      /**
     * Get the value of titre
     */ 
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @return  self
     */ 
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }


       /**
     * Get the value of objet
     */ 
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * Set the value of objet
     *
     * @return  self
     */ 
    public function setObjet($objet)
    {
        $this->objet = $objet;

        return $this;
    }


        /**
     * Get the value of state
     */ 
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @return  self
     */ 
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }


          /**
     * Get the value of piecesJointes
     */ 
    public function getPiecesJointes()
    {
        return $this->piecesJointes;
    }

    /**
     * Set the value of piecesJointes
     *
     * @return  self
     */ 
    public function setPiecesJointes($piecesJointes)
    {
        $this->piecesJointes = $piecesJointes;

        return $this;
    }

    
}
