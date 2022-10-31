<?php

namespace Study\Core\Helpers;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Study\Core\Interfaces\ISingleton;
use Study\Core\Traits\SingletonTrait;

/**
 * @method static emergency(string $message, array $context = [])
 * @method static alert(string $message, array $context = [])
 * @method static critical(string $message, array $context = [])
 * @method static error(string $message, array $context = [])
 * @method static warning(string $message, array $context = [])
 * @method static notice(string $message, array $context = [])
 * @method static info(string $message, array $context = [])
 * @method static debug(string $message, array $context = [])
 * @method static log($level, string $message, array $context = [])
 */
class SingletonLogger implements ISingleton
{
    use SingletonTrait;

    protected LoggerInterface $logger;

    public static function getInstance(LoggerInterface $logger = null): self
    {
        if (is_null(self::$instance)) {
            if (is_null($logger))
                throw new InvalidArgumentException('Logger is undefined');
            self::$instance = new static($logger);
        }
        return self::$instance;
    }

    protected function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public static function __callStatic(string $name, array $arguments = []): mixed
    {
        $logger = self::getInstance()->getLogger();
        if (!method_exists($logger, $name))
            $name = 'info';
        return call_user_func_array([$logger, $name], $arguments);
    }
}