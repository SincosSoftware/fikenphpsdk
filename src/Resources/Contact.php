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
            'address' => Address::class,
            'phoneNumber' => 'string',
            'customerNumber' => 'int',
            'customer' => 'bool',
            'supplierNumber' => 'int',
            'supplier' => 'bool',
            'memberNumber' => 'numeric',
            'language' => 'string',
        ];
    }

    public function required()
    {
        return ['name'];
    }
}
