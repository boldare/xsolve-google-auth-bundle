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
        $googleAuthConfiguration = $this->container->getParameter('xsolve_google_auth');

        try {
            $authorizationManager = $this->get('xsolve.google.authorization.manager');
            $authorizationManager->authorizateUser($request);

            return $this->redirect($this->generateUrl($googleAuthConfiguration['success_authorization_redirect_url']));
        } catch (FailureAuthorizedException $e) {

            return $this->redirect($this->generateUrl($googleAuthConfiguration['failure_authorization_redirect_url']));
        } catch (Exception $e) {

            return $this->redirect($authorizationManager->getAuthUrl());
        }
    }

}
