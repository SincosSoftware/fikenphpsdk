<?php

namespace FikenSDK\Clients;

use FikenSDK\Resources\Contact;

class Contacts extends ResourceClient
{
    public function create(Contact $contact)
    {
        $response = $this->post($contact->toArray());

        return $response;
    }

    public function find(Contact $contactData, $strictMatch)
    {
        $contact = $this->findContact($contactData, $strictMatch);

        if (null === $contact) {
            return null;
        }

        return Contact::fromStdClass($contact);
    }

    protected function findContact(Contact $contactData, $strictMatch)
    {
        $response = $this->search($contactData->email);

        if (null === $response->embedded) {
            return null;
        }

        $rel = $this->getRelUrl();
        $contacts = $response->embedded->$rel;

        return $this->getFirstMatch($contacts, $contactData, $strictMatch);
    }

    protected function getFirstMatch($contacts, Contact $contactData, $strictMatch)
    {
        $sortedContacts = $this->sortContacts($contacts);

        foreach ($sortedContacts as $contact){
            if ($strictMatch && $this->contactMatchesStrict($contact, $contactData)) {
                return $contact;
            }

            if ($this->contactMatches($contact, $contactData)) {
                return $contact;
            }
        }

        return null;
    }

    protected function contactMatches($contact, Contact $contactData)
    {
        if (isset($contact->memberNumber) && (int) $contact->memberNumber === (int) $contactData->memberNumber) {
            return $contact;
        }

        if ($this->normalizeName($contact->name) === $this->normalizeName($contactData->name)) {
            return $contact;
        }

        return false;
    }

    protected function contactMatchesStrict($contact, Contact $contactData)
    {
        if (
            isset($contact->name) && $this->normalizeName($contact->name) === $this->normalizeName($contactData->name)
            && isset($contact->address->address1) && $this->normalizeString($contact->address->address1) === $this->normalizeString($contactData->address->address1)
            && isset($contact->address->address2) && $this->normalizeString($contact->address->address2) === $this->normalizeString($contactData->address->address2)
            && isset($contact->address->postalPlace) && $this->normalizeString($contact->address->postalPlace) === $this->normalizeString($contactData->address->postalPlace)
            && isset($contact->address->postalCode) && (int) $contact->address->postalCode === (int) $contactData->address->postalCode
            && isset($contact->address->country) && $this->normalizeString($contact->address->country) === $this->normalizeString($contactData->address->country)
        ) {
            return $contact;
        }

        return false;
    }

    protected function sortContacts($contacts)
    {
        usort($contacts, function($a, $b) {
            if (isset($a->memberNumber) && !isset($b->memberNumber)) {
                return -1;
            }

            if (!isset($a->memberNumber) && isset($b->memberNumber)) {
                return 1;
            }

            if (isset($a->memberNumber) && isset($b->memberNumber)) {
                return $a->memberNumber > $b->memberNumber ? -1 : ($a->memberNumber < $b->memberNumber ? 1 : 0);
            }

            if (isset($a->customerNumber) && !isset($b->customerNumber)) {
                return -1;
            }

            if (!isset($a->customerNumber) && isset($b->customerNumber)) {
                return 1;
            }

            if (isset($a->customerNumber) && isset($b->customerNumber)) {
                return $a->customerNumber > $b->customerNumber ? -1 : ($a->customerNumber < $b->customerNumber ? 1 : 0);
            }

            return 0;
        });

        return $contacts;
    }

    protected function normalizeName($name)
    {
        $exploded = explode(' ', $name);

        return mb_strtolower(reset($exploded) . end($exploded), 'UTF-8');
    }

    protected function normalizeString($string)
    {
        return mb_strtolower(str_replace(' ', '', $string), 'UTF_8');
    }
}