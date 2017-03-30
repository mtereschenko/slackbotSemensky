<?php

namespace app\model;

use app\client\GoogleClient;

class GoogleDocument
{

    private $client;
    
    public function __construct(GoogleClient $client)
    {
        $this->client = $client;
    }

}
