<?php

namespace FikenSDK\Clients;

class Invoice extends DataObject
{
    protected $properties = [
        'issueDate' => 'string',
        'dueDate' => 'string',
        'lines' => 'string',
        'unitNetAmount' => 'int',
        'description' => 'string',
        'productUrl' => 'string',
        'url' => 'string',
        'bankAccountUrl' => 'string',
    ];

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