<?php

namespace Xsolve\GoogleAuthBundle\Builder;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\Container;
use FOS\UserBundle\Model\UserInterface;
use Xsolve\GoogleAuthBundle\Builder\UserBuilderInterface;
use Xsolve\GoogleAuthBundle\Security\UserLoginServiceInterface;

class FOSUserBuilder implements UserBuilderInterface
{

    /**
     * @var \FOS\UserBundle\Doctrine\UserManager
     */
    protected $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param array $googleAuthUser
     * @return \FOS\UserBundle\Model\UserInterface
     */
    public function build(array $googleAuthUser)
    {
        $user = $this->userManager->createUser();

        foreach ($googleAuthUser as $key => $value) {
            $methodName = "set" . Container::camelize($key);
            if (method_exists($user, $methodName)) {
                $user->$methodName($value);
            }
        }

        $user->setEmail($googleAuthUser['email']);
        $user->setUsername($googleAuthUser['email']);
        $user->setEnabled(1);
        $user->setPassword(time());

        return $user;
    }
}
