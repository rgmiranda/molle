#!/usr/bin/php
<?php

if (php_sapi_name() !== 'cli') {
	exit;
}

global $argc;
global $argv;

define('APPDIR', dirname(__DIR__));

$bootstrap = require __DIR__ . '/app/bootstrap.php';

return call_user_func($bootstrap);
