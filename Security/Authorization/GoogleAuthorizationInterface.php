<?php

namespace Xsolve\GoogleAuthBundle\Security\Authorization;

use FOS\UserBundle\Doctrine\UserManager;
use Xsolve\GoogleAuthBundle\Exception\FailureAuthorizedException;
use Symfony\Component\Security\Core\User\UserInterface;

interface GoogleAuthorizationInterface
{

    public function __construct(UserManager $userManager);

    public function authorizeUser(UserInterface $authenticatedUser);
}
