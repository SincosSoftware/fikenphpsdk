<?php

namespace FikenSDK\Exceptions;

use Closure;
use UnexpectedValueException;

class InvalidTypeException extends UnexpectedValueException
{
    public function __construct($name, $type)
    {
        if ($type instanceof Closure) {
            return parent::__construct('Property ' . $name . ' does not conform to requirements.');
        }

        parent::__construct('Property ' . $name . ' must be of type ' . $type . '.');
    }
}