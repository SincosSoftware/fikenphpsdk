<?php

namespace FikenSDK\Clients;

class BankAccounts extends ResourceClient
{
    public function all()
    {
        $rel = 'bank-accounts';
        $url = $this->getResourceUrl($rel);
        $response = $this->parseResponse($this->httpClient->get($url));

        return $response->elements($this->getRelUrl($rel));
    }
}