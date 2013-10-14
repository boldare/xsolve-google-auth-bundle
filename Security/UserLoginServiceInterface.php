<?php

namespace Xsolve\GoogleAuthBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserLoginServiceInterface
{
    public function login(UserInterface $user);
}
