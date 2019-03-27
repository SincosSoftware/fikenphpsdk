<?php

namespace FikenSDK\Exceptions;

class HttpClientValidationException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The HTTP client is not valid, and is missing either Auth (username, password) or correct Content-Type (application/json)');
    }
}