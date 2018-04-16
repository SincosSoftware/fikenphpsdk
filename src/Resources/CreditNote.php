<?php

namespace FikenSDK\Resources;

class CreditNote extends DataObject
{
    public function types()
    {
        return [
            'creditNoteNumber' => 'int',
            'kid' => 'string',
            'customer' => 'string',
            'net' => 'int',
            'vat' => 'int',
            'gross' => 'int',
            'netInNok' => 'int',
            'vatInNok' => 'int',
            'grossInNok' => 'int',
            'creditNoteText' => 'string',
            'yourReference' => 'string',
            'ourReference' => 'string',
            'address' => function ($address) {
                return $address instanceof Address;
            },
            'lines' => 'array',
            'currency' => 'string',
        ];
    }

    public function required()
    {
        return [
            'customer',
            'net',
            'vat',
            'gross',
            'netInNok',
            'vatInNok',
            'grossInNok',
            'address',
            'lines',
        ];
    }
}