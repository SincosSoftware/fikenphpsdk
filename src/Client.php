<?php

namespace FikenPhpSdk;


use GuzzleHttp\Client as HttpClient;


class Fiken
{
    protected $baseurl = 'https://fiken.no/api/v1';
    protected $client;

    public function __construct()
    {
        $this->client = new HttpClient();
    }

    protected function sendRequest($method, $uri, $options)
    {
        return $this->client->request($method, $this->baseurl . $uri, $options);
    }

}