<?php

namespace Xsolve\GoogleAuthBundle\Security\Authentication;

use Xsolve\GoogleAuthBundle\Security\Authentication\GoogleAuthenticationInterface;
use Symfony\Component\HttpFoundation\Request;
use Xsolve\GoogleAuthBundle\Exception\NotAuthorizedException;
use Xsolve\GoogleAuthBundle\Builder\ClientBuilderInterface;
use Xsolve\GoogleAuthBundle\Builder\FOSUserBuilder;
use Exception;
use FOS\UserBundle\Model\UserManagerInterface;
use Google_Oauth2Service;

class GoogleAuthenticator implements GoogleAuthenticationInterface
{

    /**
     * @var \GoogleApi\Client
     */
    protected $client;

    /**
     * @var \FOS\UserBundle\Doctrine\UserManager
     */
    protected $userManager;

    public function __construct(ClientBuilderInterface $googleClientBuilder, UserManagerInterface $userManager)
    {
        $this->client      = $googleClientBuilder->getClient();
        $this->userManager = $userManager;
    }

    /**
     * @return \FOS\UserBundle\Model\UserInterface
     * @throws \Xsolve\GoogleAuthBundle\Exception\NotAuthorizedException
     */
    public function authenticateUser(Request $request)
    {
        if (!$request->get('code')) {

            throw new NotAuthorizedException("There's missing authorization code");
        }

        $fosUserBuilder = new FOSUserBuilder($this->userManager);
        $oauth2         = new Google_Oauth2Service($this->getClient());

        try {
            $this->getClient()->authenticate();
        } catch(Exception $e) {

            throw new NotAuthorizedException(401, "XSolve Google Auth couldn't authorize user");
        }

        return $fosUserBuilder->build($oauth2->userinfo->get());
    }

    public function getAuthUrl()
    {
        $url = $this->getClient()->createAuthUrl();

        return preg_replace('/&approval_prompt=force/', '', $url);
    }

    protected function getClient()
    {
        return $this->client;
    }
}
