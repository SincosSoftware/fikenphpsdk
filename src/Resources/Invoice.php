<?php

namespace FikenSDK\Resources;

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