<?php

namespace Xsolve\GoogleAuthBundle\Builder;

use GoogleApi\Client;
use Xsolve\GoogleAuthBundle\ValueObject\ConfigurationValueObject;

class GoogleClientBuilder
{
    /**
     * @var \GoogleApi\Client
     */
    protected $client;

    /**
     * @param ConfigurationValueObject $configuration
     */
    public function __construct(ConfigurationValueObject $configuration)
    {
        $this->client = $this->build($configuration);
    }

    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param ConfigurationValueObject $configuration
     * @return Client
     */
    protected function build(ConfigurationValueObject $configuration)
    {
        $client = new Client();

        $client->setApplicationName($configuration->getName());
        $client->setClientId($configuration->getClientId());
        $client->setClientSecret($configuration->getClientSecret());
        $client->setRedirectUri($configuration->getRedirectUri());
        $client->setDeveloperKey($configuration->getDevKey());
        $client->setScopes($configuration->getScopes());

        return $client;
    }
}
