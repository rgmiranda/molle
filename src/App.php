<?php

namespace Molle;

use GetOpt\ArgumentException;
use GetOpt\ArgumentException\Missing;
use GetOpt\GetOpt;
use GetOpt\Option;
use InvalidArgumentException;
use Molle\Printers\CliPrinter;
use Molle\Printers\LogPrinter;
use Molle\Printers\StreamPrinter;
use ReflectionClass;

class App
{
    /**
     * @var CliPrinter $stdOut
     */
    protected $stdOut;

    /**
     * @var StreamPrinter $stdErr
     */
    protected $stdErr;

    /**
     * @var LogPrinter $logger
     */
    protected $logger;

    /**
     * @var string $appName Nombre de la aplicación inferido del comando raíz
     */
    protected $appName;

    /**
     * @var GetOpt $getOpt
     */
    protected $getOpt;


    public function __construct()
    {
        $this->stdOut = new CliPrinter;
        $this->stdErr = new StreamPrinter(STDERR ??'php://stderr');
        $logFile = dirname(__DIR__) . '/logs/' . date('\l\o\g\_Ymd');
        $this->logger = new LogPrinter($logFile);

        $this->getOpt = new GetOpt();
        $this->getOpt->addOptions([
            Option::create('v', 'version', GetOpt::NO_ARGUMENT)
                ->setDescription('Muestra la información de la versión y sale'),

            Option::create('h', 'help', GetOpt::NO_ARGUMENT)
                ->setDescription('Muestra este texto y finaliza'),
        ]);

    }

    /**
     * @return string Nombre del comando raíz
     */
    public function getAppName()
    {
        return $this->appName;
    }

    /**
     * Reads some input from the user
     * @param string $message Prompt message
     */
    public function prompt(string $message = NULL) {
        $this->stdOut->out($message);
        return fgets(STDIN);
    }

    /**
     * @param string $message Mensaje a mostrar
     * @param int $format Formato a aplicar al texto basado en las constantes `CliPrinter::COLOR_*`
     */
    public function out(string $message)
    {
        $this->stdOut->out($message);
    }

    /**
     * @param string $message Mensaje a enviar
     */
    public function error(string $message)
    {
        $this->stdErr->out($message);
    }

    /**
     * @param string $level Nivel del registro
     * @param string $message Mensaje a registrar
     */
    public function log(string $level, string $message)
    {
        $this->logger->log($level, $message);
    }

    public function registerCommand($command)
    {
        if ($command instanceof Command) {
            $this->getOpt->addCommand($command);
        } elseif (is_string($command)) {
            $class = new ReflectionClass($command);
            if (!$class->isSubclassOf(Command::class)) {
                throw new InvalidArgumentException('La clase debe ser una subclave de Command');
            }
            $command = $class->newInstance($this);
            $this->getOpt->addCommand($command);
        } else {
            throw new InvalidArgumentException('Se ha recibido un tipo de comando no válido');
        }
    }

    public function run()
    {
        try {
            try {
                $this->getOpt->process();
            } catch (Missing $exception) {
                // catch missing exceptions if help is requested
                if (!$this->getOpt->getOption('help')) {
                    throw $exception;
                }
            }
        } catch (ArgumentException $exception) {
            file_put_contents('php://stderr', $exception->getMessage() . PHP_EOL);
            echo PHP_EOL . $this->getOpt->getHelpText();
            exit;
        }

        // show version and quit
        if ($this->getOpt->getOption('version')) {
            echo sprintf('%s: %s' . PHP_EOL, APPNAME, APPVERSION);
            exit;
        }

        // show help and quit
        $command = $this->getOpt->getCommand();
        if (!$command || $this->getOpt->getOption('help')) {
            echo $this->getOpt->getHelpText();
            exit;
        }

        // call the requested command
        return call_user_func([$command, 'handle'], $this->getOpt);
    }    
}