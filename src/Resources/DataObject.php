<?php

namespace FikenSDK\Resources;

use Closure;
use FikenSDK\Exceptions\InvalidPropertyException;
use FikenSDK\Exceptions\InvalidTypeException;
use FikenSDK\Exceptions\MissingRequiredPropertyException;
use stdClass;

abstract class DataObject
{
    protected $properties = [];
    protected $hiddenProperties = [];
    protected $types = [];
    protected $required = [];

    protected $validationMethod = [
        'string' => 'is_string',
        'bool' => 'is_bool',
        'int' => 'is_int',
        'array' => 'is_array',
        'numeric' => 'is_numeric',
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
        return array_map(function ($property) {
            return $property instanceof DataObject ? $property->toArray() : $property;
        }, $this->properties);
    }

    public static function fromStdClass(stdClass $object)
    {
        $properties = get_object_vars($object);

        return new static($properties);
    }

    public function __get($name)
    {
        return $this->getProperty($name);
    }

    public function required()
    {
        return [];
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
        if (substr($name, 0, 1) === '_') {
            return $this->setHiddenProperty($name, $value);
        }

        $setMethod = 'set' . ucfirst($name);
        if (method_exists($this, $setMethod)) {
            return $this->{$setMethod}($value);
        }

        if ($this->isInvalidProperty($name)) {
            throw new InvalidPropertyException(static::class, $name);
        }

        $value = $this->formatValue($name, $value);

        if ($this->isInvalidPropertyType($name, $value)) {
            throw new InvalidTypeException($name, $this->getPropertyType($name));
        }

        $this->properties[$name] = $value;
    }

    protected function setHiddenProperty($name, $value)
    {
        $this->hiddenProperties[$name] = $value;
    }

    protected function formatValue($name, $value)
    {
        $propertyType = $this->getPropertyType($name);

        if ($this->canConvertToDataObject($propertyType, $value)) {
            $value = $propertyType::fromStdClass($value);
        }

        return $value;
    }

    protected function canConvertToDataObject($propertyType, $value)
    {
        return class_exists($propertyType)
            && is_subclass_of($propertyType, DataObject::class)
            && $value instanceof stdClass;
    }

    /**
     * @param $name
     * @return mixed
     * @throws InvalidPropertyException
     */
    protected function getProperty($name)
    {
        $getMethod = 'get' . ucfirst($name);
        if (method_exists($this, $getMethod)) {
            return $this->{$getMethod}();
        }

        if ($this->isInvalidProperty($name)) {
            throw new InvalidPropertyException(static::class, $name);
        }

        return $this->properties[$name];
    }

    protected function getPropertyType($name)
    {
        return isset($this->types()[$name]) ? $this->types()[$name] : null;
    }

    protected function getHref()
    {
        return isset($this->hiddenProperties['_links']->self->href)
            ? $this->hiddenProperties['_links']->self->href
            : null;
    }

    protected function isInvalidProperty($name)
    {
        return null === $this->getPropertyType($name);
    }

    protected function isInvalidPropertyType($name, $value)
    {
        $method = $this->getValidationMethodForProperty($name);

        return ! $method($value);
    }

    protected function getValidationMethodForProperty($name)
    {
        $propertyType = $this->getPropertyType($name);

        if ($propertyType instanceof Closure) {
            return $propertyType;
        }

        if (class_exists($propertyType)) {
            return function ($value) use ($propertyType) {
                return $value instanceof $propertyType;
            };
        }

        return $this->validationMethod[$propertyType];
    }

    abstract public function types();
}
