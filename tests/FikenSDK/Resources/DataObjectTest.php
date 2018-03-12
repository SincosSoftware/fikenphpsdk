<?php

namespace Tests\FikenSDK\Resources;

use FikenSDK\Exceptions\InvalidPropertyException;
use FikenSDK\Exceptions\InvalidTypeException;
use PHPUnit\Framework\TestCase;

class DataObjectTest extends TestCase
{
    /**
     * @throws InvalidPropertyException
     */
    public function testCreation()
    {
        $carData = [
            'brand' => 'Mercedes',
            'is_diesel' => true,
            'model' => 2016
        ];

        $car = new Car($carData);

        $this->assertEquals($carData, $car->toArray());
        $this->assertTrue(is_array($car->toArray()));
    }

    public function testCreatePartial()
    {
        $carData = [
            'brand' => 'Mercedes'
        ];

        $car = new Car($carData);

        $this->assertEquals($carData, $car->toArray());
    }

    public function testCustomSetter()
    {
        $carData = [
            'numberOfDoors' => 4,
        ];

        $car = new Car($carData);
        $this->assertEquals($carData, $car->toArray());
    }

    /**
     * @param string $property
     * @param $value
     * @param string $message
     * @throws InvalidPropertyException
     * @dataProvider propertyTypeProvider
     */
    public function testInvalidPropertyTypes($property, $value, $message)
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage($message);

        new Car([
            $property => $value
        ]);
    }

    public function propertyTypeProvider()
    {
        $message = 'Property %s must be of type %s.';

        return [
            'string' => ['brand', 123, sprintf($message, 'brand', 'string')],
            'int' => ['model', 'foobar', sprintf($message, 'model', 'int')],
            'bool' => ['is_diesel', 'no', sprintf($message, 'is_diesel', 'bool')]
        ];
    }

    /**
     * @throws InvalidPropertyException
     */
    public function testUnknownProperty()
    {
        $this->expectException(InvalidPropertyException::class);
        $this->expectExceptionMessage('The class Tests\FikenSDK\Resources\Car does not support the property is_petrol.');

        new Car([
            'brand' => 'Mercedes',
            'is_diesel' => true,
            'model' => 2016,
            'is_petrol' => false
        ]);
    }
}