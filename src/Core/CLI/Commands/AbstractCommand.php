<?php

namespace Study\Core\CLI\Commands;

use Study\Core\CLI\CLIWriter;
use Study\Core\CLI\Helpers\CliParamAnalyzer;
use Study\Core\CLI\Interfaces\ICliCommand;
use Study\Core\Interfaces\IWriter;
use UfoCms\ColoredCli\CliColor;

abstract class AbstractCommand implements ICliCommand
{
    const NAME = 'undefined';

    protected array $params = [];

    protected IWriter $writer;

    public function __construct()
    {
        $this->writer = CLIWriter::getInstance();
    }

    /**
     * @inheritDoc
     */
    public static function getCommandName(): string
    {
        $name = static::NAME;
        if (static::NAME === self::NAME) {
            $path = explode('\\', static::class);
            $classCommandName = str_replace('Command', '', array_pop($path));
            $name = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $classCommandName));
        }
        return $name;
    }

    /**
     * @inheritDoc
     */
    public static function getCommandDesc(): string
    {
        return '';
    }

    protected function printHeader(): void
    {
        $this->writer->setColor(CliColor::YELLOW)->writeBorder()
            ->writeLn(static::getCommandName())
            ->writeLn(static::getCommandDesc())
            ->writeBorder();
    }

    public function run(array $params = []): void
    {
        $this->params = $params;
        if (CliParamAnalyzer::isVerbose()) {
            $this->printHeader();
        }
    }
}
