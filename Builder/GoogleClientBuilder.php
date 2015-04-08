<?php

namespace Xsolve\GoogleAuthBundle\Builder;

use Xsolve\GoogleAuthBundle\Builder\ClientBuilderInterface;
use Xsolve\GoogleAuthBundle\ValueObject\ConfigurationValueObject;

class GoogleClientBuilder implements ClientBuilderInterface
{
    /**
     * @var \Google_Client
     */
    protected $client;

    /**
     * @param ConfigurationValueObject $configuration
     */
    public function __construct(ConfigurationValueObject $configuration)
    {
        $this->client = $this->build($configuration);
    }

    /**
     * {@inheritDoc}
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param ConfigurationValueObject $configuration
     * @return \Google_Client
     */
    protected function build(ConfigurationValueObject $configuration)
    {
        $client = new \Google_Client();

        $client->setApplicationName($configuration->getName());
        $client->setClientId($configuration->getClientId());
        $client->setClientSecret($configuration->getClientSecret());
        $client->setRedirectUri($configuration->getRedirectUri());
        $client->setDeveloperKey($configuration->getDevKey());
        $client->setScopes($configuration->getScopes());

        return $client;
    }
}
