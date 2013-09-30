<?php

namespace Xsolve\GoogleAuthBundle\Security;

use Xsolve\GoogleAuthBundle\Security\LoginManagerInterface;
use Xsolve\GoogleAuthBundle\Security\Authentication\GoogleAuthenticationManager;
use Xsolve\GoogleAuthBundle\Security\Authorization\GoogleAuthorizationManager;
use Xsolve\GoogleAuthBundle\Exception\FailureAuthorizedException;
use Xsolve\GoogleAuthBundle\Security\Register\GoogleRegisterManager;
use Xsolve\GoogleAuthBundle\Security\FOSUserLoginService;
use Symfony\Component\HttpFoundation\Request;

class GoogleLoginManager implements LoginManagerInterface
{

    /**
     * @var Authentication\GoogleAuthenticationManager
     */
    protected $googleAuthenticationManager;

    /**
    * @var Authorization\GoogleAuthorizationManager
    */
    protected $googleAuthorizationManager;

    /**
    * @var Register\GoogleRegisterManager
    */
    protected $googleRegisterManager;

    /**
     * @var FOSUserLoginService
     */
    protected $FOSUserLoginService;

    public function __construct(GoogleAuthenticationManager $googleAuthenticationManager,
                                GoogleAuthorizationManager  $googleAuthorizationManager,
                                GoogleRegisterManager       $googleRegisterManager ,
                                FOSUserLoginService         $FOSUserLoginService )
    {
        $this->googleAuthenticationManager = $googleAuthenticationManager;
        $this->googleAuthorizationManager  = $googleAuthorizationManager;
        $this->googleRegisterManager       = $googleRegisterManager;
        $this->FOSUserLoginService         = $FOSUserLoginService;
    }

    public function loginUser(Request $request)
    {
        $authenticatedUser = $this->googleAuthenticationManager->authenticateUser($request);

        try {
            $user = $this->googleAuthorizationManager->authorizeUser($authenticatedUser);
        } catch (FailureAuthorizedException $e) {
            if ( ! $this->googleRegisterManager->isUserAllowedToRegisterAutomatically($authenticatedUser)) {

                throw new FailureAuthorizedException("XSolve Google Auth couldn't authorize user. User's domain is not allowed");
            }

            $user = $authenticatedUser;
        }

        return $this->FOSUserLoginService->login($user);
    }
}
