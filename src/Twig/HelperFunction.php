<?php

namespace App\Twig;

use DateTime;
use Twig\TwigFilter;
use DateTimeInterface;
use IntlDateFormatter;
use Twig\TwigFunction;
use App\Util\GenericUtil;
use App\Util\Search\Constants;
use App\Repository\SecteurRepository;
use Twig\Extension\AbstractExtension;
use App\Services\Stat\StatAgentService;
use App\Repository\AgentSecteurRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class HelperFunction extends AbstractExtension
{
    private $router;
    private $requestStack;
    private $security;
    private $session;


    public function __construct(
        UrlGeneratorInterface $router,
        RequestStack $requestStack,
        private StatAgentService $statAgentService,
        Security $security,
        SessionInterface $session,
        private SecteurRepository $secteurRepository,
        private AgentSecteurRepository $agentSecteurRepository
    ) {
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->security = $security;
        $this->session = $session;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('generateReference', [$this, 'generateReference']),
            new TwigFunction('custom_path', [$this, 'customPath']),
            new TwigFunction('get_stat', [$this, 'getStat']),
            new TwigFunction('get_order_amount_HT', [$this, 'getOrderAmountHt']),
            new TwigFunction('obj_attribute', [$this, 'getAttribute']),
            new TwigFunction('get_lpn_online_shop', [$this, 'getLPNOnlineShop']),
            new TwigFunction('get_lpn_command_status_meaning', [$this, 'getLpnCommandStatusMeaningStr']),
            new TwigFunction('generate_product_link', [$this, 'generateProductLink']),

        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('localized_month', [$this, 'getLocalizedMonth']),
        ];
    }


    public function generateReference($agentId, $rendezVousUserId, $contactId = null, $meetingId = null)
    {
        // Your custom logic here
        $ref = Constants::REFERENCE_PREFIX."-" . $agentId . "-" . $rendezVousUserId;
        if (!is_null($contactId)) {
            $ref .= "-" . $contactId;
        }
        if ($meetingId) {
            $ref .= "-" . $meetingId;
        }
        return $ref;
    }

    public function customPath($name, $parameters = [], $relative = false)
    {
        $agent = (object) $this->security->getUser();
        $ref = null;
        if ($agent) {
            $ref = "?ref=" . $this->generateReference($agent->getId(), $agent->getId());
        }
        $arrayLink = [
            "service_seo" => "/seo",
            "service_dev_web" => "/developpement-web",
            "service_conception_graphique" => "/conception-graphique",
            "service_social_media_marketing" => "/social-media-marketing",
            "service_adwords" => "/adwords",
            "service_dev_app_mobile" => "/developpement-application-mobile",
        ];
        if (isset($arrayLink[$name])) {
            return $_ENV['CATALOGUES_BASE_URL'] . $arrayLink[$name] . ($ref ?? "");
        }
        return "#";
    }

    public function getStat()
    {
        $agent = (object) $this->security->getUser();
        $secteur = $this->secteurRepository->findOneBy(['id' => $this->session->get('secteurId')]);
        return $this->statAgentService->getAgentStat($agent, $secteur);
    }

    public function getOrderAmountHt($amountTTC,$savedAmountHT,$TVA){
        if($savedAmountHT == 0 &&  $amountTTC > 0 ){
            return $amountTTC / (1. + $TVA/100);
        }
        return $savedAmountHT;

    }

    public function getAttribute($obj,$field){
        try {
            $value = GenericUtil::getPropertyValue($obj, $field);
            return $value;
        } catch (\Throwable $th) {
            //throw $th;
            return '';
        }
    }

    public function getLocalizedMonth($date, string $locale = 'fr_FR'): string
    {
        // Convert string to DateTime if necessary
        if (!$date instanceof DateTimeInterface) {
            $date = new DateTime($date);
        }

        $formatter = new IntlDateFormatter($locale, IntlDateFormatter::FULL, IntlDateFormatter::NONE);
        $formatter->setPattern('MMMM'); // Full month name
        
        return ucfirst($formatter->format($date)); // Capitalize first letter
    }

    public function getLPNOnlineShop($id){
        $agentSecteur = $this->agentSecteurRepository->findOneBy([
            'agent' => $id,
            'secteur' => $_ENV['SECTEUR_LITTLE_PONAILS_ID']
        ]);
        if(!$agentSecteur) return '';
        return $_ENV['LITTLE_PONAILS_WORDPRESS_BASE_URL'].'?sponsor='.$agentSecteur->getSectorPlatformAgentUsername();
    }

    public function getLpnCommandStatusMeaningStr($status,$type = "wc-"){
        $statusMData = [
            'wc-' =>[
                "wc-processing" => "En cours de préparation",
                "wc-completed" => "Completée",
                "wc-refunded" => "Remboursée",
                "wc-failed" => "Archivée",
                "wc-cancelled" => "Annulée",
            ],
            "emp" => [
                "processing"=> "En cours de préparation",
                "completed"=> "Completée",
                "refunded"=> "Remboursée",
                "trash"=> "Archivée",
                "cancelled"=> "Annulée"
            ]
        ];
        if(!isset($statusMData[$type])) return '';
        return $statusMData[$type][$status] ?? '';
    }

    public function generateProductLink($secteurId,$userId){
        $link = "" ;
        if($secteurId == $_ENV['SECTEUR_DIGITAL_ID']){
            return  $_ENV['CATALOGUES_BASE_URL'].'?ref='.$this->generateReference($userId,$userId);
        }
        elseif($secteurId == $_ENV['SECTEUR_LITTLE_PONAILS_ID']){
            return $this->getLPNOnlineShop($userId);
        }
        else{
            return $link;
        }
    }
}
