<?php

namespace app\model;

class GoogleDocument
{
    private $documentUrl;
    private $client;
    private $spreadsheetId;
    const RANGE = 'A:B';

    public function __construct(\Google_Service_Sheets $client)
    {
        $this->client = $client;
        $this->documentUrl = config('googleDocumentUrl');
        $this->spreadsheetId = config('googleSpreadsheetId');
        $this->range = 'Class Data!A2:E';
    }

    /** 
     * Getting content of google spread sheets
     * @return array
     */
    public function getContent()
    {
        $response = $this->client->spreadsheets_values->get($this->spreadsheetId, self::RANGE);
        return $response->getValues();
    }
}
