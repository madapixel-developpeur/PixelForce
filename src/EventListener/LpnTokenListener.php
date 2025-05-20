<?php

namespace App\EventListener;

use App\Entity\User;
use App\Util\Search\Constants;
use App\Repository\SecteurRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class LpnTokenListener
{
    private $urlGenerator;
    private $authorizationChecker;
    private $security;

    public function __construct(
        UrlGeneratorInterface $urlGenerator, 
        AuthorizationCheckerInterface $authorizationChecker, 
        Security $security,
        private SessionInterface $session,
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->authorizationChecker = $authorizationChecker;
        $this->security = $security;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        
        $pathsToChekPath = [
            $this->urlGenerator->generate('agent_update_platform_secteur_account'),
            $this->urlGenerator->generate('agent_lpn_sign_reseller_contract'),
            $this->urlGenerator->generate('agent_lpn_supporting_documents_add'),
            '/little-ponails/supporting-documents'
        ];

        $needCheckUp = false;
        $nextStep = 0;
        foreach($pathsToChekPath as $key => $path){
            if(strncmp($request->getPathInfo(), $path, strlen($path)) == 0){
                $needCheckUp = true;
                $nextStep = $key;
            }
        } 


        if(!$needCheckUp) return;
        if($this->session->get('lpn_token')){
            return;
        }
        $event->setResponse(new RedirectResponse($this->urlGenerator->generate('agent_lpn_get_access', ['nextStep' => $nextStep ])));
        
    }

    
}
