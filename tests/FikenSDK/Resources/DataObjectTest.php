<?php

namespace Tests\FikenSDK\Resources;

use FikenSDK\Exceptions\InvalidPropertyException;
use FikenSDK\Exceptions\InvalidTypeException;
use FikenSDK\Exceptions\MissingRequiredPropertyException;
use PHPUnit\Framework\TestCase;

final class DataObjectTest extends TestCase
{
    public function testCreation()
    {
        $carData = [
            'brand' => 'Saab',
            'is_diesel' => true,
            'model' => 2016,
        ];

        $car = new Car($carData);

        $this->assertEquals($carData, $car->toArray());
        $this->assertTrue(is_array($car->toArray()));
    }

    public function testCreatePartial()
    {
        $carData = [
            'brand' => 'Saab',
            'model' => 2016,
        ];

        $car = new Car($carData);

        $this->assertEquals($carData, $car->toArray());
    }

    public function testCustomSetter()
    {
        $carData = [
            'numberOfDoors' => 4,
            'model' => 2016,
            'brand' => 'Saab',
        ];

        $car = new Car($carData);
        $this->assertEquals($carData, $car->toArray());
    }

    public function testTypeValidationWithClosure()
    {
        $carData = [
            'model' => 2016,
            'brand' => 'Saab',
            'drive_wheel' => 'front',
        ];
        $car = new Car($carData);

        $this->assertEquals($carData, $car->toArray());
    }

    public function testTypeValidationFailsWithClosure()
    {
        $this->setExpectedException(InvalidTypeException::class, 'Property \'drive_wheel\' does not conform to requirements.');

        new Car([
            'model' => 2016,
            'brand' => 'Saab',
            'drive_wheel' => '4WD',
        ]);

    }

    /**
     * @dataProvider propertyTypeProvider
     */
    public function testInvalidPropertyTypes($property, $value, $message)
    {
        $this->setExpectedException(InvalidTypeException::class, $message);

        new Car([
            $property => $value
        ]);
    }

    public function propertyTypeProvider()
    {
        $message = 'Property %s must be of type %s.';

        return [
            'string' => ['brand', 123, sprintf($message, "'brand'", 'string')],
            'int' => ['model', 'foobar', sprintf($message, '\'model\'', 'int')],
            'bool' => ['is_diesel', 'no', sprintf($message, "'is_diesel'", 'bool')]
        ];
    }

    public function testUnknownProperty()
    {
        $this->setExpectedException(InvalidPropertyException::class, 'The class \'Tests\FikenSDK\Resources\Car\' does not support the property is_petrol.');

        new Car([
            'brand' => 'Saab',
            'is_diesel' => true,
            'model' => 2016,
            'is_petrol' => false,
        ]);
    }

    public function testMissingRequiredProperty()
    {
        $this->setExpectedException(MissingRequiredPropertyException::class, 'The class \'Tests\FikenSDK\Resources\Car\' is missing the following required properties: model.');

        $car = new Car([
            'brand' => 'Saab',
        ]);
    }

    public function testGettingValidProperty()
    {
        $class = new Car([
            'brand' => 'Saab',
            'model' => 2017
        ]);

        $this->assertEquals('Saab', $class->brand);
    }

    public function testGettingInvalidProperty()
    {

        $class = new Car([
            'brand' => 'Saab',
            'model' => 2017
        ]);

        $this->assertFalse('Mercedes' == $class->brand);
    }
}
