<?php

namespace Xsolve\GoogleAuthBundle\Security\Authentication;

use Symfony\Component\HttpFoundation\Request;

interface GoogleAuthenticationInterface
{
    /**
     * @return \FOS\UserBundle\Model\UserInterface
     * @throws \Xsolve\GoogleAuthBundle\Exception\NotAuthorizedException
     */
    public function authenticateUser(Request $request);

    public function getAuthUrl();

}
