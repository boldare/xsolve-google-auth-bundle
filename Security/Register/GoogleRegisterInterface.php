<?php

namespace Xsolve\GoogleAuthBundle\Security\Register;

use FOS\UserBundle\Model\UserInterface;

interface GoogleRegisterInterface
{
    public function isUserAllowedToRegisterAutomatically(UserInterface $user);

    public function registerUser(UserInterface $user);
}
