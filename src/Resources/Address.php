<?php

namespace FikenSDK\Resources;

class Address extends DataObject
{
    public function types()
    {
        return [
            'postalCode' => 'string',
            'postalPlace' => 'string',
            'address1' => 'string',
            'address2' => 'string',
            'country' => 'string',
        ];
    }
}