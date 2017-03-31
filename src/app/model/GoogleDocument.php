<?php

namespace app\model;

use app\client\GoogleClient;

class GoogleDocument
{
    private $documentUrl;
    private $client;

    public function __construct(GoogleClient $client)
    {
        $this->client = $client;
        $this->documentUrl = config('google_document_url');
    }

    public function getContent()
    {
        $this->client->getDocument($this->documentUrl);
    }
}
