<?php

namespace FikenSDK\Resources;

class Product extends DataObject
{
    public function types()
    {
        return [
            'name' => 'string',
            'unitPrice' => 'int',
            'incomeAccount' => 'string',
            'vatType' => 'string',
            'active' => 'bool',
            'productNumber' => 'string',
        ];
    }

    public function required()
    {
        return [
            'name',
            'incomeAccount',
            'vatType',
            'active',
        ];
    }
}