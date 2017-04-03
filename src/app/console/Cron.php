<?php

namespace app\console;

use app\client\SlackBot;
use app\client\GoogleDocsClient;
use app\model\GoogleDocument;

class Cron
{
    /** 
     * Actually run the cron process
     */
    public function run()
    {
        /* 
         * todo Вынести сбор клиентов и работу с ними в отельный механизм
         * Добавить вк клиент
         */
        $slack = new SlackBot();
        $googleServiceClient = new GoogleDocsClient((new \Google_Client()));
        $document = new GoogleDocument($googleServiceClient->getGoogleServiceSheetsClient());
        while (true) {
            sleep(rand(60*120, 60*240));
            $messages = $document->getContent();
            $message = $slack->selectOneMessage($messages);
            $slack->sendMessage($message);
        }
    }
}
