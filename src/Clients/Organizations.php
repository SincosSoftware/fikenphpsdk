<?php

namespace FikenSDK\Clients;

class Organizations extends ResourceClient
{
    public function all()
    {
        $response = $this->httpClient->get(self::BASE_URL . '/companies');
        $array = $this->responseToArray($response);

        $companies = [];

        foreach ($array['_embedded']['https://fiken.no/api/v1/rel/companies'] as $company){
            $companies = [[
                'companyName' => $company['name'],
                'companyNumber' => $company['organizationNumber'],
                'companySlug' => $company['slug'],
            ]];
        }

        return $companies;
    }
}