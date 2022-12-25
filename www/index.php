<?php

use Carbon\Carbon;
use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Study\Core\ConfigHandler;
use Study\Core\Helpers\SingletonLogger;
use Study\Core\WEB\Command\UrlDecode;
use Study\Core\WEB\Command\UrlEncode;
use Study\UrlCompressor\Actions\ConvertUrl;
use Study\UrlCompressor\Helpers\CheckUrl;

require_once __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/../parameters/config.php';
$configHandler = ConfigHandler::getInstance()->addConfigs($config);

$monoLogger = new Logger($configHandler->get('log.channel'));
$monoLogger->pushHandler(new StreamHandler($configHandler->get('log.type.error'), level::Error))
    ->pushHandler(new StreamHandler($configHandler->get('log.type.warning'), level::Warning))
    ->pushHandler(new StreamHandler($configHandler->get('log.type.info'), level::Info));
$singletonLogger = SingletonLogger::getInstance($monoLogger);
$carbon = new Carbon(new DateTime());
$urlData = new ConvertUrl($configHandler->get('datafile'), new CheckUrl(new Client(), $configHandler->get('timeout'), $configHandler->get('responses'), $configHandler->get('ua')), $carbon->addYear());

$webCommands = [
    'encode' => new UrlEncode($urlData),
    'decode' => new UrlDecode($urlData)
];

foreach ($_GET as $key => $command) {
    if (!isset($webCommands[$key])) {
        $error = "Команда $key не знайдена!";
        SingletonLogger::error($error);
        echo $error;
        continue;
    }
    echo $webCommands[$key]->run($command) . '<br>';
}
