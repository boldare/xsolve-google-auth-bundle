<?php

namespace Xsolve\GoogleAuthBundle\Builder;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\Container;
use FOS\UserBundle\Model\UserInterface;

interface UserBuilderInterface
{

    public function __construct(UserManagerInterface $userManager);

    /**
     * @param array $googleAuthUser
     * @return \FOS\UserBundle\Model\UserInterface
     */
    public function build($googleAuthUser);

}
