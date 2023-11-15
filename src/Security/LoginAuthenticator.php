<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UrlGeneratorInterface $urlGenerator, UserRepository $userRepository)
    {
        $this->urlGenerator = $urlGenerator;
        $this->userRepository = $userRepository;
    }

    /*public function supports(Request $request): bool
    {
        return $request->isMethod('POST') && $this->getLoginUrl($request) === $request->getRequestUri();
    }*/

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');
        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email, function($value) use(&$request) {
               $user = $this->userRepository->findOneBy(['email' => $value]);
                if($user) {
                    if($user->getActive() === -1){
                        $request->getSession()->getFlashBag()->add('danger', 'Vous n’êtes pas autorisé sur la plateforme Green life ultimate');
                        return null;
                    }
                    if(in_array(User::ROLE_CLIENT,$user->getRoles())){
                        $agentToken = $request->get('agentToken');
                        $agent = $this->userRepository->findAgentByToken($agentToken);
                        if($user->getClientAgent() && $agent && $user->getClientAgent()->getId() == $agent->getId()){}
                        else{
                            $request->getSession()->getFlashBag()->add('danger', "Veuillez vous connectez avec le lien de votre agent");
                            return null;
                        }
                    }
                    
                }
               return $user ? $user : $this->userRepository->findOneBy(['username' => $value]);
            }),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $user = (object)$token->getUser();
        if(in_array(User::ROLE_ADMINISTRATEUR, $token->getRoleNames())) {
            return new RedirectResponse('/admin/dashboard');
        } else if(in_array(User::ROLE_COACH, $token->getRoleNames())) { 
            return new RedirectResponse('/coach/dashboard'); 
        } else if(in_array(User::ROLE_AGENT, $token->getRoleNames())) { 
            return new RedirectResponse('/agent/accueil'); 
        } else if(in_array(User::ROLE_CLIENT, $token->getRoleNames())) { 
            return new RedirectResponse('/boutique/'.$user->getClientAgent()->getUsername().'/'); 
        } else if(in_array(User::ROLE_DOCUMENT_OWNER, $token->getRoleNames())) { 
            return new RedirectResponse('/do'); 
        } 

        return new RedirectResponse('/dashboard');
        // For example:
        //return new RedirectResponse($this->urlGenerator->generate('some_route'));
        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
