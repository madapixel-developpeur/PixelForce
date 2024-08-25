<?php

namespace App\Entity;

use App\Repository\MeetingFilesRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=MeetingFilesRepository::class)
 */
class MeetingFiles
{
   /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

      /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filePath;

       /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fileName;

      /**
     * @ORM\ManyToOne(targetEntity=Meeting::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $meeting;

     /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contact")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of filePath
     */ 
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Set the value of filePath
     *
     * @return  self
     */ 
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * Get the value of fileName
     */ 
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set the value of fileName
     *
     * @return  self
     */ 
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get the value of meeting
     */ 
    public function getMeeting()
    {
        return $this->meeting;
    }

    /**
     * Set the value of meeting
     *
     * @return  self
     */ 
    public function setMeeting($meeting)
    {
        $this->meeting = $meeting;

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
}
