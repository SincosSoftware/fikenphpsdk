<?php

namespace FikenSDK\Clients;

class SaleAttachments extends ResourceClient
{
    public function attachDocument($file, $fileName, $fileComment, $fikenInvoiceNumber)
    {
        $fileBody = $this->getFileBody($file, $fileName, $fileComment);
        $url = self::getResourceUrl('sales') . '/' . $fikenInvoiceNumber . '/attachments';
        dd($url);
        $this->postSaleAttachment($url, $file, $fileBody);
    }

    protected function getFileBody($fileName, $fileComment = null)
    {
        return [
            'fileName' => $fileName,
            'attachToPayment' => false,
            'attachToSale' => true,
            'comment' => $fileComment
        ];
    }

    protected function postSaleAttachment($url, $file, array $fileBody)
    {
        $response = $this->httpClient->request('POST', $url, [
            'multipart' => [
                [
                    'name' => 'AttachmentFile',
                    'contents' => $file,
                ],
                /*[
                    'name' => 'saleAttachment',
                    'contents' => json_encode($fileBody),
                ],*/
            ]
        ]);

        dd($response);

        return $this->parseResponse($response);
    }
}