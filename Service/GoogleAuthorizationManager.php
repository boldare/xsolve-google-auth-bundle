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
use Xsolve\GoogleAuthBundle\ValueObject\ConfigurationValueObject;

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
     * @var \Xsolve\GoogleAuthBundle\ValueObject\ConfigurationValueObject
     */
    private $configuration;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param EntityManager $em
     * @param LoginManager $fosLoginManager
     * @param ConfigurationValueObject $configArray
     * @param $providerKey
     */
    public function __construct(UserManager $userManager,
                                LoginManager $fosLoginManager,
                                GoogleClientBuilder $googleClientBuilder,
                                ConfigurationValueObject $configuration,
                                $providerKey)
    {
        $this->userManager      = $userManager;
        $this->fosLoginManager  = $fosLoginManager;
        $this->configuration    = $configuration;
        $this->providerKey      = $providerKey;
        $this->client           = $googleClientBuilder->getClient();
    }

    /**
     * @param Request $request
     * @return \FOS\UserBundle\Model\UserInterface
     * @throws \Xsolve\GoogleAuthBundle\Exception\NotAuthorizedException
     * @throws \Xsolve\GoogleAuthBundle\Exception\FailureAuthorizedException
     */
    public function authorizeUser(Request $request)
    {
        $oauth2 = new apiOauth2Service($this->getClient());

        if (!$request->get('code')) {

            throw new NotAuthorizedException("There's missing authorization code");
        }

        $this->getClient()->authenticate();
        $googleUser = $oauth2->userinfo->get();
        $user = $this->userManager->findUserByEmail($googleUser['email']);

        if (null == $user) {
            if ( ! $this->configuration->getAutoregistration()) {

                throw new FailureAuthorizedException();
            }

            $FOSUserBuilder   = new FOSUserBuilder($this->userManager);
            $user             = $FOSUserBuilder->build($googleUser);
            $availableDomains = $this->configuration->getAutoregistrationDomains();

            if (count($availableDomains) > 0 && !in_array(substr($user->getEmail(), strpos($user->getEmail(),'@')+1), $availableDomains)) {

                throw new FailureAuthorizedException("XSolve Google Auth couldn't authorize user. User's domain is not allowed");
            }
        }
        $user->setLastLogin(new \DateTime());
        $this->userManager->updateUser($user);

        $this->fosLoginManager->loginUser($this->providerKey, $user);

        return $user;
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
