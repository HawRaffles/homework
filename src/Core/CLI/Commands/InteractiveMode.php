<?php

namespace Study\Core\CLI\Commands;

use Study\UrlCompressor\Actions\ConvertUrl;
use UfoCms\ColoredCli\CliColor;

class InteractiveMode extends AbstractCommand
{
    protected ConvertUrl $convertor;

    /**
     * @param ConvertUrl $convertor
     */
    public function __construct(ConvertUrl $convertor)
    {
        parent::__construct();
        $this->convertor = $convertor;
    }

    public function run(array $params = []): void
    {
        parent::run($params);
        do {
            $inputType = readline('Оберіть тип завдання (1 - скоротити URL;  2 - відновити URL; 0 - вихід): ');
        } while (!in_array($inputType, [0,1,2]));

        switch ($inputType) {
            case 0:
                exit();
            case 1:
                $this->writer->setColor(CliColor::CYAN)
                    ->writeLn('Shortcode: ' . $this->convertor->interactiveEncode());
                break;
            case 2:
                $inputCode = readline('Введіть закодований URL: ');
                $this->writer->setColor(CliColor::CYAN)
                    ->writeLn('URL: ' . $this->convertor->decode($inputCode));
                break;
        }
    }

    public static function getCommandDesc(): string
    {
        return 'Run interactive mode';
    }
}
