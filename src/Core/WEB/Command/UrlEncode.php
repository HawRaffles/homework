<?php

namespace Study\Core\WEB\Command;

use InvalidArgumentException;
use Study\Core\WEB\Interfaces\IWebCommand;
use Study\UrlCompressor\Actions\ConvertUrl;

class UrlEncode implements IWebCommand
{

    protected ConvertUrl $convertor;

    /**
     * @param ConvertUrl $convertor
     */
    public function __construct(ConvertUrl $convertor)
    {
        $this->convertor = $convertor;
    }

    public function run(string $param): string
    {
        try {
            $result = $this->convertor->encode($param);
            $result = "Код закодованого url $param - $result";
        } catch (InvalidArgumentException) {
            $result = "Невалідний url $param";
        }
        return $result;
    }
}