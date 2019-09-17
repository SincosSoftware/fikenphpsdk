<?php

namespace FikenSDK\Clients;

class WhoAmI extends ResourceClient
{
    const REL = '/whoAmI';

    public function getLoggedInUser()
    {
        $response = $this->httpClient->get(self::BASE_URL . self::REL);

        return $this->parseResponse($response);
    }
}