<?php

namespace App\EventListener;

use App\Entity\User;
use App\Util\Search\Constants;
use App\Repository\SecteurRepository;
use App\Services\AuthService;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class LinkedAccountFromSectorPlatformListener
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
        private AuthService $authService
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->authorizationChecker = $authorizationChecker;
        $this->security = $security;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        
        $excludePaths = Constants::getExcludedPathsForSectorCheckUp([
           
        ]);

        foreach($excludePaths as $path){
            if(strncmp($request->getPathInfo(), $path, strlen($path)) == 0){
                return;
            }
        } 

        $user = $this->security->getUser();
        $secteur_id = $this->session->get('secteurId');
        $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);
        if($user && $this->authorizationChecker->isGranted(User::ROLE_AGENT) && $secteur?->getId() == $_ENV['SECTEUR_LITTLE_PONAILS_ID']){
            try {
                $agentSecteur = $user->getAgentSecteurById($secteur?->getId());
            } catch (\Throwable $th) {
                $this->authService->checkAndCreateAccountLpn($user);
            }
        }

        return;
        
    }

    
}
