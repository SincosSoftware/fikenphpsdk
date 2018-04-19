<?php

namespace FikenSDK\Exceptions;

use Exception;

class InvalidPropertyException extends Exception
{
    public function __construct($class, $name)
    {
        parent::__construct('The class \'' . $class . '\' does not support the property ' . $name . '.');
    }
}