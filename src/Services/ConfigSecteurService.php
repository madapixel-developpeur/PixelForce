<?php


namespace App\Services;

use App\Entity\Secteur;
use App\Repository\ConfigSecteurRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ConfigSecteurService
{
    const CONFIG_NUM_TVA = 1;
    const CONFIG_NUM_FRAIS_LIVRAISON = 2;
    const CONFIG_NUM_PRIX_MIN_FRAIS_LIVRAISON_GRATUIT = 3;
    protected $configSecteurRepository;
    protected $parameterBag;

    public function __construct(ConfigSecteurRepository $configSecteurRepository, ParameterBagInterface $parameterBag)
    {
        $this->configSecteurRepository = $configSecteurRepository;
        $this->parameterBag = $parameterBag;
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

    public function getRefUrl($ref){
        return $this->parameterBag->get('pbb_ws_url').'/?ref='.$ref;
    }
}