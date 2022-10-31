<?php

namespace Study\Core\Traits;

trait SingletonTrait
{
    protected static ?self $instance = null;

    public static function getInstance(): self
    {
        if(empty(self::$instance))
            self::$instance = new static();
        return self::$instance;
    }

    protected function __construct() {}

    protected function __clone() {}

    /**
     * @throws \Exception
     */
    public function __wakeup()
    {
        $this->accessDenied(__METHOD__);
    }

    /**
     * @throws \Exception
     */
    public function __unserialize($arrayData)
    {
        $this->accessDenied(__METHOD__);
    }

    /**
     * @throws \Exception
     */
    protected function accessDenied($methodName)
    {
        throw new \Exception('Can not call method ' . $methodName);
    }
}