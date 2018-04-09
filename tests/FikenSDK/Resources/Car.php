<?php

namespace Tests\FikenSDK\Resources;

use Exception;
use FikenSDK\Resources\DataObject;

class Car extends DataObject
{
    public function types()
    {
        return [
            'brand' => 'string',
            'is_diesel' => 'bool',
            'model' => 'int',
            'previous_owners' => 'array',
            'drive_wheel' => function ($value) {
                return in_array($value, ['front', 'back']);
            }
        ];
    }

    public function required()
    {
        return [
            'brand',
            'model',
        ];
    }

    protected function setNumberOfDoors($number)
    {
        $number = (int) $number;

        if ($number > 5 || $number < 2) {
            throw new Exception('Number of doors must be between 2 and 5.');
        }

        $this->properties['numberOfDoors'] = $number;
    }
}