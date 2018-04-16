<?php

namespace FikenSDK\Clients;

use FikenSDK\Resources\CreditNote;

class CreditNotes extends ResourceClient
{
    public function createCreditNote(CreditNote $creditNote)
    {
        return $this->post($creditNote->toArray());
    }
}