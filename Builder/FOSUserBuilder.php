<?php

namespace Xsolve\GoogleAuthBundle\Builder;

use FOS\UserBundle\Doctrine\UserManager;

class FOSUserBuilder {

    /**
     * @var \FOS\UserBundle\Doctrine\UserManager
     */
    protected $userManager;

    public function __construct(UserManager $userManager) {
        $this->userManager = $userManager;
    }

    /**
     * @param array $googleAuthUser
     * @return \FOS\UserBundle\Model\UserInterface
     */
    public function build($googleAuthUser) {
        $user = $this->userManager->createUser();

        foreach ($googleAuthUser as $key => $value) {
            $methodName = "set" . $this->dashesToCamelCase($key);
            if (method_exists($user, $methodName)) {
                $user->$methodName($value);
            }
        }

        $user->setEmail($googleAuthUser['email']);
        $user->setUsername($googleAuthUser['email']);
        $user->setEnabled(1);
        $user->setPassword(time());
        $user->setRoles(array('ROLE_USER'));

        return $user;
    }

    private function dashesToCamelCase($string, $capitalizeFirstCharacter = true)
    {

        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }
}

