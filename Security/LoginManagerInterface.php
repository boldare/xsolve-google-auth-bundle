<?php

namespace Xsolve\GoogleAuthBundle\Security;

use Xsolve\GoogleAuthBundle\Security\Authentication\GoogleAuthenticationManager;
use Xsolve\GoogleAuthBundle\Security\Authorization\GoogleAuthorizationManager;
use Xsolve\GoogleAuthBundle\Security\Register\GoogleRegisterManager;
use Symfony\Component\HttpFoundation\Request;

interface LoginManagerInterface
{
    public function __construct(GoogleAuthenticationManager $googleAuthenticationManager,
                                GoogleAuthorizationManager  $googleAuthorizationManager,
                                GoogleRegisterManager       $googleRegisterManager ,
                                FOSUserLoginService         $FOSUserLoginService );

    public function loginUser(Request $request);
}
