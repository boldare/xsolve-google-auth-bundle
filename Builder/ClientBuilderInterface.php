<?php

namespace Xsolve\GoogleAuthBundle\Builder;


use Xsolve\GoogleAuthBundle\ValueObject\ConfigurationValueObject;

interface ClientBuilderInterface
{
    public function __construct(ConfigurationValueObject $configuration);

    public function getClient();

}
