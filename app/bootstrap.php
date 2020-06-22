<?php

require 'vendor/autoload.php';

use Molle\App;

define('MOLLEDIR', dirname(__DIR__));

defined('APPDIR') or define('APPDIR', dirname(__DIR__));
defined('APPNAME') or define('APPNAME', 'molle');
defined('APPVERSION') or define('APPVERSION', '1.0.0-beta');

return function() {
    $app = new App();
    (require __DIR__ . '/commands.php')($app);
    return $app->run();
};