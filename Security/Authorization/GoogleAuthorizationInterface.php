<?php

namespace Xsolve\GoogleAuthBundle\Security\Authorization;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface GoogleAuthorizationInterface
{

    public function __construct(UserManagerInterface $userManager);

    public function authorizeUser(UserInterface $authenticatedUser);
}
