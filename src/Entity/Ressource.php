<?php

namespace App\Entity;

use App\Repository\RessourceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RessourceRepository::class)
 */
class Ressource
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $files;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $secteur;
    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $links;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSecteur(): ?Secteur
    {
        return $this->secteur;
    }

    public function setSecteur(?Secteur $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getFiles(): array
    {
        return $this->files ?? [];
    }

    public function setFiles(array $files): self
    {
        $this->files = $files;

        return $this;
    }

    public function getLinks(): array
    {
        return $this->links ?? [];
    }

    public function setLinks(array $links): self
    {
        $this->links = $links;

        return $this;
    }

    public function getFilesParsed(): array
    {
        $files = $this->getFiles();
        $filesParsed = [];
        foreach ($files as $file) {
            $name = basename($file['path']);
            $filesParsed[] = [
                'path' => $file['path'],
                'name' => $name,
                'customName' => $file['customName'] ?? $name,
            ];
        }
        return $filesParsed;
    }
}
