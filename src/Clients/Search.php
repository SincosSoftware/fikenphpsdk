<?php

namespace FikenSDK\Clients;

class Search extends ResourceClient
{
    public function search($query)
    {
        $dataOptions = [
            'query' => $query,
        ];

        $response = $this->httpClient->post($this->getResourceUrl(), $dataOptions);

        return $this->parseResponse($response);
    }
}