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

    public function find(Contact $contactData)
    {
        $contact = $this->findContact($contactData);

        if (null === $contact) {
            return null;
        }

        return Contact::fromStdClass($contact);
    }

    protected function findContact(Contact $contactData)
    {
        $response = $this->search($contactData->email);

        if (null === $response->embedded) {
            return null;
        }

        $rel = $this->getRelUrl();
        $contacts = $response->embedded->$rel;

        return $this->getFirstMatch($contacts, $contactData);
    }

    protected function getFirstMatch($contacts, Contact $contactData)
    {
        $sortedContacts = $this->sortContacts($contacts);

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