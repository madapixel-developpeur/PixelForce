<?php
namespace App\Entity\SearchEntity;

use App\Entity\Secteur;
use DateTime;

class OrderSearch {
    /**
     * @var string|null
     */
    private $secteur;

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
}
