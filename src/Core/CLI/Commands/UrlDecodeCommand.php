<?php

namespace Study\Core\CLI\Commands;

use Study\UrlCompressor\Actions\ConvertUrl;
use UfoCms\ColoredCli\CliColor;

class UrlDecodeCommand extends AbstractCommand
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
        $this->writer->setColor(CliColor::CYAN)
            ->writeLn('URL: ' . $this->convertor->decode($params[0]));
    }

    public static function getCommandDesc(): string
    {
        return 'Decode shortcode to url';
    }
}
