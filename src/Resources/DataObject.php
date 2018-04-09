<?php

namespace FikenSDK\Resources;

use Closure;
use FikenSDK\Exceptions\InvalidPropertyException;
use FikenSDK\Exceptions\InvalidTypeException;
use FikenSDK\Exceptions\MissingRequiredPropertyException;

abstract class DataObject
{
    protected $properties = [];
    protected $types = [];
    protected $required = [];

    protected $validationMethod = [
        'string' => 'is_string',
        'bool' => 'is_bool',
        'int' => 'is_int',
        'array' => 'is_array',
    ];

    /**
     * @param array $data
     * @throws InvalidPropertyException
     */
    public function __construct(array $data)
    {
        $this->fill($data);
        $this->checkRequiredProperties();
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
     * @throws MissingRequiredPropertyException
     */
    protected function checkRequiredProperties()
    {
        $missingProperties = array_diff($this->required(), array_keys($this->properties));

        if (!empty($missingProperties)) {
            throw new MissingRequiredPropertyException(static::class, $missingProperties);
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

        if ($this->isInvalidProperty($name)) {
            throw new InvalidPropertyException(static::class, $name);
        }

        if ($this->isInvalidPropertyType($name, $value)) {
		    throw new InvalidTypeException($name, $this->types()[$name]);
        }

        $this->properties[$name] = $value;
	}

    protected function isInvalidProperty($name)
    {
        return ! isset($this->types()[$name]);
    }

    protected function isInvalidPropertyType($name, $value)
    {
        $method = $this->getValidationMethodForProperty($name);

        return ! $method($value);
    }

    protected function getValidationMethodForProperty($name)
    {
        $propertyType = $this->types()[$name];

        if ($propertyType instanceof Closure) {
            return $propertyType;
        }

        return $this->validationMethod[$propertyType];
    }

    abstract public function types();

    public function required()
    {
        return [];
    }
}
