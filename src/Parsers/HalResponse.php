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
        $data = json_decode((string) $response->getBody());

        $this->links = isset($data->_links) ? $data->_links : null;
        $this->embedded = isset($data->_embedded) ? $data->_embedded : null;

        foreach (get_object_vars($data) as $var => $value) {
            if (substr($var, 0, 1) !== '_') {
                $this->properties[$var] = $value;
            }
        }
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
}