<?php

namespace App\Twig;

use App\Repository\SecteurRepository;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use App\Services\Stat\StatAgentService;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class HelperFunction extends AbstractExtension
{
    private $router;
    private $requestStack;
    private $security;
    private $session;

    public function __construct(UrlGeneratorInterface $router, RequestStack $requestStack,
    private StatAgentService $statAgentService,
    Security $security,
    SessionInterface $session,
    private SecteurRepository $secteurRepository)
    {
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
        $arrayLink  = [
            "service_seo" => "/seo",
            "service_dev_web" => "/developpement-web",
            "service_conception_graphique" => "/conception-graphique",
            "service_social_media_marketing" => "/social-media-marketing",
            "service_adwords" => "/adwords",
            "service_dev_app_mobile" => "/developpement-application-mobile",
        ];
        if(isset($arrayLink[$name])){
            return $_ENV['PBB_WS_URL']."/services".$arrayLink[$name];
        }
        return "#";
    }

    public function getStat(){
        $agent = (object) $this->security->getUser();
        $secteur = $this->secteurRepository->findOneBy(['id' => $this->session->get('secteurId')]);
        return $this->statAgentService->getAgentStat($agent,$secteur);
    }
}
