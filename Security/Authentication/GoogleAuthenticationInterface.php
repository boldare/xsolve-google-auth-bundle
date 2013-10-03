<?php

namespace Xsolve\GoogleAuthBundle\Security\Authentication;

use GoogleApi\Client;
use Symfony\Component\HttpFoundation\Request;
use GoogleApi\Contrib\apiOauth2Service;
use Xsolve\GoogleAuthBundle\Exception\NotAuthorizedException;
use Xsolve\GoogleAuthBundle\Builder\GoogleClientBuilder;
use FOS\UserBundle\Doctrine\UserManager;
use Xsolve\GoogleAuthBundle\Builder\FOSUserBuilder;

interface GoogleAuthenticationInterface
{

    public function __construct(GoogleClientBuilder $googleClientBuilder, UserManager $userManager);

    /**
     * @return \FOS\UserBundle\Model\UserInterface
     * @throws \Xsolve\GoogleAuthBundle\Exception\NotAuthorizedException
     */
    public function authenticateUser(Request $request);

    public function getAuthUrl();

}
