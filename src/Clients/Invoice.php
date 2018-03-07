<?php

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