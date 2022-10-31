<?php

namespace Study\Core;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Study\Core\Exceptions\ParameterNotFoundException;
use Study\Core\Interfaces\IConfigHandler;
use Study\Core\Interfaces\ISingleton;
use Study\Core\Traits\SingletonTrait;

class ConfigHandler implements IConfigHandler, ISingleton
{
    use SingletonTrait;

    /**
     * @var array Parameters from file
     */
    protected array $parameters = [];

    /**
     * @description Parameter array loading method
     * @param array $configs
     * @return $this
     */
    public function addConfigs(array $configs): self
    {
        $this->parameters = array_merge($this->parameters, $configs);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        $result = true;
        try {
            $this->getValue($id);
        } catch (ParameterNotFoundException) {
            $result = false;
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function get(string $id): mixed
    {
        return $this->getValue($id);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __get($name)
    {
        return $this->get(str_replace('_', '.', $name));
    }

    protected function getValue(string $id): mixed
    {
        $keys = explode('.', $id);
        $data = $this->parameters;

        while (!empty($key = array_shift($keys))) {
            if (!isset($data[$key]))
                throw new ParameterNotFoundException('Parameter not found: ' . $id);
            $data = $data[$key];
        }
        return $data;
    }
}
