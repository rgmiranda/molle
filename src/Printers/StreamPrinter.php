<?php

namespace Molle\Printers;

use Molle\Printer as BasePrinter;

class StreamPrinter extends BasePrinter
{
    /**
     * @var resource $fh
     */
    private $fh;

    public function __construct($filename)
    {
        if (is_resource($filename)) {
            $this->fh = $filename;
        } elseif (is_string($filename)) {
            $this->fh = fopen($filename, 'w');
        } else {
            throw new \InvalidArgumentException('$filename debe ser un nombre de archivo o un recurso');
        }
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
}
