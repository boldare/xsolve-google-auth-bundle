<?php

namespace Xsolve\GoogleAuthBundle\Security;

use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Security\LoginManagerInterface as FOSLoginManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Xsolve\GoogleAuthBundle\Security\UserLoginServiceInterface;

class FOSUserLoginService implements UserLoginServiceInterface
{

    /**
     * @var \FOS\UserBundle\Doctrine\UserManager
     */
    protected $userManager;

    /**
     * @var \FOS\UserBundle\Security\LoginManager
     */
    protected $loginManager;

    /**
     * @var string
     */
    protected $providerKey;

    public function __construct(UserManagerInterface $userManager, FOSLoginManagerInterface $loginManager, $providerKey)
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
