<?php

namespace Xsolve\GoogleAuthBundle\Security\Authentication;

use Symfony\Component\HttpFoundation\Request;
use Xsolve\GoogleAuthBundle\Builder\ClientBuilderInterface;
use FOS\UserBundle\Model\UserManagerInterface;

interface GoogleAuthenticationInterface
{
    /**
     * @return \FOS\UserBundle\Model\UserInterface
     * @throws \Xsolve\GoogleAuthBundle\Exception\NotAuthorizedException
     */
    public function authenticateUser(Request $request);

    public function getAuthUrl();

}
