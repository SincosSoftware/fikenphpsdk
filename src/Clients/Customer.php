<?php

namespace FikenSDK\Clients;

class Customer extends ResourceClient
{
    public function test(){
        return $this->findLink('contacts');
    }

    public function getCustomer($customer){
        if ($this->customerExistsInFiken()){
            return $customer;
        }

        return $this->createCustomer();
    }

    protected function createCustomer()
    {
        $this->httpClient->post($this->findLink('contacts'));
    }

    protected function customerExistsInFiken()
    {
        $response = $this->httpClient->get(self::BASE_URL . '' . $this->findLink('contacts'));
    }
}