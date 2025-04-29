<?php

namespace App\EventListener;

use App\Entity\User;
use App\Util\Search\Constants;
use App\Repository\SecteurRepository;
use App\Services\User\AgentService;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SecteurListener
{
    private $urlGenerator;
    private $authorizationChecker;
    private $security;

    public function __construct(
        UrlGeneratorInterface $urlGenerator, 
        AuthorizationCheckerInterface $authorizationChecker, 
        Security $security,
        private SessionInterface $session,
        private SecteurRepository $secteurRepository,
        private AgentService $agentService
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->authorizationChecker = $authorizationChecker;
        $this->security = $security;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        
        $excludePaths = Constants::getExcludedPathsForSectorCheckUp();
        $excludePaths = array_diff($excludePaths, [ '/agent/accueil','/agent/secteur']);

        foreach($excludePaths as $path){
            if(strncmp($request->getPathInfo(), $path, strlen($path)) == 0){
                return;
            }
        } 

        $user = $this->security->getUser();
        $secteur_id = $this->session->get('secteurId');
        $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);
        $contentAvailabilityStatus = $this->session->get('enabledContent');
        if($user && $this->authorizationChecker->isGranted(User::ROLE_AGENT) and is_null($contentAvailabilityStatus)){
            $this->agentService->setSesssionEnabledContent($user);
        }
        if($user && $this->authorizationChecker->isGranted(User::ROLE_AGENT) && !$secteur){
            $secteurDigital =  $this->secteurRepository->findOneBy(['id' => $_ENV['SECTEUR_DIGITAL_ID'] ]);
            $agentSecteurDigital = $user->getAgentSecteurById($_ENV['SECTEUR_DIGITAL_ID']);
            if(!$agentSecteurDigital){
                $this->agentService->agentAddSector($user,$secteurDigital);
            }
            $this->session->set('secteurId', $_ENV['SECTEUR_DIGITAL_ID']);
            $this->session->set('typeSecteurId', $secteurDigital->getType()->getId());
            // $event->setResponse(new RedirectResponse($this->urlGenerator->generate('agent_home')));
        }
        return;
        
    }

    
}
