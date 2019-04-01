<?php

namespace FikenSDK\Resources;

class JournalEntryItem extends DataObject
{
    public function types()
    {
        return [
            'debit' => 'int',
            'debitAccount' => 'string',
            'debitVatCode' => 'string',
            'creditAccount' => 'string',
            'creditVatCode' => 'string',
        ];
    }

    public function required()
    {
        return [
            'debit',
        ];
    }
}