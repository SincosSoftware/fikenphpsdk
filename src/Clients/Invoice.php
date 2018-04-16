<?php

namespace FikenSDK\Clients;

class Invoice extends ResourceClient
{
    public function create(Invoice $invoiceMap)
    {
        return $invoiceMap;
    }
}