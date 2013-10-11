<?php

namespace Xsolve\GoogleAuthBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Xsolve\GoogleAuthBundle\ValueObject\ConfigurationValueObject;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Xsolve\GoogleAuthBundle\Security\Authentication\GoogleAuthenticationInterface;

class RedirectManager
{

    /**
     * @var \Xsolve\GoogleAuthBundle\ValueObject\ConfigurationValueObject
     */
    protected $googleAuthConfiguration;

    /**
     * @var \Xsolve\GoogleAuthBundle\Security\Authentication\GoogleAuthenticator
     */
    protected $googleAuthenticator;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    public function __construct(ConfigurationValueObject        $googleAuthConfiguration,
                                GoogleAuthenticationInterface   $googleAuthenticator,
                                Router                          $router,
                                Session                         $session)
    {
        $this->googleAuthConfiguration = $googleAuthConfiguration;
        $this->googleAuthenticator     = $googleAuthenticator;
        $this->router                  = $router;
        $this->session                 = $session;
    }

    public function registerRequest(Request $request)
    {
        if ($request->get('redir')) {
            $this->session->set('redir', $request->get('redir'));
        }
    }

    public function getSuccessRedirectUrl()
    {
        if ($this->session->get('redir')) {
            $redirectUrl = $this->session->get('redir');
            $this->session->remove('redir');

            return $redirectUrl;
        }

        return $this->router->generate($this->googleAuthConfiguration->getSuccessAuthorizationRedirectUrl());
    }

    public function getFailureAuthorizedUrl()
    {
        return $this->router->generate($this->googleAuthConfiguration->getFailureAuthorizationRedirectUrl());
    }

    public function getNotAuthorizedUrl()
    {
        return $this->googleAuthenticator->getAuthUrl();
    }
}