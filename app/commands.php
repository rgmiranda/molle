<?php

use Molle\App;
use Molle\Commands\CreateCommand;
use Molle\Commands\TestCommand;

return function (App $app) {
    $app->registerCommand(TestCommand::class);
    $app->registerCommand(CreateCommand::class);
};