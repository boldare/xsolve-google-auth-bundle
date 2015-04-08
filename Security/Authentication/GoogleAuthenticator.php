<?php

namespace Xsolve\GoogleAuthBundle\Security\Authentication;

use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Xsolve\GoogleAuthBundle\Builder\ClientBuilderInterface;
use Xsolve\GoogleAuthBundle\Builder\FOSUserBuilder;
use Xsolve\GoogleAuthBundle\Exception\NotAuthorizedException;
use Xsolve\GoogleAuthBundle\Security\Authentication\GoogleAuthenticationInterface;

class GoogleAuthenticator implements GoogleAuthenticationInterface
{

    /**
     * @var \Google_Client
     */
    protected $client;

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @param ClientBuilderInterface $googleClientBuilder
     * @param UserManagerInterface $userManager
     */
    public function __construct(ClientBuilderInterface $googleClientBuilder, UserManagerInterface $userManager)
    {
        $this->client      = $googleClientBuilder->getClient();
        $this->userManager = $userManager;
    }

    /**
     * {@inheritDoc}
     */
    public function authenticateUser(Request $request)
    {
        if (!$request->query->has('code')) {
            throw new NotAuthorizedException("There's missing authorization code");
        }

        $fosUserBuilder = new FOSUserBuilder($this->userManager);
        $oauth2         = new \Google_Service_Oauth2($this->client);

        try {
            $this->client->authenticate($request->query->get('code'));
        } catch(\Google_Auth_Exception $e) {
            throw new NotAuthorizedException(401, "XSolve Google Auth couldn't authorize user", $e);
        }

        return $fosUserBuilder->build($oauth2->userinfo->get());
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthUrl()
    {
        $url = $this->client->createAuthUrl();

        return preg_replace('/&approval_prompt=force/', '', $url);
    }
}
