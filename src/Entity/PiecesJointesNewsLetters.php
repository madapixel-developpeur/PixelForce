<?php

namespace App\Entity;

use App\Repository\PiecesJointesNewsLettersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PiecesJointesNewsLettersRepository::class)
 */
class PiecesJointesNewsLetters
{
   /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=NewsLetters::class,inversedBy="piecesJointes")
     * @ORM\JoinColumn(nullable=false)
    */
    private $newsLetters;

    /**
        * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $filename;

    /**
        * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $filepath;



    public function getId(): ?int
    {
        return $this->id;
    }

      /**
     * Get the value of filepath
     */ 
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * Set the value of filepath
     *
     * @return  self
     */ 
    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;

        return $this;
    }

      /**
     * Get the value of newsLetters
     */ 
    public function getNewsLetters()
    {
        return $this->newsLetters;
    }

    /**
     * Set the value of newsLetters
     *
     * @return  self
     */ 
    public function setNewsLetters($newsLetters)
    {
        $this->newsLetters = $newsLetters;

        return $this;
    }

    /**
     * Get the value of filename
     */ 
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the value of filename
     *
     * @return  self
     */ 
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }
}
