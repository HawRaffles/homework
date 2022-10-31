<?php

namespace Study\Core\Interfaces;

interface ISingleton
{
    public static function getInstance(): self;
}