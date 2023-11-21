<?php


namespace App\Services;

use App\Repository\ConfigRepository;

class ConfigService
{
    const CONFIG_NUM_TVA = 1;
    const CONFIG_NUM_FRAIS_LIVRAISON = 2;
    const CONFIG_NUM_PRIX_MIN_FRAIS_LIVRAISON_GRATUIT = 3;
    protected $configRepository;

    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function findTva(){
        $config = $this->configRepository->findConfigByNum(self::CONFIG_NUM_TVA);
        return $config ? ($config->getVal() ?? 0) : 0;
    }

    public function findFraisLivraison(){
        $config = $this->configRepository->findConfigByNum(self::CONFIG_NUM_FRAIS_LIVRAISON);
        return $config ? ($config->getVal() ?? 0) : 0;
    }

    public function findPrixMinFraisLivraisonGratuit(){
        $config = $this->configRepository->findConfigByNum(self::CONFIG_NUM_PRIX_MIN_FRAIS_LIVRAISON_GRATUIT);
        return $config ? ($config->getVal() ?? 0) : 0;
    }

    public function calculerFraisDeLivraison($totalPanier){
        $totalPanier = floatval($totalPanier);
        $prixMinFraisLivraisonGratuit = $this->findPrixMinFraisLivraisonGratuit();
        $fraisLivraison = 0;
        $totalPanier = 12.0;
        if($totalPanier > 0 && $totalPanier < $prixMinFraisLivraisonGratuit){
            
            $fraisLivraison = $this->findFraisLivraison();
        }
        return $fraisLivraison;
    }
}