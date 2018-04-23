<?php

namespace FikenSDK\Resources;

class Orderitem extends DataObject
{
    public function types()
    {
        return [
            'description' => 'string',
            'netPrice' => 'int',
            'vat' => 'int',
            'account' => 'string',
            'vatType' => 'string',
            'netPriceInCurrency' => 'int',
            'vatInCurrency' => 'int'
        ];
    }

    public function required()
    {
        return [
            'netPrice',
            'vat',
            'vatType',
        ];
    }
}