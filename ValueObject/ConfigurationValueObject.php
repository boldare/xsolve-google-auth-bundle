<?php

namespace Xsolve\GoogleAuthBundle\ValueObject;

use Symfony\Component\DependencyInjection\Container;

class ConfigurationValueObject
{

    protected $name;

    protected $clientId;

    protected $clientSecret;

    protected $redirectUri;

    protected $devKey;

    protected $successAuthorizationRedirectUrl = "_welcome";

    protected $failureAuthorizationRedirectUrl = "_welcome";

    protected $autoregistration = false;

    protected $autoregistrationDomains = array();

    protected $scopes = array('email', 'profile');

    public function __construct(array $configurationOptions)
    {
        foreach ($configurationOptions as $key => $value) {
            $this->{"set" . Container::camelize($key)}($value);
        }
    }

    public function setAutoregistration($autoregistration)
    {
        $this->autoregistration = $autoregistration;
    }

    public function getAutoregistration()
    {
        return $this->autoregistration;
    }

    public function setAutoregistrationDomains($autoregistrationDomains)
    {
        $this->autoregistrationDomains = $autoregistrationDomains;
    }

    public function getAutoregistrationDomains()
    {
        return $this->autoregistrationDomains;
    }

    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function setDevKey($devKey)
    {
        $this->devKey = $devKey;
    }

    public function getDevKey()
    {
        return $this->devKey;
    }

    public function setFailureAuthorizationRedirectUrl($failureAuthorizationRedirectUrl)
    {
        $this->failureAuthorizationRedirectUrl = $failureAuthorizationRedirectUrl;
    }

    public function getFailureAuthorizationRedirectUrl()
    {
        return $this->failureAuthorizationRedirectUrl;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    public function setSuccessAuthorizationRedirectUrl($successAuthorizationRedirectUrl)
    {
        $this->successAuthorizationRedirectUrl = $successAuthorizationRedirectUrl;
    }

    public function getSuccessAuthorizationRedirectUrl()
    {
        return $this->successAuthorizationRedirectUrl;
    }

    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }

    public function getScopes()
    {
        return $this->scopes;
    }

}
