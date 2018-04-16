<?php

namespace FikenSDK\Clients;

class BankAccounts extends ResourceClient
{
    public function bankAccounts()
    {
        $bankAccounts = [];
        foreach ($this->getBankAccounts() as $value) {
            $bankAccounts[] = $value;
        }

        return $bankAccounts;
    }

    protected function getBankAccounts()
    {
        $rel = 'bank-accounts';
        $url = $this->getResourceUrl($rel);
        $response = $this->parseResponse($this->httpClient->get($url));

        return $response->elements($this->getRelUrl($rel));
    }
}