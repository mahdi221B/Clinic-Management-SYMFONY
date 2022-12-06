<?php

namespace App\Security;

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

class UserAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator= $urlGenerator;
    }
    /*public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }*/

    public function authenticate(Request $request): Passport
    {
        $adresse = $request->request->get('adresse', '');
        $request->getSession()->set(Security::LAST_USERNAME, $adresse);
        return new Passport(
            new UserBadge($adresse),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }


        $user = $token->getUser();
        if(in_array('ROLE_ADMIN',$user->getRoles(),true)){
            if(false === $user->isEnabled()) {
                //dd("compte bloqué");
                return new RedirectResponse($this->urlGenerator->generate('blocked'));
            }
            return new RedirectResponse($this->urlGenerator->generate('affiche'));
        }
        if(in_array('ROLE_MEDECIN',$user->getRoles(),true)){
            if(false === $user->isEnabled()) {
                return new RedirectResponse($this->urlGenerator->generate('blocked'));
            }
            return new RedirectResponse($this->urlGenerator->generate('doc'));
        }
        if(in_array('ROLE_INFIRMIER',$user->getRoles(),true)){
            if(false === $user->isEnabled()) {
                return new RedirectResponse($this->urlGenerator->generate('blocked'));
            }
            return new RedirectResponse($this->urlGenerator->generate('infir'));
        }
        if(in_array('ROLE_STOCK',$user->getRoles(),true)){
            if(false === $user->isEnabled()) {
                return new RedirectResponse($this->urlGenerator->generate('blocked'));
            }
            return new RedirectResponse($this->urlGenerator->generate('agent_stock'));
        }
        if(in_array('ROLE_SECRETAIRE',$user->getRoles(),true)){
            if(false === $user->isEnabled()) {
                return new RedirectResponse($this->urlGenerator->generate('blocked'));
            }
            return new RedirectResponse($this->urlGenerator->generate('secretaire'));
        }
        if(in_array('ROLE_TECHNICIEN',$user->getRoles(),true)){
            if(false === $user->isEnabled()) {
                return new RedirectResponse($this->urlGenerator->generate('blocked'));
            }
            return new RedirectResponse($this->urlGenerator->generate('technicien'));
        }
        if(in_array('ROLE_USER',$user->getRoles(),true)){
            if(false === $user->isEnabled()) {
                return new RedirectResponse($this->urlGenerator->generate('blocked'));
            }
            return new RedirectResponse($this->urlGenerator->generate('user_role'));
        }
        return new RedirectResponse($this->urlGenerator->generate('app_back_office'));
        //throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
