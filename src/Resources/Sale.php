<?php

namespace FikenSDK\Resources;

class Sale extends DataObject
{
    public function types()
    {
        return [
            'date' => 'string',
            'kind' => 'string',
            'identifier' => 'string',
            'paid' => 'bool',
            'lines' => 'array',
            'customer' => 'string',
            'currency' => 'string',
            'dueDate' => 'string',
            'kid' => 'string',
            'paymentAccount' => 'string',
            'paymentDate' => 'string',
    ];
    }

    public function required()
    {
        return [
            'date',
            'kind',
            'identifier',
            'lines',
            'customer',
        ];
    }
}