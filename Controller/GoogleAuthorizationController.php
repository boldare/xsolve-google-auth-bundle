<?php

namespace Xsolve\GoogleAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Exception;
use Xsolve\GoogleAuthBundle\Exception\NotAuthorizedException;
use Xsolve\GoogleAuthBundle\Exception\FailureAuthorizedException;

/**
 * @Route("/")
 */
class GoogleAuthorizationController extends Controller
{
    /**
     * @Route("/googleauthlogin")
     * @Route("/oauth2callback")
     * @param Request $request
     */
    public function authorizationAction(Request $request)
    {
        $googleAuthConfiguration = $this->get('xsolve.google.configuration');
        $googleAuthManager       = $this->get('xsolve.google.authentication.manager');
        $logger                  = $this->get('logger');
        $googleLoginManager      = $this->get('xsolve.google.login.manager');

        try {
            $user = $googleLoginManager->loginUser($request);
            $logger->addInfo(sprintf("User %s singed in", $user->getUsername()));

            return $this->redirect($this->generateUrl($googleAuthConfiguration->getSuccessAuthorizationRedirectUrl()));
        } catch (FailureAuthorizedException $e) {
            $logger->addAlert("User authorization failed ");

            return $this->redirect($this->generateUrl($googleAuthConfiguration->getFuilureAuthorizationRedirectUrl()));
        } catch (NotAuthorizedException $e) {
            $logger->addInfo("User try to sign in");

            return $this->redirect($googleAuthManager->getAuthUrl());
        }
    }

}
