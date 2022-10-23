<?php

namespace Study\UrlCompressor\Actions;

use InvalidArgumentException;
use Study\UrlCompressor\Helpers\SingletonLogger;
use Study\UrlCompressor\Interfaces\IUrlDecoder;
use Study\UrlCompressor\Interfaces\IUrlEncoder;

class ConvertUrl implements IUrlEncoder, IUrlDecoder
{
    private string $dataFile;
    private array $encodeData = [];
    private string $validDate;

    public function __construct(string $dataFile, string $validDate)
    {
        $this->dataFile = $dataFile;
        $this->validDate = $validDate;
        if (file_exists($this->dataFile))
            $this->encodeData = json_decode(file_get_contents($this->dataFile), true);
    }

    public function encode($url): string
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            SingletonLogger::getInstance()->getLogger()->error('Вхідний url не валідний ' . $url);
            throw new InvalidArgumentException('Невалідний URL: ' . $url);
        }
        $hash = md5($url);
        $key = substr($hash, 0, 6);
        $this->SaveData($url, $key);
        SingletonLogger::getInstance()->getLogger()->info('Закодовано url ' . $url);
        return $key;
    }

    public function decode(string $code): string
    {
        if (!isset($this->encodeData[$code])) {
            SingletonLogger::getInstance()->getLogger()->warning('Вказаний код URL-у відсутній в базі ' . $code);
            throw new InvalidArgumentException('Скорочений URL відсутній в базі!');
        }
        SingletonLogger::info('Розкодовано url ' . $this->encodeData[$code]['url']);
        return $this->encodeData[$code]['url'];
    }

    private function SaveData(string $url, string $key)
    {
        if (!in_array($url, $this->encodeData))
            $this->encodeData[$key] = ['url' => $url, 'until' => $this->validDate];

        $fileData = fopen($this->dataFile, "w+");
        flock($fileData, LOCK_EX);
        fwrite($fileData, json_encode($this->encodeData));
        fclose($fileData);
    }
}
