<?php

namespace Molle\Commands;

use GetOpt\GetOpt;
use Molle\Command;
use Molle\Cli\Format;

class TestCommand extends Command
{
    public function handle(GetOpt $opt): int
    {
        $this->app->out('Probando' . PHP_EOL, Format::COLOR_LIGHT_BLUE);
        return 0;
    }

    public function getName(): string
    {
        return 'test';
    }

    public function getShortDescription(): string
    {
        return 'Prueba de la aplicación';
    }

    public function getDescription(): string
    {
        return 'Comando de prueba';
    }
    
    /**
     * @inheritdoc
     */
    public function getOperands()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getOptions()
    {
        return [];
    }
}