<?php

namespace Study\Core\Interfaces;

interface ICommandHandler
{
    /**
     * @param array $params
     * @return void
     */
    public function handle(array $params = []): void;
}
