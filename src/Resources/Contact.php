<?php

namespace FikenSDK\Resources;

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

        if ($this->name !== $dataObject->name) {
            return $this->normalizeName($this->name) === $this->normalizeName($dataObject->name);
        }

        return false;
    }

    protected function normalizeName($name)
    {
        $exploded = explode(' ', $name);

        return $this->normalizeString(reset($exploded) . end($exploded));
    }

    protected function normalizeString($string)
    {
        return mb_strtolower(str_replace(' ', '', $string), 'UTF-8');
    }
}
