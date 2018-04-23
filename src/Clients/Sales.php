<?php

namespace FikenSDK\Clients;

use FikenSDK\Resources\Sale;

class Sales extends ResourceClient
{
    public function createSale(Sale $sale)
    {
        //dd(json_encode($sale->toArray()));
        return $this->post($sale->toArray());
    }
}