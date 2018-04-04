<?php

namespace FikenSDK\Clients;

class WhoAmI extends ResourceClient
{
    public function whoAmI()
    {
        $response = $this->httpClient->get(self::BASE_URL . '/whoAmI');

        return $this->responseToArray($response);
    }
}