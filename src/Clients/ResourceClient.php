<?php

namespace FikenSDK\Clients;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

abstract class ResourceClient
{
    const BASE_URL = 'https://fiken.no/api/v1';
    /**
     * @var Client
     */
    protected $httpClient;
    /**
     * @var string|null
     */
    protected $companySlug;

    public function __construct(Client $httpClient, $companySlug = null)
    {
        $this->httpClient = $httpClient;
        $this->companySlug = $companySlug;
    }

    protected function responseToArray(ResponseInterface $response)
    {
        return json_decode($response->getBody(), true);
    }

    public function getLinks()
    {
        $response = $this->httpClient->get(self::BASE_URL);

        return $this->responseToArray($response);
    }

    public function findLink($needle)
    {
        foreach ($this->getLinks()['_embedded'] as $companies){
            if ($companies['slug'] == $this->companySlug) {
            }
        }
        return $relLink = self::BASE_URL . '/rel/' . $needle;
    }
}