<?php

namespace FikenSDK\Resources;

class SaleAttachment extends DataObject
{
    public function types()
    {
        return [
            'filename' => 'string',
            'comment' => 'string',
            'attachToPayment' => 'bool',
            'attachToSale' => 'bool',
        ];
    }

    public function required()
    {
        return [
            'filename',
            'attachToPayment',
            'attachToSale',
        ];
    }
}