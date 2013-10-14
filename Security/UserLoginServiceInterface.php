<?php

namespace Xsolve\GoogleAuthBundle\Security;

use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Security\LoginManagerInterface as FOSLoginManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserLoginServiceInterface
{
    public function login(UserInterface $user);
}
