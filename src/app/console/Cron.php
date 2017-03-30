<?php

namespace app\console;

use app\client\GoogleClient;
use app\model\GoogleDocument;

class Cron
{

    public function __construct()
    {
        
    }

    public function run()
    {
        $document = new GoogleDocument((new GoogleClient));
        while (TRUE) {
            
        }
    }

}
