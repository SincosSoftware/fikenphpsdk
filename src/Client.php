<?php

namespace FikenSDK;

use GuzzleHttp\ClientInterface as HttpClientInterface;

class Client
{
    protected $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function __get($argument)
    {
        $class = 'FikenSDK\\Clients\\' . ucfirst($argument);

        if (class_exists($class)) {
            return new $class($this->httpClient);
        }
    }
}