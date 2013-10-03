<?php

namespace Xsolve\GoogleAuthBundle\Builder;

use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\DependencyInjection\Container;
use FOS\UserBundle\Model\UserInterface;

class FOSUserBuilder
{

    /**
     * @var \FOS\UserBundle\Doctrine\UserManager
     */
    protected $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param array $googleAuthUser
     * @return \FOS\UserBundle\Model\UserInterface
     */
    public function build($googleAuthUser)
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
        $user->setRoles(array(UserInterface::ROLE_DEFAULT));

        return $user;
    }
}
