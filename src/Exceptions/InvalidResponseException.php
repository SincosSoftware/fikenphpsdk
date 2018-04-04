<?php

namespace FikenSDK\Exceptions;

use Exception;

class InvalidResponseException extends Exception
{
    public function __construct()
    {
        parent::__construct('The response from Fiken is not JSON');
    }
}