<?php

namespace app\console;

use app\client\SlackBot;

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
        while (true) {
            $message = $slack->getMessage();
//            d($message);
            $slack->sendMessage($message);
//            sleep(1);
            sleep(rand(4, 10));
        }
    }
}
