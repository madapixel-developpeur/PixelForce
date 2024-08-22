<?php

namespace App\Entity;

use App\Repository\CallScriptRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CallScriptRepository::class)
 */
class CallScript
{
   /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
    */
    private $content;

     /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contact")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;


      /**
     * @ORM\ManyToOne(targetEntity=Secteur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $secteur;



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

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
     * Get the value of author
     */ 
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */ 
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get the value of secteur
     */ 
    public function getSecteur()
    {
        return $this->secteur;
    }

    /**
     * Set the value of secteur
     *
     * @return  self
     */ 
    public function setSecteur($secteur)
    {
        $this->secteur = $secteur;

        return $this;
    }
}
