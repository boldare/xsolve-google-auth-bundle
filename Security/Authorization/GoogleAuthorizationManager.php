<?php

namespace Xsolve\GoogleAuthBundle\Security\Authorization;

use Xsolve\GoogleAuthBundle\Security\Authorization\GoogleAuthorizationInterface;
use FOS\UserBundle\Doctrine\UserManager;
use Xsolve\GoogleAuthBundle\Exception\FailureAuthorizedException;
use Symfony\Component\Security\Core\User\UserInterface;

class GoogleAuthorizationManager implements GoogleAuthorizationInterface
{
    /**
    * @var \FOS\UserBundle\Doctrine\UserManager
    */
    protected $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function authorizeUser(UserInterface $authenticatedUser)
    {
        $user = $this->userManager->findUserByEmail($authenticatedUser->getEmail());

        if (null == $user) {
            throw new FailureAuthorizedException(401, "XSolve Google Auth couldn't authorize user. User doesn't exists");
        }

        return $user;
    }
}
