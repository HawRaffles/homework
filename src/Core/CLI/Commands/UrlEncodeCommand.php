<?php

namespace Study\Core\CLI\Commands;

use Study\UrlCompressor\Actions\ConvertUrl;
use UfoCms\ColoredCli\CliColor;

class UrlEncodeCommand extends AbstractCommand
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

    /**
     * @inheritDoc
     */
    public function run(array $params = []): void
    {
        parent::run($params);
        $this->writer->setColor(CliColor::CYAN)
            ->writeLn('Shortcode: ' . $this->convertor->encode($params[0]));
    }

    /**
     * @inheritDoc
     */
    public static function getCommandDesc(): string
    {
        return 'Encode the url to sort code';
    }

}
