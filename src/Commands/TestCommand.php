<?php

namespace Molle\Commands;

use GetOpt\GetOpt;
use Molle\Command;

class TestCommand extends Command
{
    public function handle(GetOpt $opt): int
    {
        $this->app->out('Hello world!' . PHP_EOL);
        return 0;
    }

    public function getName(): string
    {
        return 'test';
    }

    public function getShortDescription(): string
    {
        return 'Test command';
    }

    public function getDescription(): string
    {
        return 'Test command';
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