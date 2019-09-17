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
            if ($strictMatch && Contact::fromStdClass($contact)->isIdentical($contactData)) {
                return $contact;
            }

            if (Contact::fromStdClass($contact)->matches($contactData)) {
                return $contact;
            }
        }

        return null;
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