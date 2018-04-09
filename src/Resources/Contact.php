<?php

namespace FikenSDK\Resources;

class Contact extends DataObject
{
    public function types()
    {
        return [
            'name' => 'string',
            'email' => 'string',
            'organizationIdentifier' => 'string',
            'address' => function ($address) {
                return $address instanceof Address;
            },
            'phoneNumber' => 'string',
            'customerNumber' => 'int',
            'customer' => 'bool',
            'supplierNumber' => 'int',
            'supplier' => 'bool',
            'memberNumber' => 'int',
            'language' => 'string',
        ];
    }

    public function required()
    {
        return ['name'];
    }
}
