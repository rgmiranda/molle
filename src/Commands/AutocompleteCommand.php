<?php

namespace Molle\Commands;

use GetOpt\GetOpt;
use GetOpt\Operand;
use Molle\Cli\Format;
use Molle\Command;

class AutocompleteCommand extends Command
{
    public function handle(GetOpt $opt): int
    {
        $shell = $opt->getOperand('shell');
        $outfile = BUILDDIR . "/_{$shell}";
        $appName = APPNAME;
        $rs = $this->app->prompt(Format::apply("> Esto creará el archivo \"{$outfile}\". ¿Desea continuar? (S/N) > ", Format::COLOR_LIGHT_BLUE));
        if (empty($rs) || strtolower($rs[0]) !== 's') {
            return 0;
        }
        $commands = [];
        foreach ($opt->getCommands() as $cmd) {
            $commands[] = $cmd->getName();
        }
        $callable = [$this, 'generate' . ucfirst($shell)];
        $script = call_user_func($callable, $appName, $commands);

        file_put_contents($outfile, $script);
        return 0;
    }

    public function getName(): string
    {
        return 'autocomplete';
    }

    public function getShortDescription(): string
    {
        return 'Generar autocomplete';
    }

    public function getDescription(): string
    {
        return 'Generación del archivo de autocompletado para la consola';
    }

    /**
     * @inheritdoc
     */
    public function getOperands()
    {
        $shells = ['bash', 'zsh'];
        return [
            Operand::create('shell', Operand::REQUIRED)
                ->setDescription('Shell para el cual se genera el script (' . implode(', ', $shells) . ')')
                ->setValidation(function ($value) use ($shells) {
                    return in_array($value, $shells);
                }, "Debe tomar alguno de los siguientes valores: " . implode(', ', $shells))
        ];
    }

    /**
     * @inheritdoc
     */
    public function getOptions()
    {
        return [];
    }

    protected function generateZsh(string $appName, array $commands) : string {
        $funcname = "_{$appName}_zsh";
        $commands = implode(' ', $commands);
        return
<<<TXT
$funcname() { 
    compadd $commands
}  

compdef $funcname $appName
TXT;
    }

    protected function generateBash(string $appName, array $commands) : string {
        $funcname = "_{$appName}_zsh";
        $commands = implode(' ', $commands);
        return "#/usr/bin/env bash
complete -W \"$commands\" $appName
";
    }
}
