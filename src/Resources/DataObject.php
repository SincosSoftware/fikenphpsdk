<?php

namespace FikenSDK\Resources;

use FikenSDK\Exceptions\InvalidPropertyException;
use FikenSDK\Exceptions\InvalidTypeException;

abstract class DataObject
{
    protected $properties = [];
    protected $propertyTypes = [];

    protected $validationMethod = [
        'string' => 'is_string',
        'bool' => 'is_bool',
        'int' => 'is_int',
    ];

    /**
     * @param array $data
     * @throws InvalidPropertyException
     */
    public function __construct(array $data)
    {
        $this->fill($data);
    }

    public function toArray()
    {
        return $this->properties;
    }

    /**
     * @param array $data
     * @throws InvalidPropertyException
     */
    protected function fill(array $data)
    {
        foreach ($data as $name => $value) {
            $this->setProperty($name, $value);
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     * @throws InvalidPropertyException
     */
    protected function setProperty($name, $value)
    {
        $setMethod = 'set' . ucfirst($name);
        if (method_exists($this, $setMethod)) {
            return $this->{$setMethod}($value);
        }

        if (!$this->isValidProperty($name)) {
            throw new InvalidPropertyException(static::class, $name);
        }

        if (!$this->isValidPropertyType($name, $value)) {
		    throw new InvalidTypeException($name, $this->propertyTypes[$name]);
        }

        $this->properties[$name] = $value;
	}

    protected function isValidProperty($name)
    {
        return isset($this->propertyTypes[$name]);
    }

    protected function isValidPropertyType($name, $value)
    {
        $method = $this->getValidationMethodForProperty($name);

        return $method($value);
    }

    protected function getValidationMethodForProperty($name)
    {
        return $this->validationMethod[$this->propertyTypes[$name]];
    }
}
