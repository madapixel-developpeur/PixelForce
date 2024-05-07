<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\CommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $textes;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentaires")
     */
    private $user;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="App\Entity\Commentaire")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="App\Entity\Commentaire")
     * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @ORM\ManyToOne(targetEntity=VideoFormation::class, inversedBy="commentaires")
     */
    private $VideoFormation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextes(): ?string
    {
        return $this->textes;
    }

    public function setTextes(string $textes): self
    {
        $this->textes = $textes;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Commentaire
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Commentaire $parent_id
     * @return Commentaire
     */
    public function setParent(?Commentaire $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * @param mixed $lvl
     * @return Commentaire
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * @param mixed $lft
     * @return Commentaire
     */
    public function setLft($lft)
    {
        $this->lft = $lft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * @param mixed $rgt
     * @return Commentaire
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;
        return $this;
    }

    /**
     * @return Commentaire
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param Commentaire $root
     * @return Commentaire
     */
    public function setRoot(Commentaire $root)
    {
        $this->root = $root;
        return $this;
    }

    public function getVideoFormation(): ?VideoFormation
    {
        return $this->VideoFormation;
    }

    public function setVideoFormation(?VideoFormation $VideoFormation): self
    {
        $this->VideoFormation = $VideoFormation;

        return $this;
    }


}
