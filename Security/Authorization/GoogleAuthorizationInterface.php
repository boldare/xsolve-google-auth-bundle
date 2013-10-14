<?php

namespace Xsolve\GoogleAuthBundle\Security\Authorization;

use Symfony\Component\Security\Core\User\UserInterface;

interface GoogleAuthorizationInterface
{
    public function authorizeUser(UserInterface $authenticatedUser);
}
