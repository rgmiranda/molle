<?php

namespace Molle\Db;

use InvalidArgumentException;
use PDO;
use Molle\Config;

class PDOFactory
{

    /**
     * @var PDOFactory $_INSTANCE
     */
    private static $_INSTANCE = NULL;

    /**
     * @var PDO[] $_INSTANCES
     */
    private $_INSTANCES = array();

    /**
     * @var Config $config
     */
    private $config;

    private function __construct() {
        $this->config = Config::getInstance();
    }

    /**
     * @return PDOFactory
     */
    public static function getInstance() : PDOFactory {
        if (empty(self::$_INSTANCE)) {
            self::$_INSTANCE = new PDOFactory();
        }
        return self::$_INSTANCE;
    }

    /**
     * Crea una instancia PDO para un grupo
     * @param string $cnnName
     * @return PDO
     */
    public static function connect(string $cnnName): PDO
    {
        $self = self::getInstance();
        $cnnConfig = $self->config['db.' . $cnnName];
        if (empty($cnnConfig)) {
            throw new InvalidArgumentException('No se ha podido encontrar la configuración de las conexiones de datos');
        }
        if (!isset($self->_INSTANCES[$cnnName])) {
            $self->_INSTANCES[$cnnName] = new PDO($cnnConfig['dsn'], $cnnConfig['username'], $cnnConfig['password']);
            $self->_INSTANCES[$cnnName]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $self->_INSTANCES[$cnnName];
    }
}
