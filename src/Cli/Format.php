<?php

namespace Molle\Cli;

class Format
{
    const COLOR_DEFAULT       = 39;
    const COLOR_BLACK         = 30;
    const COLOR_RED           = 31;
    const COLOR_GREEN         = 32;
    const COLOR_YELLOW        = 33;
    const COLOR_BLUE          = 34;
    const COLOR_MAGENTA       = 35;
    const COLOR_CYAN          = 36;
    const COLOR_LIGHT_GRAY    = 37;
    const COLOR_DARK_GRAY     = 90;
    const COLOR_LIGHT_RED     = 91;
    const COLOR_LIGHT_GREEN   = 92;
    const COLOR_LIGHT_YELLOW  = 93;
    const COLOR_LIGHT_BLUE    = 94;
    const COLOR_LIGHT_MAGENTA = 95;
    const COLOR_LIGHT_CYAN    = 96;
    const COLOR_WHITE         = 97;

    public static function apply(string $message, int $format)
    {
        return "\e[{$format}m{$message}\e[0m";
    }
}