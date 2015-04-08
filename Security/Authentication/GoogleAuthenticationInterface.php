<?php

namespace Xsolve\GoogleAuthBundle\Security\Authentication;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Xsolve\GoogleAuthBundle\Exception\NotAuthorizedException;

interface GoogleAuthenticationInterface
{
    /**
     * @param Request $request
     * @return UserInterface
     * @throws NotAuthorizedException
     */
    public function authenticateUser(Request $request);

    /**
     * @return string
     */
    public function getAuthUrl();
}
