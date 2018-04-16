<?php

namespace FikenSDK\Clients;

use FikenSDK\Resources\Product;

class Products extends ResourceClient
{
    public function findOrCreate(Product $product)
    {
        if ($doesExist = $this->searchForProduct($product)) {
            return $doesExist;
        }

        $response = $this->post($product);

        return (string)$response->getBody();
    }

    protected function searchForProduct(Product $product)
    {
        $search = $this->search($product->productNumber);
        $result = $search->elements($this->getRelUrl());

        if ($result == null) {
            return false;
        }

        return $this->doesProductMatch($product, $result);
    }

    protected function doesProductMatch(Product $product, $searchResults)
    {
        foreach ($searchResults as $result) {
            if (
                $result->name === $product->name &&
                $result->unitPrice === $product->unitPrice &&
                $result->incomeAccount === $product->incomeAccount &&
                $result->vatType === $product->vatType &&
                $result->active === $product->active &&
                $result->productNumber === $product->productNumber
            ) {
                return $result;
            }
        }

        return false;
    }
}