<?php

namespace FikenPhpSdk\Clients;

class Customer
{
    public function createCustomer($options)
    {
        $uri = '/companies/' . $this->getCustomerId() . '/contacts';
        $method = 'post';

        return $this->sendRequest($method, $uri, $options);
    }

    public function getCustomers($options)
    {
        $uri = '/companies/' . $this->getCustomerId() . '/contacts';
        $method = 'get';

        return $this->sendRequest($method, $uri, $options);
    }
}