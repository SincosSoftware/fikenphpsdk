<?php

namespace FikenSDK\Resources;

class Invoice extends DataObject
{
    public function types()
    {
        return [
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
}