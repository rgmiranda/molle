<?php

namespace Molle;

use GetOpt\CommandInterface;
use GetOpt\GetOpt;

abstract class Command implements CommandInterface
{
    /**
     * @var App $app
     */
    protected $app;

    /**
     * @param App $app App de contexto
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public abstract function handle(GetOpt $opt): int;
}