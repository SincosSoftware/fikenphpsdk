<?php

namespace FikenSDK\Clients;

class Accounts extends ResourceClient
{
    public function allForYear()
    {
        $url = str_replace('{year}', date("Y"), $this->getResourceUrl());

        $response = $this->parseResponse($this->httpClient->get($url));

        return $response->elements($this->getRelUrl());
    }
}