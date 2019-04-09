<?php

namespace FikenSDK\Clients;

use FikenSDK\Resources\JournalEntry;

class JournalEntries extends ResourceClient
{
    public function create(JournalEntry $journalEntry)
    {
        $response = $this->httpClient->post(
            $this->getUrl(),
            [
                'body' => json_encode($journalEntry->toArray())
            ]
        );

        return $this->parseResponse($response);
    }

    protected function getUrl () {
        return $this->getResourceUrl('create-general-journal-entry-service');
    }
}