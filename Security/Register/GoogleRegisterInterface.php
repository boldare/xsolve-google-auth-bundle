<?php

namespace Xsolve\GoogleAuthBundle\Security\Register;

use Xsolve\GoogleAuthBundle\ValueObject\ConfigurationValueObject;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Model\UserInterface;

interface GoogleRegisterInterface
{

    public function __construct(ConfigurationValueObject $configurationValueObject, UserManagerInterface $userManager);

    public function isUserAllowedToRegisterAutomatically(UserInterface $user);

    public function registerUser(UserInterface $user);
}
