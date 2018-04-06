<?php

namespace FikenSDK\Resources;

class Contact extends DataObject
{
    protected $propertyTypes = [
        'name' => 'string',
        'email' => 'string',
        'address' => 'string',
        'country' => 'string',
        'postalPlace' => 'string',
        'postalCode' => 'int',
        'customer' => 'bool',
    ];
}