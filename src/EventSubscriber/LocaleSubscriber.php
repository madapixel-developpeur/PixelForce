<?php

namespace App\EventSubscriber;

use Twig\Environment;
use App\Repository\UserRepository;
use App\Repository\UsersRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleSubscriber implements EventSubscriberInterface
{

    private $translator;
    private $session;
    private $environment;
    
    public function __construct(TranslatorInterface $translator, SessionInterface $session, Environment $environment,
    private Security $security,
    private UserRepository $usersRepository
    )
    {
        $this->translator = $translator;
        $this->session = $session;
        $this->environment = $environment;
    }
    public function onKernelController(ControllerEvent $event)
    {
        $request = $event->getRequest();
        $locale = $request->query->get('lang');
        $user = $this->security->getUser();
        if ($locale == null) {
            $locale = $user?->getLang() ?? $request->getSession()->get('lang');
        }
        if ($locale != null) {
            $request->setLocale($locale);
            $this->translator->setLocale($locale);
            // Optionally persist the locale for the user's session:
            $request->getSession()->set('lang', $locale); 
            if($user && $user->getLang() != $locale){
                $this->usersRepository->changeLang($user,$locale);
            }

        }

        
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}