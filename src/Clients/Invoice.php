<?php

namespace FikenSDK\Clients;

class Invoice extends DataObject
{
    protected $propertyTypes = [
        'issueDate' => 'string',
        'dueDate' => 'string',
        'lines' => 'string',
        'unitNetAmount' => 'int',
        'description' => 'string',
        'productUrl' => 'string',
        'url' => 'string',
        'bankAccountUrl' => 'string',
    ];
}