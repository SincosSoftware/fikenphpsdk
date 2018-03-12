<?php

namespace Tests\FikenSDK\Resources;

use Exception;
use FikenSDK\Resources\DataObject;

class Car extends DataObject
{
    protected $propertyTypes =  [
        'brand' => 'string',
        'is_diesel' => 'bool',
        'model' => 'int'
    ];

    protected function setNumberOfDoors($number)
    {
        $number = (int) $number;

        if ($number > 5 || $number < 2) {
            throw new Exception('Number of doors must be between 2 and 5.');
        }

        $this->properties['numberOfDoors'] = $number;
    }
}