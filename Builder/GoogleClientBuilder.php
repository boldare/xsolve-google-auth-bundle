<?php

namespace Xsolve\GoogleAuthBundle\Builder;

use GoogleApi\Client;

class GoogleClientBuilder {

    /**
     * @param array $configArray
     * @return Client
     */
    public function build(array $configArray) {
        $client = new Client();

        $client->setApplicationName($configArray['name']);
        $client->setClientId($configArray['client_id']);
        $client->setClientSecret($configArray['client_secret']);
        $client->setRedirectUri($configArray['redirect_uri']);
        $client->setDeveloperKey($configArray['dev_key']);

        return $client;
    }
}
