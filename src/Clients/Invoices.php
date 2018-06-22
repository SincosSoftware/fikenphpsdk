<?php

namespace FikenSDK\Clients;

use FikenSDK\Resources\Invoice;

class Invoices extends ResourceClient
{
    public function createInvoice(Invoice $invoiceMap)
    {
        $response = $this->httpClient->post(
            $this->getUrl(),
            [
                'body' => json_encode($invoiceMap->toArray())
            ]
        );

        return $this->parseResponse($response);
    }

    protected function getUrl () {
        return $this->getResourceUrl('create-invoice-service');
    }
}