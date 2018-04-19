<?php

namespace FikenSDK\Exceptions;

use Exception;

class MissingRequiredPropertyException extends Exception
{
    public function __construct($class, array $properties)
    {
        parent::__construct(
            'The class \'' . $class . '\' is missing the following required properties: '
            . implode(', ', $properties) . '.'
        );
    }
}