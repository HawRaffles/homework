<?php

namespace Study\Core\CLI;

use Exception;
use Study\Core\CLI\Helpers\CliParamAnalyzer;
use Study\Core\CLI\Interfaces\ICliCommand;
use Study\Core\Helpers\SingletonLogger;
use Study\Core\Interfaces\ICommandHandler;
use UfoCms\ColoredCli\CliColor;

class CommandHandler implements ICommandHandler
{
    /**
     * @var ICliCommand[]
     */
    protected array $commands = [];

    /**
     * @var ICliCommand
     */
    protected ICliCommand $defaultCommand;

    /**
     * @param ICliCommand $defaultCommand
     */
    public function __construct(ICliCommand $defaultCommand)
    {
        $this->defaultCommand = $defaultCommand;
        $this->addCommand($defaultCommand);
    }

    /**
     * @param ICliCommand $command
     * @return $this
     */
    public function addCommand(ICliCommand $command): self
    {
        $this->commands[$command::getCommandName()] = $command;
        return $this;
    }

    /**
     * @param array $params
     * @return void
     */
    public function handle(array $params = []): void
    {
        $defaultCommandName = $this->defaultCommand::getCommandName();
        $commandName = CliParamAnalyzer::getCommand() ?? $defaultCommandName;
        try {
            $service = $this->commands[$commandName] ?? $this->commands[$defaultCommandName];
            $service->run(CliParamAnalyzer::getArguments());
            SingletonLogger::info('Run command: ' . $commandName, CliParamAnalyzer::getArguments());
        } catch (Exception $e) {
            SingletonLogger::error($e->getMessage());
            CLIWriter::getInstance()->setColor(CliColor::RED)->writeLn($e->getMessage());
        }
    }
}
