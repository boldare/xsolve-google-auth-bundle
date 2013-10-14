<?php

namespace Xsolve\GoogleAuthBundle\Security;

use Xsolve\GoogleAuthBundle\Exception\NotAuthorizedException;
use Xsolve\GoogleAuthBundle\Security\LoginManagerInterface;
use Xsolve\GoogleAuthBundle\Security\Authentication\GoogleAuthenticationInterface;
use Xsolve\GoogleAuthBundle\Security\Authorization\GoogleAuthorizationInterface;
use Xsolve\GoogleAuthBundle\Exception\FailureAuthorizedException;
use Xsolve\GoogleAuthBundle\Security\Register\GoogleRegisterInterface;
use Xsolve\GoogleAuthBundle\Security\UserLoginServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class GoogleLoginManager implements LoginManagerInterface
{

    /**
     * @var Authentication\GoogleAuthenticator
     */
    protected $googleAuthenticator;

    /**
     * @var Authorization\GoogleAuthorizer
     */
    protected $googleAuthorizer;

    /**
    * @var Register\GoogleRegisterManager
    */
    protected $googleRegisterManager;

    /**
     * @var FOSUserLoginService
     */
    protected $FOSUserLoginService;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    protected $logger;

    public function __construct(GoogleAuthenticationInterface   $authenticator,
                                GoogleAuthorizationInterface    $authorizer,
                                GoogleRegisterInterface         $registerManager ,
                                UserLoginServiceInterface       $userLoginService,
                                LoggerInterface                 $logger)
    {
        $this->googleAuthenticator         = $authenticator;
        $this->googleAuthorizer            = $authorizer;
        $this->googleRegisterManager       = $registerManager;
        $this->FOSUserLoginService         = $userLoginService;
        $this->logger                      = $logger;
    }

    public function loginUser(Request $request)
    {
        $authenticatedUser = $this->googleAuthenticator->authenticateUser($request);

        try {
            $user = $this->googleAuthorizer->authorizeUser($authenticatedUser);
        } catch (FailureAuthorizedException $e) {
            if ( ! $this->googleRegisterManager->isUserAllowedToRegisterAutomatically($authenticatedUser)) {
                $this->logger->addAlert("User authorization failed ");

                throw new FailureAuthorizedException("XSolve Google Auth couldn't authorize user. User's domain is not allowed");
            }
            $this->googleRegisterManager->registerUser($authenticatedUser);
            $user = $authenticatedUser;
        } catch (NotAuthorizedException $e) {
            $this->logger->addInfo("User try to sign in");

            throw $e;
        }

        $user = $this->FOSUserLoginService->login($user);
        $this->logger->addInfo(sprintf("User %s singed in", $user->getUsername()));

        return $user;
    }
}
