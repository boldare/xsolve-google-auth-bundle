<?php

namespace Xsolve\GoogleAuthBundle\Builder;

interface UserBuilderInterface
{
    /**
     * @param array $googleAuthUser
     * @return \FOS\UserBundle\Model\UserInterface
     */
    public function build(array $googleAuthUser);

}
