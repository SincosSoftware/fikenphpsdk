<?php

namespace FikenSDK\Clients;

use FikenSDK\Resources\Sale;

class Sales extends ResourceClient
{
    public function createSale(Sale $sale)
    {
        return $this->post($sale->toArray());
    }

    public function attachDocument($file, $filename, $comment)
    {
        return $this->post([
            'multipart' => [
                [
                    'name' => 'SaleAttachment',
                    'contents' => [
                        'filename' => $filename,
                        'comment' => $comment,
                        'attachToPayment' => true,
                        'attachToSale' => true,
                    ]
                ],
                [
                    'name' => 'AttachmentFile',
                    'contents' => $file,
                ]
            ]
        ]);
    }
}