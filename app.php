<?php

require __DIR__.'/vendor/autoload.php';

use app\console\Cron;

$cron = new Cron();
$cron->run();

dd(123);
