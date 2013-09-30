<?php

namespace Xsolve\GoogleAuthBundle\Security;

use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Security\LoginManager;
use Symfony\Component\Security\Core\User\UserInterface;

class FOSUserLoginService {

    /**
     * @var \FOS\UserBundle\Doctrine\UserManager
     */
    protected $userManager;

    protected $loginManager;

    protected $providerKey;

    public function __construct(UserManager $userManager, LoginManager $loginManager, $providerKey)
    {
        $this->userManager  = $userManager;
        $this->loginManager = $loginManager;
        $this->providerKey  = $providerKey;
    }

    public function login(UserInterface $user)
    {
        $user->setLastLogin(new \DateTime());
        $this->userManager->updateUser($user);

        $this->loginManager->loginUser($this->providerKey, $user);

        return $user;
    }
}
