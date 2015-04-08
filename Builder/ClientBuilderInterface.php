<?php

namespace Xsolve\GoogleAuthBundle\Builder;

interface ClientBuilderInterface
{
    /**
     * @return \Google_Client
     */
    public function getClient();

}
