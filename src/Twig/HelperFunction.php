<?php

namespace App\Twig;

use App\Repository\AgentSecteurRepository;
use App\Repository\UserRepository;
use DateTime;
use Twig\TwigFilter;
use DateTimeInterface;
use IntlDateFormatter;
use Twig\TwigFunction;
use App\Util\GenericUtil;
use App\Repository\SecteurRepository;
use App\Services\AuthService;
use Twig\Extension\AbstractExtension;
use App\Services\Stat\StatAgentService;
use App\Util\LittlePonailsConstant;
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
        private AgentSecteurRepository $agentSecteurRepository,
        private AuthService $authService,
        private UserRepository $userRepository
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
            new TwigFunction('get_document_status_from_lpn', [$this, 'getDocumentStatusFromLpn']),
            new TwigFunction('get_document_type_from_lpn', [$this, 'getDocumentTypeFromLpn']),

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
        $ref = "PBB-" . $agentId . "-" . $rendezVousUserId;
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

    public function getOrderAmountHt($amountTTC, $savedAmountHT, $TVA)
    {
        if ($savedAmountHT == 0 && $amountTTC > 0) {
            return $amountTTC / (1. + $TVA / 100);
        }
        return $savedAmountHT;

    }

    public function getAttribute($obj, $field)
    {
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

    public function getLPNOnlineShop($id)
    {
        $agentSecteur = $this->agentSecteurRepository->findOneBy([
            'agent' => $id,
            'secteur' => $_ENV['SECTEUR_LITTLE_PONAILS_ID']
        ]);
        if (!$agentSecteur)
            return '';
        if ($agentSecteur && $agentSecteur->getSectorPlatformUsername() && empty($agentSecteur->getSectorPlatformAgentUsername())) {
            $this->authService->setUsernameFromLPN($agentSecteur);
        }
        return $_ENV['LITTLE_PONAILS_WORDPRESS_BASE_URL'] . '?sponsor=' . $agentSecteur->getSectorPlatformAgentUsername();
    }

    public function getLpnCommandStatusMeaningStr($status, $type = "wc-")
    {
        $statusMData = [
            'wc-' => [
                "wc-processing" => "En cours de préparation",
                "wc-completed" => "Completée",
                "wc-refunded" => "Remboursée",
                "wc-failed" => "Archivée",
                "wc-cancelled" => "Annulée",
            ],
            "emp" => [
                "processing" => "En cours de préparation",
                "completed" => "Completée",
                "refunded" => "Remboursée",
                "trash" => "Archivée",
                "cancelled" => "Annulée"
            ]
        ];
        if (!isset($statusMData[$type]))
            return '';
        return $statusMData[$type][$status] ?? '';
    }

    public function generateProductLink($secteurId, $userId)
    {
        $link = "";
        if ($secteurId == $_ENV['SECTEUR_DIGITAL_ID']) {
            return $_ENV['CATALOGUES_BASE_URL'] . '?ref=' . $this->generateReference($userId, $userId);
        } elseif ($secteurId == $_ENV['SECTEUR_LITTLE_PONAILS_ID']) {
            return $this->getLPNOnlineShop($userId);
        } elseif ($secteurId == $_ENV['SECTEUR_PROBOT_X_ID']) {
            $user = $this->userRepository->find($userId);
            return $user->getProbotXLink();
        } else {
            return $link;
        }
    }

    public function getDocumentStatusFromLpn($status_value)
    {
        if (isset(LittlePonailsConstant::DOCUMENT_STATUS[$status_value])) {
            return LittlePonailsConstant::DOCUMENT_STATUS[$status_value];
        }
        return '';
    }

    public function getDocumentTypeFromLpn($type_value)
    {
        if (isset(LittlePonailsConstant::DOCUMENT_TYPE[$type_value])) {
            return LittlePonailsConstant::DOCUMENT_TYPE[$type_value];
        }
        return '';
    }

    public function transformMonthlyBreakDownStatToDataset($data){
        $labels = [];
        $datasets = [];
        $colorsParameters = [
            [
                'borderColor' => '#0d6efd',    
                'backgroundColor' => 'rgba(13, 110, 253, 0.1)'
            ],
            [
                'borderColor' => '#e8355d',
                'backgroundColor' => 'rgba(232, 53, 93, 0.1)'
            ],
            [
                'borderColor' => '#dc3545',    
                'backgroundColor' => 'rgba(220, 53, 69, 0.1)'
            ],
            [
                'borderColor' => '#fd7e14',   
                'backgroundColor' => 'rgba(253, 126, 20, 0.1)'
            ],
            [
                'borderColor' => '#6f42c1',  
                'backgroundColor' => 'rgba(111, 66, 193, 0.1)'
            ],
            [
                'borderColor' => '#20c997',    
                'backgroundColor' => 'rgba(32, 201, 151, 0.1)'
            ]
        ];

        $currentColorIndex = 0;
        foreach ($data as $key => $value) {
            $colorParameter = $colorsParameters[$currentColorIndex] ?? $colorsParameters[0];
            $labels = array_keys($value);
            $datasets[] = [
                'label' => $key,
                'data' => array_values($value),
                'borderColor' => $colorParameter['borderColor'] ,
                'backgroundColor' =>  $colorParameter['backgroundColor'] ,
                'pointBackgroundColor' => $colorParameter['borderColor'] ,
                'fill' => true,
                'tension' => 0.4,
            ];
            $currentColorIndex++;
        }
        return [
            'labels' =>$labels,
            'datasets' =>$datasets,
        ];
    }


}
