<?php

namespace FikenSDK\Clients;

class Customer extends DataObject
{
    protected $properties = [
        'name' => 'string',
        'email' => 'string',
        'address' => 'string',
        'country' => 'string',
        'postalPlace' => 'string',
        'postalCode' => 'int',
        'customer' => 'bool',
    ];

    public function createCustomer($options = null)
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