<?php

/**
 * Constantes de aplicacion
 */
defined('APPNAME') or define('APPNAME', 'peritos');
defined('APPVERSION') or define('APPVERSION', '1.0.0-beta');

/**
 * Directorios especiales
 */
defined('APPDIR') or define('APPDIR', dirname(__DIR__));
defined('APPNS') or define('APPNS', 'Molle');
defined('RESOURCEDIR') or define('RESOURCEDIR', APPDIR . '/resources');
defined('LOGSDIR') or define('LOGSDIR', APPDIR . '/logs');
defined('BUILDDIR') or define('BUILDDIR', APPDIR . '/build');
