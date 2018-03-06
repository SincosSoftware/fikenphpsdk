<?php
/**
 * Created by PhpStorm.
 * User: asbjorn
 * Date: 06/03/2018
 * Time: 12:36
 */

namespace FikenPhpSdk;


class Customer
{
    public function createCustomer($options)
    {
        $uri = '/companies/' . $this->getCustomerId() . '/contacts';
        $method = 'post';

        return $this->sendRequest($method, $uri, $options);
    }

    public function getCustomerId()
    {
        $uri = '/companies';
        $method = 'post';

        $response = $this->sendRequest($method, $uri);

        return $response;
    }

    public function getCustomers($options)
    {
        $uri = '/companies/' . $this->getCustomerId() . '/contacts';
        $method = 'get';

        return $this->sendRequest($method, $uri, $options);
    }
}