<?php

namespace FikenSDK\Clients;

use FikenSDK\Exceptions\InvalidPropertyException;
use FikenSDK\Exceptions\InvalidTypeException;

abstract class DataObject
{
    protected $validationMethod = [
        'string' => 'is_string',
        'bool' => 'is_bool',
        'int' => 'is_int',
    ];

    public function __construct(array $data)
    {
        $this->fill($data);
    }

    public function fill(array $data)
    {
        foreach ($data as $name => $value) {
            $this->setProperty($name, $value);
        }
    }

    public function __set($name, $value)
    {
        $this->setProperty($name, $value);
    }

    protected function setProperty($name, $value)
    {
        if (!$this->isValidProperty($name)) {
            throw new InvalidPropertyException(static::class, $name);
        }

        if (!$this->isValidPropertyType($name, $value)) {
		    throw new InvalidTypeException($name, $this->properties[$name]);
        }

        return $this->$name = $value;
	}

    protected function isValidProperty($name)
    {
        return isset($this->properties[$name]);
    }

    protected function isValidPropertyType($name, $value)
    {
        $method = $this->getValidationMethodForProperty($name);

        return $method($value);
    }

    protected function getValidationMethodForProperty($name)
    {
        return $this->validationMethod[$this->properties[$name]];
    }
}

