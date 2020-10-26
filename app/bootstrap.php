<?php

use Molle\App;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/constants.php';

return function() {
    $app = new App();
    (require __DIR__ . '/commands.php')($app);
    return $app->run();
};