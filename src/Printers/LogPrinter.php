<?php

namespace Molle\Printers;

use Molle\Printer as BasePrinter;

class LogPrinter extends BasePrinter
{
    const LEVEL_DEBUG   = 'debug';
    const LEVEL_INFO    = 'info';
    const LEVEL_WARNING = 'warning';
    const LEVEL_ERROR   = 'error';

    /**
     * @var resource $fh
     */
    private $fh;

    public function __construct($filename)
    {
        $this->fh = fopen($filename, 'a');
    }

    public function __destruct()
    {
        fflush($this->fh);
        fclose($this->fh);
    }

    public function out($message)
    {
        fwrite($this->fh, $message);
    }

    public function log($level, $message)
    {
        $this->out(date('c') . " - $level: $message");
        $this->newline();
        fflush($this->fh);
    }
}
