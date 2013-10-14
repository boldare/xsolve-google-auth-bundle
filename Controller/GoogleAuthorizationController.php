<?php

namespace Xsolve\GoogleAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
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
        $googleLoginManager      = $this->get('xsolve.google.login.manager');
        $redirectManager         = $this->get('xsolve.google.redirect.manager');

        $redirectManager->registerRequest($request);
        try {
            $googleLoginManager->loginUser($request);

            return $this->redirect($redirectManager->getSuccessRedirectUrl());
        } catch (FailureAuthorizedException $e) {

            return $this->redirect($redirectManager->getFailureAuthorizedUrl());
        } catch (NotAuthorizedException $e) {

            return $this->redirect($redirectManager->getNotAuthorizedUrl());
        }
    }

}