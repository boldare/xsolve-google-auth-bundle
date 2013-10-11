<?php

namespace Xsolve\GoogleAuthBundle\Security;

use Xsolve\GoogleAuthBundle\Security\Authentication\GoogleAuthenticationInterface;
use Xsolve\GoogleAuthBundle\Security\Authorization\GoogleAuthorizationInterface;
use Xsolve\GoogleAuthBundle\Security\Register\GoogleRegisterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

interface LoginManagerInterface
{
    public function __construct(GoogleAuthenticationInterface $authenticator,
                                GoogleAuthorizationInterface  $authorizer,
                                GoogleRegisterInterface       $registerManager ,
                                UserLoginServiceInterface     $userLoginService,
                                LoggerInterface               $logger);

    public function loginUser(Request $request);
}
