<?php

namespace FikenSDK\Resources;

class JournalEntry extends DataObject
{
    public function types()
    {
        return [
            'description' => 'string',
            'journalEntries' => 'array',
        ];
    }

    public function required()
    {
        return [
            'description',
            'journalEntries',
        ];
    }
}