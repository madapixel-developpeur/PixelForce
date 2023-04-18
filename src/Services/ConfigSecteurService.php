<?php


namespace App\Services;

use App\Entity\Secteur;
use App\Repository\ConfigSecteurRepository;

class ConfigSecteurService
{
    const CONFIG_NUM_TVA = 1;
    const CONFIG_NUM_FRAIS_LIVRAISON = 2;
    const CONFIG_NUM_PRIX_MIN_FRAIS_LIVRAISON_GRATUIT = 3;
    protected $configSecteurRepository;

    public function __construct(ConfigSecteurRepository $configSecteurRepository)
    {
        $this->configSecteurRepository = $configSecteurRepository;
    }

    public function findTva(?Secteur $secteur = null){
        $config = $this->configSecteurRepository->findConfigByNum(ConfigSecteurService::CONFIG_NUM_TVA, $secteur);
        return $config ? ($config->getVal() ? $config->getVal() : 0) : 0;
    }

    public function findFraisLivraison(Secteur $secteur = null){
        $config = $this->configSecteurRepository->findConfigByNum(self::CONFIG_NUM_FRAIS_LIVRAISON, $secteur);
        return $config ? ($config->getVal() ?? 0) : 0;
    }

    public function findPrixMinFraisLivraisonGratuit(Secteur $secteur = null){
        $config = $this->configSecteurRepository->findConfigByNum(self::CONFIG_NUM_PRIX_MIN_FRAIS_LIVRAISON_GRATUIT, $secteur);
        return $config ? ($config->getVal() ?? 0) : 0;
    }

    public function calculerFraisDeLivraison($totalPanier, Secteur $secteur = null){
        $totalPanier = floatval($totalPanier);
        $prixMinFraisLivraisonGratuit = $this->findPrixMinFraisLivraisonGratuit($secteur);
        $fraisLivraison = 0;
        if($totalPanier > 0 && ($totalPanier < $prixMinFraisLivraisonGratuit || $prixMinFraisLivraisonGratuit < 0)){
            $fraisLivraison = $this->findFraisLivraison($secteur);
        }
        return $fraisLivraison;
    }
}