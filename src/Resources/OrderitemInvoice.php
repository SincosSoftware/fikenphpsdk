<?php

namespace FikenSDK\Resources;

class OrderitemInvoice extends DataObject
{
    public function types()
    {
        return [
            'description' => 'string',
            'quantity' => 'int',
            'netAmount' => 'int',
            'vatAmount' => 'int',
            'account' => 'string',
            'vatType' => 'string',
            'netPriceInCurrency' => 'int',
            'vatInCurrency' => 'int',
            'grossAmount' => 'int',
            'incomeAccount' => 'string',
            'unitNetAmount' => 'int',
        ];
    }

    public function required()
    {
        return [
            'netAmount',
            'vatAmount',
            'vatType',
        ];
    }
}