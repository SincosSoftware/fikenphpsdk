<?php

namespace FikenSDK\Parsers;

use Psr\Http\Message\ResponseInterface;

class HalResponse
{
    public $links;
    public $embedded;
    public $properties;

    public function __construct(ResponseInterface $response)
    {
        $this->parse($response);
    }

    protected function parse(ResponseInterface $response)
    {
        $responseBody = json_decode((string) $response->getBody());

        empty($responseBody) ? $this->parseEmptyResponse($response) : $this->parseResponseBody($responseBody);
    }

    public function elements($name)
    {
        return isset($this->embedded->$name) ? $this->embedded->$name : null;
    }

    public function __get($name)
    {
        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    protected function parseResponseBody($responseBody)
    {
        $this->links = isset($responseBody->_links) ? $responseBody->_links : null;
        $this->embedded = isset($responseBody->_embedded) ? $responseBody->_embedded : null;

        foreach (get_object_vars($responseBody) as $var => $value) {
            if (substr($var, 0, 1) !== '_') {
                $this->properties[$var] = $value;
            }
        }
    }

    protected function parseEmptyResponse(ResponseInterface $response)
    {
        $responseLocationHeader = $response->getHeader('Location');

        if (isset($responseLocationHeader)) {
            $this->links = json_decode(json_encode([
                '_links' => [
                    'self' => [
                        'href' => $responseLocationHeader
                    ]
                ]
            ]));

            return $this;
        }

        return $response->getHeaders();
    }
}