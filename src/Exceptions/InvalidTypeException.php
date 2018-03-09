<?php

namespace FikenSDK\Exceptions;

use UnexpectedValueException;

class InvalidTypeException extends UnexpectedValueException
{
    public function __construct($name, $type)
    {
        parent::__construct('Property ' . $name . ' must be of type ' . $type . '.');
    }
}