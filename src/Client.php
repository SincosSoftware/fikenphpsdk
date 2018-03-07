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

    public function __get($name, $arguments)
    {
        dd(class_exists('FikenPhpSdk\\Clients\\Customer'));
    }

    protected function sendRequest($method, $uri, $options)
    {
        return $this->client->request($method, $this->baseurl . $uri, $options);
    }

}