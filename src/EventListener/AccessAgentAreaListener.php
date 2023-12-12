<?php 
namespace App\EventListener;

use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AccessAgentAreaListener implements EventSubscriberInterface
{
    private $urlGenerator;
    private $userRepository;
    private $tokenStorage;



    public function __construct(UrlGeneratorInterface $urlGenerator, UserRepository $userRepository, TokenStorageInterface $tokenStorage)
    {
        $this->urlGenerator = $urlGenerator;
        $this->userRepository = $userRepository;
        $this->tokenStorage = $tokenStorage;


    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $pathInfo = $request->getPathInfo();

        
        // Check if the path matches /agent/* and user doesn't have a paid subscription
        // if (strpos($pathInfo, '/agent/') === 0 && $user!=null && !$user->getHasPaidSubscription()) {
        if (strpos($pathInfo, '/agent/') === 0){
            $userInterface = $this->tokenStorage->getToken()->getUser();
            $user = $this->userRepository->findOneBy(["email"=>$userInterface->getUserIdentifier()]);
            // dd($user);
            if($user!=null && !$user->getHasPaidSubscription()){
                $event->setResponse(new RedirectResponse($this->urlGenerator->generate('client_pack_payment')));
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}