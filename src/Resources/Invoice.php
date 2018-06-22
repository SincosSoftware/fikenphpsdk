<?php

namespace FikenSDK\Resources;

class Invoice extends DataObject
{
    public function types()
    {
        return [
            'issueDate' => 'string',
            'dueDate' => 'string',
            'lines' => 'array',
            'ourReference' => 'string',
            'yourReference' => 'string',
            'customer' => 'array',
            'bankAccountUrl' => 'string',
            'currency' => 'string',
            'invoiceText' => 'string',
            'cash' => 'bool',
            'paymentAccount' => 'string',
        ];
    }

    public function required()
    {
        return [
            'issueDate',
            'dueDate',
            'lines',
            'customer',
            'bankAccountUrl',
        ];
    }
}