<?php

namespace FikenSDK\Clients;

use FikenSDK\Resources\Contact;

class Contacts extends ResourceClient
{
    protected $suppliedContact;

    public function firstOrCreate(Contact $contactData)
    {
        $search = new Search($this->httpClient);
        $query = $search->search('asbjorn@24nettbutikk.no');
        dd($query);
        
        $contact = $this->findContact($contactData);

        return $contact ?: $this->createContact($contact);
    }

    protected function findContact(Contact $contactData)
    {
        $contacts = $this->getAllContacts()->embedded;
        $rel = $this->getRelUrl();

        foreach ($contacts->$rel as $contact) {
            if ($this->contactMatches($contact, $contactData)) {
                return $contact;
            }
        }

        return null;
    }

    protected function getAllContacts()
    {
        $response = $this->httpClient->get($this->getResourceUrl());

        return $this->parseResponse($response);
    }

    protected function createContact(Contact $contact)
    {
        $createContact = $this->httpClient->post($this->getResourceUrl(), ['body' => $contact]);

        return $createContact;
    }

    protected function contactMatches($contact, Contact $contactData)
    {
        dd($contact, $contactData);
        return $contact->name == $contactData->name && $contact->email == $contactData->email;
    }
}