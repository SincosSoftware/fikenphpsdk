<?php

namespace FikenSDK\Clients;

use FikenSDK\Resources\Contact;

class Contacts extends ResourceClient
{
    public function firstOrCreate(Contact $contactData)
    {
        $contact = $this->findContact($contactData);
        
        return $contact ?: $this->createContact($contactData);
    }

    protected function findContact(Contact $contactData)
    {
        $query = $this->search($contactData->email);
        if (null === $query->embedded) {
            return null;
        }

        return $this->parseQuery($query, $contactData);
    }

    protected function parseQuery($query, Contact $contactData)
    {
        $sortedContacts = $this->sortedContacts($query);

        foreach ($sortedContacts as $contact){
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

    protected function createContact(Contact $contact)
    {
        $createContact = $this->post($contact->toArray());

        return $createContact;
    }

    protected function sortedContacts($query)
    {
        $rel = $this->getRelUrl();
        $contacts = $query->embedded->$rel;

        usort($contacts, function($a, $b) {
            if (isset($a->memberNumber) && ! isset($b->memberNumber)) {
                return -1;
            }

            if (! isset($a->memberNumber) && isset($b->memberNumber)) {
                return 1;
            }

            if (isset($a->memberNumber) && isset($b->memberNumber)) {
                return $a->memberNumber > $b->memberNumber ? -1 : ($a->memberNumber < $b->memberNumber ? 1 : 0);
            }

            if (isset($a->customerNumber) && ! isset($b->customerNumber)) {
                return -1;
            }

            if (! isset($a->customerNumber) && isset($b->customerNumber)) {
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