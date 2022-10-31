<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Carbon\Carbon;
use Study\Core\CLI\CLIWriter;
use Study\Core\CLI\CommandHandler;
use Study\Core\CLI\Commands\InteractiveMode;
use Study\Core\CLI\Commands\TestCommand;
use Study\Core\CLI\Commands\UrlDecodeCommand;
use Study\Core\CLI\Commands\UrlEncodeCommand;
use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Study\Core\ConfigHandler;
use Study\Core\Helpers\SingletonLogger;
use Study\UrlCompressor\Actions\ConvertUrl;
use Study\UrlCompressor\Helpers\CheckUrl;

$config = require_once __DIR__ . '/../../parameters/config.php';
$configHandler = ConfigHandler::getInstance()->addConfigs($config);

$monoLogger = new Logger($configHandler->get('log.channel'));
$monoLogger->pushHandler(new StreamHandler($configHandler->get('log.type.error'), level::Error))
    ->pushHandler(new StreamHandler($configHandler->get('log.type.warning'), level::Warning))
    ->pushHandler(new StreamHandler($configHandler->get('log.type.info'), level::Info));
$singletonLogger = SingletonLogger::getInstance($monoLogger);

$carbon = new Carbon(new DateTime());

$urlData = new ConvertUrl($configHandler->get('datafile'), new CheckUrl(new Client(), $configHandler->get('timeout'), $configHandler->get('responses'), $configHandler->get('ua')), $carbon->addYear());
$commandHandler = new CommandHandler(new TestCommand());
$commandHandler->addCommand(new InteractiveMode($urlData));
$commandHandler->addCommand(new UrlEncodeCommand($urlData));
$commandHandler->addCommand(new UrlDecodeCommand($urlData));

$commandHandler->handle($argv);

echo PHP_EOL;
