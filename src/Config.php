<?php

namespace Molle;

use ArrayAccess;
use Exception;

class Config implements ArrayAccess
{

    /**
     * @var array
     */
    private $config;

    /**
     * @var Config
     */
    private static $INSTANCE = NULL;

    /**
     * Método para el Singleton
     * @param string $key
     * @return Config
     */
    public static function getItem(string $key)
    {
        if (self::$INSTANCE === NULL) {
            self::$INSTANCE = new Config;
        }
        return self::$INSTANCE[$key];
    }

    /**
     * Método para el Singleton
     * @return Config
     */
    public static function getInstance()
    {
        if (self::$INSTANCE === NULL) {
            self::$INSTANCE = new Config;
        }
        return self::$INSTANCE;
    }

    private function __construct()
    {
        $inifile = APPDIR . '/config.ini';
        if (!file_exists($inifile)) {
            throw new Exception('No se ha encontrado el archivo INI de configuración');
        }
        $this->config = parse_ini_file($inifile, TRUE);
    }

    /*
     * +-----------------------------------------------------------------------+
     * |    ArrayAccess                                                        |
     * +-----------------------------------------------------------------------+
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->config[] = $value;
        } else {
            $this->config[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->config[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->config[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->config[$offset]) ? $this->config[$offset] : null;
    }
}