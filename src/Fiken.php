<?php

namespace FikenPhpSdk;


use GuzzleHttp\Client as HttpClient;


class Client
{
    protected $baseurl = 'https://fiken.no/api/v1';
    protected $client;

    public function __construct()
    {
        $this->client = new HttpClient();
    }

    public function createInvoice($options)
    {
        $uri = '/companies/' . $this->getCustomerId() . '/create-invoice-service';
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

    protected function sendRequest($method, $uri, $options)
    {
        return $this->client->request($method, $this->baseurl . $uri, $options);
    }

    public function sendInvoice($options)
    {
        $uri = '/companies/' . $this->getCustomerId() . '/document-sending-service';
        $method = 'post';

        return $this->sendRequest($method, $uri, $options);
    }
}