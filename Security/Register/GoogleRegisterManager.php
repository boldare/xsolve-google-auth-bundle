<?php

namespace Xsolve\GoogleAuthBundle\Security\Register;

use Xsolve\GoogleAuthBundle\Security\Register\GoogleRegisterInterface;
use Xsolve\GoogleAuthBundle\ValueObject\ConfigurationValueObject;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Model\UserInterface;

class GoogleRegisterManager implements GoogleRegisterInterface
{

    protected $configurationValueObject;

    protected $userManager;

    public function __construct(ConfigurationValueObject $configurationValueObject, UserManagerInterface $userManager)
    {
        $this->configurationValueObject = $configurationValueObject;
        $this->userManager = $userManager;
    }

    public function isUserAllowedToRegisterAutomatically(UserInterface $user)
    {
        $availableDomains = $this->configurationValueObject->getAutoregistrationDomains();

        return $this->configurationValueObject->getAutoregistration() &&
            (count($availableDomains) == 0 ||
             (count($availableDomains) > 0 && in_array(substr($user->getEmail(), strpos($user->getEmail(), '@')+1), $availableDomains))
            );
    }

    public function registerUser(UserInterface $user)
    {
        $this->userManager->updateUser($user);

        return $user;
    }

}
