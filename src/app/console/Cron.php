<?php

namespace app\console;

use app\client\GoogleClient;
use app\client\SlackBot;
use app\model\GoogleDocument;

class Cron
{

    public function __construct()
    {
        
    }

    public function run()
    {
        $slack = new SlackBot();
//        $document = new GoogleDocument((new GoogleClient));
//        $document->getContent();
        while (TRUE) {
            $message = $slack->getMessage();
//            d($message);
            $slack->sendMessage($message);
//            sleep(1);
            sleep(rand(4, 10));
        }
    }

}
