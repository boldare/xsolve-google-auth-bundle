<?php

namespace Xsolve\GoogleAuthBundle\Security\Register;

use Xsolve\GoogleAuthBundle\ValueObject\ConfigurationValueObject;
use FOS\UserBundle\Doctrine\UserManager;

interface GoogleRegisterInterface
{

    public function __construct(ConfigurationValueObject $configurationValueObject, UserManager $userManager);

    public function isUserAllowedToRegisterAutomatically($user);
}
