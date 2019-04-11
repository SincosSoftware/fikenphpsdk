<?php

namespace FikenSDK\Clients;

use FikenSDK\Parsers\HalResponse;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;

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

    public function __construct(Client $httpClient, $companySlug = null, $bankAccount = null)
    {
        $this->httpClient = $httpClient;
        $this->companySlug = $companySlug;
    }

    public function all()
    {
        $url = $this->getResourceUrl();
        $response = $this->parseResponse($this->httpClient->get($url));

        return $response->elements($this->getRelUrl());
    }

    public function search($query)
    {
        $url = $this->getResourceUrl('search');
        $dataOptions = [
            'body' => json_encode([
                'query' => $query,
            ]),
        ];

        $response = $this->httpClient->post($url, $dataOptions);

        return $this->parseResponse($response);
    }

    protected function post(array $body)
    {
        $response = $this->httpClient->post(
            $this->getResourceUrl(),
            [
                'body' => json_encode($body)
            ]
        );

        return $this->parseResponse($response);
    }

    protected function get()
    {
        return $this->httpClient->get($this->getResourceUrl());
    }

    protected function getResourceUrl($resource = null)
    {
        $resourceRel = $this->getRelUrl($resource);
        $links = $this->getCompanyLinks();

        return $links->$resourceRel->href;
    }

    protected function getCompanyLinks()
    {
        $company = $this->getCompany();

        return $company->_links;
    }

    protected function getCompany()
    {
        $companies = $this->getCompanies();

        foreach ($companies as $company) {
            if ($company->slug === $this->companySlug) {
                return $company;
            }
        }

        return null;
    }

    protected function getCompanies()
    {
        $companyUrl = $this->getCompaniesUrl();
        $response = $this->parseResponse($this->httpClient->get($companyUrl));
        $companiesRel = $this->getRelUrl(Companies::REL);
        $companies = $response->embedded->$companiesRel;

        return $companies;
    }

    protected function getCompaniesUrl()
    {
        $parsedResponse = $this->getLinks();
        $companiesRel = $this->getRelUrl(Companies::REL);

        return $parsedResponse->links->$companiesRel->href;
    }

    protected function parseResponse(ResponseInterface $response)
    {
        $parser = new HalResponse($response);

        return $parser;
    }

    protected function getLinks()
    {
        $response = $this->httpClient->get(self::BASE_URL);

        return $this->parseResponse($response);
    }

    protected function getRelUrl($resource = null)
    {
        $pattern = self::BASE_URL . '/rel/%s';

        if (null === $resource) {
            $resource = $this->getResourceName();
        }

        return sprintf($pattern, $resource);
    }

    protected function getResourceName()
    {
        $className = (new ReflectionClass(static::class))->getShortName();

        return strtolower($className);
    }
}