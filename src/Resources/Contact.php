<?php

namespace FikenSDK\Resources;

use FikenSDK\Support\Compare;

class Contact extends DataObject
{
    public function types()
    {
        return [
            'name' => 'string',
            'email' => 'string',
            'organizationIdentifier' => 'string',
            'address' => Address::class,
            'phoneNumber' => 'string',
            'customerNumber' => 'int',
            'customer' => 'bool',
            'supplierNumber' => 'int',
            'supplier' => 'bool',
            'memberNumber' => 'numeric',
            'language' => 'string',
        ];
    }

    public function required()
    {
        return ['name'];
    }

    public function matches(DataObject $dataObject)
    {
        if (static::class !== get_class($dataObject)) {
            return false;
        }

        $diff = Compare::arrayDiffAssoc($this->toArray(), $dataObject->toArray());

        if (empty($diff)) {
            return true;
        }

        if (array_keys($diff) === ['name']) {
            return Compare::stringCompare($this->normalizeName($this->name), $this->normalizeName($dataObject->name));
        }

        return array_keys($diff) === ['customerNumber', 'memberNumber'];
    }

    protected function normalizeName($name)
    {
        $exploded = explode(' ', $name);

        return reset($exploded) . ' ' . end($exploded);
    }
}
