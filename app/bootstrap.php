<?php

require 'vendor/autoload.php';

use Molle\App;

define('APPNAME', 'molle');
define('APPVERSION', '1.0.0-beta');

return function() {
    $app = new App();
    (require __DIR__ . '/commands.php')($app);
    return $app->run();
};