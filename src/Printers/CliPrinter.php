<?php

namespace Molle\Printers;

use Molle\Printer as BasePrinter;

class CliPrinter extends BasePrinter
{
    public function out($message)
    {
        echo $message;
    }
}
