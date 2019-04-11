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

        if ($contact->name == $contactData->name) {
            return $contact;
        }

        return false;
    }

    protected function contactMatchesStrict($contact, Contact $contactData)
    {
        if (
            isset($contact->memberNumber) && (int) $contact->memberNumber === (int) $contactData->memberNumber
            && isset($contact->name) && $contact->name === $contactData->name
            && isset($contact->address->address1) && $contact->address->address1 === $contactData->address->address1
            && isset($contact->address->address2) && $contact->address->address2 === $contactData->address->address2
            && isset($contact->address->postalPlace) && $contact->address->postalPlace === $contactData->address->postalPlace
            && isset($contact->address->postalCode) && $contact->address->postalCode === $contactData->address->postalCode
            && isset($contact->address->country) && $contact->address->country === $contactData->address->country
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
}