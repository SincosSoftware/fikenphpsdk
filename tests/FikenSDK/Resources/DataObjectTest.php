<?php

namespace Tests\FikenSDK\Resources;

use FikenSDK\Exceptions\InvalidPropertyException;
use FikenSDK\Exceptions\InvalidTypeException;
use FikenSDK\Exceptions\MissingRequiredPropertyException;
use FikenSDK\Resources\Address;
use FikenSDK\Resources\Contact;
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
            'int' => ['model', 'foobar', sprintf($message, "'model'", 'int')],
            'bool' => ['is_diesel', 'no', sprintf($message, "'is_diesel'", 'bool')]
        ];
    }

    public function testUnknownProperty()
    {
        $this->setExpectedException(InvalidPropertyException::class, "The class 'Tests\FikenSDK\Resources\Car' does not support the property is_petrol.");

        new Car([
            'brand' => 'Saab',
            'is_diesel' => true,
            'model' => 2016,
            'is_petrol' => false,
        ]);
    }

    public function testMissingRequiredProperty()
    {
        $this->setExpectedException(MissingRequiredPropertyException::class, "The class 'Tests\FikenSDK\Resources\Car' is missing the following required properties: model.");

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

    public function testItentical()
    {
        $contact = new Contact([
            'name' => 'Åsbjørn Hansen',
            'email' => 'asbjorn@24nettbutikk.no',
        ]);

        $newContact = clone $contact;

        $this->assertTrue($contact->isIdentical($newContact));
    }

    public function testIdenticalComplex()
    {
        $contact = new Contact([
            'name' => 'Åsbjørn Hansen',
            'email' => 'asbjorn@24nettbutikk.no',
            'organizationIdentifier' => '123456789',
            'address' => new Address([
                'postalCode' => '7900',
                'postalPlace' => 'Rørvik',
                'address1' => 'Asdvegen 2',
                'address2' => '',
                'country' => 'Norway',
            ]),
            'phoneNumber' => '12345678',
            'customerNumber' => 999,
            'customer' => true,
            'supplierNumber' => 123,
            'supplier' => false,
            'memberNumber' => 555,
            'language' => 'Norwegian',
        ]);

        $newContact = clone $contact;

        $this->assertTrue($contact->isIdentical($newContact));
    }

    public function testNonIdentical()
    {
        $contact = new Contact([
            'name' => 'Åsbjørn Hansen',
        ]);

        $newContact = new Contact([
            'name' => 'Torkil Sinkaberg Johnsen',
        ]);

        $this->assertFalse($contact->isIdentical($newContact));
    }

    public function testNonIdenticalSubObject()
    {
        $contact = new Contact([
            'name' => 'Åsbjørn Hansen',
            'email' => 'asbjorn@24nettbutikk.no',
            'address' => new Address([
                'postalCode' => '7901',
                'postalPlace' => 'Rørvik',
                'address1' => 'Asdvegen 2',
                'address2' => '',
                'country' => 'Norway',
            ]),
        ]);

        $newContact = new Contact([
            'name' => 'Åsbjørn Hansen',
            'email' => 'asbjorn@24nettbutikk.no',
            'address' => new Address([
                'postalCode' => '8001',
                'postalPlace' => 'Bodø',
                'address1' => 'Storgata 2',
                'address2' => '',
                'country' => 'Norway',
            ]),
        ]);

        $this->assertFalse($contact->isIdentical($newContact));
    }

    public function testMatchesIdentical()
    {
        $contact = new Contact([
            'name' => 'Åsbjørn Hansen',
            'email' => 'asbjorn@24nettbutikk.no',
        ]);

        $newContact = clone $contact;

        $this->assertTrue($contact->matches($newContact));
    }

    public function testMatches()
    {
        $subject = new Car([
            'brand' => 'Kia',
            'model' => 2016
        ]);

        $newSubject = new Car([
            'brand' => 'Kia',
            'model' => 2016,
            'is_diesel' => true
        ]);

        $this->assertTrue($subject->matches($newSubject));
        $this->assertFalse($newSubject->matches($subject));
    }

    public function testMatchesComplex()
    {
        $subject = new Car([
            'brand' => 'Kia',
            'is_diesel' => false,
            'model' => 2016,
            'previous_owners' => ['Åsbjørn Hansen'],
            'drive_wheel' => 'front'
        ]);

        $newSubject = new Car([
            'brand' => 'Kia',
            'is_diesel' => false,
            'model' => 2016,
            'previous_owners' => ['Åsbjørn Hansen', 'En annen person'],
            'drive_wheel' => 'front'
        ]);

        $this->assertTrue($subject->matches($newSubject));
        $this->assertFalse($newSubject->matches($subject));
    }

    public function testMatchesWithSemiIdenticalName()
    {
        $contact = new Contact([
            'name' => 'Åsbjørn Hansen',
            'email' => 'asbjorn@24nettbutikk.no',
        ]);

        $newContact = new Contact([
            'name' => 'Åsbjørn WohooO! Hansen',
            'email' => 'asbjorn@24nettbutikk.no',
        ]);

        $fooContact = new Contact([
            'name' => 'WohooO! Åsbjørn Hansen',
            'email' => 'asbjorn@24nettbutikk.no',
        ]);

        $this->assertTrue($contact->matches($newContact));
        $this->assertfalse($contact->matches($fooContact));
    }
}
