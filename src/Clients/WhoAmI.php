<?php

namespace FikenSDK\Clients;

use GuzzleHttp\Client;

class WhoAmI extends ResourceClient
{
    public function __construct(Client $httpClient, $companySlug = null)
    {
        parent::__construct($httpClient, $companySlug);
    }

    public function whoAmI()
    {


        $response = $this->httpClient->get(self::BASE_URL . '/whoAmI');

        return $this->responseToArray($response);
    }
}