<?php

namespace FikenSDK\Clients;

use FikenSDK\Resources\Sale;

class Sales extends ResourceClient
{
    public function createSale(Sale $sale)
    {
        return $this->post($sale->toArray());
    }
}