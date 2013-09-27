<?php

namespace Xsolve\GoogleAuthBundle\Service;

use GoogleApi\Client;
use GoogleApi\Contrib\apiOauth2Service;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Security\LoginManager;
use Xsolve\GoogleAuthBundle\Exception\NotAuthorizedException;
use Xsolve\GoogleAuthBundle\Exception\FailureAuthorizedException;
use Xsolve\GoogleAuthBundle\Builder\FOSUserBuilder;
use Xsolve\GoogleAuthBundle\Builder\GoogleClientBuilder;

class GoogleAuthorizationManager
{
    /**
     * @var \FOS\UserBundle\Doctrine\UserManager
     */
    protected $userManager;

    /**
     * @var \FOS\UserBundle\Security\LoginManager
     */
    private $fosLoginManager;

    /**
     * @var string
     */
    private $providerKey;
    
    /**
     *
     * @var array
     * @example array(
     *    client_id,
     *    client_secret,
     *    redirect_uri,
     *    dev_key );
     */
    private $configArray;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param EntityManager $em
     * @param LoginManager $fosLoginManager
     * @param array $configArray
     * @param $providerKey
     */
    public function __construct(UserManager $userManager, LoginManager $fosLoginManager, array $configArray, $providerKey)
    {
        $this->userManager = $userManager;
        $this->fosLoginManager = $fosLoginManager;
        $this->configArray = $configArray;
        $this->providerKey = $providerKey;

        $googleClientBuilder = new GoogleClientBuilder();
        $this->client = $googleClientBuilder->build($this->configArray);
    }

    public function authorizateUser(Request $request) 
    {
        $oauth2 = new apiOauth2Service($this->getClient());

        if (!$request->get('code')) {

            throw new NotAuthorizedException("There's missing authorization code");
        }

        $this->getClient()->authenticate();
        $googleUser = $oauth2->userinfo->get();
        $user = $this->userManager->findUserByEmail($googleUser['email']);

        if (null == $user) {
            if ( ! $this->configArray['autoregistration']) {

                throw new FailureAuthorizedException();
            }

            $FOSUserBuilder = new FOSUserBuilder($this->userManager);
            $user = $FOSUserBuilder->build($googleUser);

            $availableDomains = $this->configArray['autoregistration_domains'];

            if (count($availableDomains) > 0 && !in_array(substr($user->getEmail(), strpos($user->getEmail(),'@')+1), $availableDomains)) {

                throw new FailureAuthorizedException("XSolve Google Auth couldn't authorize user. User's domain is not allowed");
            }

        }
        $user->setLastLogin(new \DateTime());
        $this->userManager->updateUser($user);

        $this->fosLoginManager->loginUser($this->providerKey, $user);
    }

    public function getAuthUrl()
    {
        $url = $this->getClient()->createAuthUrl();

        return preg_replace('/&approval_prompt=force/', '', $url);
    }

    protected function getClient()
    {
        return $this->client;
    }

}
