<?php

namespace Molle;

abstract class Printer
{
    /**
     * Imprime un mensaje
     * @param string $message
     */
    abstract public function out(string $message);

    /**
     * Envía una nueva línea a la salida
     */
    public function newline()
    {
        $this->out(PHP_EOL);
    }

    /**
     * Envía un mensaje al stream definido
     * @param string $message
     */
    public function display(string $message)
    {
        $this->newline();
        $this->out($message);
        $this->newline();
        $this->newline();
    }
}
