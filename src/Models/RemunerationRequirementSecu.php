<?php
namespace App\Model;

class RemunerationRequirementSecu
{

    private $rang;

    private $nomStatut;

    private $partenaireActif;

    private $caEquipeMensuel;

    private $remunerationEquipe = [];

    private $bonusPalier;


    public function __construct(
        int $rang,
        string $nomStatut,
        int $partenaireActif,
        int $caEquipeMensuel,
        array $remunerationEquipe,
        int $bonusPalier,
    ) {
        $this->rang = $rang;
        $this->nomStatut = $nomStatut;
        $this->partenaireActif = $partenaireActif;
        $this->caEquipeMensuel = $caEquipeMensuel;
        $this->remunerationEquipe = $remunerationEquipe;
        $this->bonusPalier = $bonusPalier;
    }




    /**
     * Get the value of partenaireActif
     */
    public function getPartenaireActif()
    {
        return $this->partenaireActif;
    }

    /**
     * Set the value of partenaireActif
     */
    public function setPartenaireActif($partenaireActif): self
    {
        $this->partenaireActif = $partenaireActif;

        return $this;
    }


    /**
     * Get the value of remunerationEquipe
     */
    public function getRemunerationEquipe()
    {
        return $this->remunerationEquipe;
    }

    /**
     * Set the value of remunerationEquipe
     */
    public function setRemunerationEquipe($remunerationEquipe): self
    {
        $this->remunerationEquipe = $remunerationEquipe;

        return $this;
    }



    /**
     * Get the value of bonusPalier
     */
    public function getBonusPalier()
    {
        return $this->bonusPalier;
    }

    /**
     * Set the value of bonusPalier
     */
    public function setBonusPalier($bonusPalier): self
    {
        $this->bonusPalier = $bonusPalier;

        return $this;
    }

    /**
     * Get the value of rang
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set the value of rang
     */
    public function setRang($rang): self
    {
        $this->rang = $rang;

        return $this;
    }

    /**
     * Get the value of nomStatut
     */
    public function getNomStatut()
    {
        return $this->nomStatut;
    }

    /**
     * Set the value of nomStatut
     */
    public function setNomStatut($nomStatut): self
    {
        $this->nomStatut = $nomStatut;

        return $this;
    }

    /**
     * Get the value of caEquipeMensuel
     */
    public function getCaEquipeMensuel()
    {
        return $this->caEquipeMensuel;
    }

    /**
     * Set the value of caEquipeMensuel
     */
    public function setCaEquipeMensuel($caEquipeMensuel): self
    {
        $this->caEquipeMensuel = $caEquipeMensuel;

        return $this;
    }
}