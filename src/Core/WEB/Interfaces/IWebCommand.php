<?php

namespace Study\Core\WEB\Interfaces;

interface IWebCommand {
    /**
     * @param string $param
     * @return string
     */
    public function run(string $param): string;
}