<?php
/**
 * Created by PhpStorm.
 * User: asbjorn
 * Date: 06/03/2018
 * Time: 12:38
 */

namespace FikenPhpSdk;


class Invoice
{
    public function sendInvoice($options)
    {
        $uri = '/companies/' . $this->getCustomerId() . '/document-sending-service';
        $method = 'post';

        return $this->sendRequest($method, $uri, $options);
    }

    public function createInvoice($options)
    {
        $uri = '/companies/' . $this->getCustomerId() . '/create-invoice-service';
        $method = 'post';

        return $this->sendRequest($method, $uri, $options);
    }
}