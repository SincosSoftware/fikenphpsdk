<?php

namespace FikenSDK;

use Exception;
use FikenSDK\Clients\ResourceClient;
use FikenSDK\Exceptions\HttpClientValidationException;
use GuzzleHttp\Client as HttpClient;

class Client
{
    protected $httpClient;
    protected $company;
    protected $resourceClients;
    protected $bankAccount;

    public function __construct($company, $bankAccount, HttpClient $client)
    {
        $this->validateHttpClient($client);
        $this->httpClient = $client;
        $this->company = $company;
        $this->bankAccount = $bankAccount;
    }

    public function __get($argument)
    {
        if (!isset($this->resourceClients[$argument])) {
            $this->resourceClients[$argument] = $this->createClient($argument);
        }

        return $this->resourceClients[$argument];
    }

    /**
     * @param $resourceName
     * @return mixed
     * @throws Exception
     */
    protected function createClient($resourceName)
    {
        $class = 'FikenSDK\\Clients\\' . ucfirst($resourceName);

        if ($this->isValidClient($class)) {
            return new $class($this->httpClient, $this->company, $this->bankAccount);
        }
    }

    /**
     * @param $class
     * @return bool
     * @throws Exception
     */
    protected function isValidClient($class)
    {
        if (!class_exists($class)) {
            throw new Exception('Class ' . $class . ' does not exist.');
        }

        if (!is_subclass_of($class, ResourceClient::class)) {
            throw new Exception('Class ' . $class . ' doesn\'t implement ' . ResourceClient::class . '.');
        }

        return true;
    }

    protected function validateHttpClient(HttpClient $client)
    {
        if (
            !isset($client->getConfig('auth')[0])
            || !isset($client->getConfig('auth')[1])
            || !isset($client->getConfig('headers')['Content-Type'])
            || $client->getConfig('headers')['Content-Type'] !== 'application/json'
        )
        {
            throw new HttpClientValidationException;
        }
    }
}
