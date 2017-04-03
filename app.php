<?php

require __DIR__.'/vendor/autoload.php';

define('APPLICATION_NAME', 'Google Sheets API PHP Quickstart');
define('CREDENTIALS_PATH', '~/.credentials/sheets.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', './config/client_secret.json');

define('SCOPES', implode(' ', array(
  Google_Service_Sheets::SPREADSHEETS_READONLY)
));

if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}

use app\console\Cron;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('Semensky log');
$log->pushHandler(new StreamHandler(config('logPath'), Logger::WARNING));

try {
    $cron = new Cron();
    $cron->run();
} catch (\FileNotFoundException $e) {
    $log->error($e->getMessage());
} catch (\Exception $e) {
    $log->error($e->getMessage());
}