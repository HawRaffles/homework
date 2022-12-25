<?php

namespace Study\Core\WEB\Command;

use InvalidArgumentException;
use Study\Core\WEB\Interfaces\IWebCommand;
use Study\UrlCompressor\Actions\ConvertUrl;

class UrlDecode implements IWebCommand
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
            $result = $this->convertor->decode($param);
            $result = "Розкодований по коду $param url - $result";
        } catch (InvalidArgumentException) {
            $result = "Код $param не знайдено в базі данних ресурсу!";
        }
        return $result;
    }
}