<?php

namespace app\client;

use GuzzleHttp\Client;

class GoogleClient
{

    public function getDocument($url)
    {
        $client = new Client([
            'base_uri' => $url,
            'verify' => false
        ]);
        $response = $client->request('GET');
        dd($response->getBody());
    }

}
