<?php

namespace Molle\Commands;

use GetOpt\GetOpt;
use GetOpt\Option;
use Molle\Cli\Format;
use Molle\Command;

class CreateCommand extends Command
{
    public function handle(GetOpt $opt): int
    {
        $name = $opt->getOption('name');
        $description = $opt->getOption('description');
        $shortDescription = $opt->getOption('short-description');
        $class = ucfirst(strtolower($name)) . 'Command';
        
        $filename = APPDIR . "/src/Commands/{$class}.php";
        $rs = $this->app->prompt(Format::apply("This action will create the \"{$filename}\" file. ¿Desea continuar? (S/N) >", Format::COLOR_LIGHT_BLUE));
        if (empty($rs) || strtolower($rs[0]) !== 's') {
            return 0;
        }

        $ns = APPNS;
        // Command creation
        $resourceDir = APPDIR . '/resources';
        $contents = file_get_contents("{$resourceDir}/command-template.php.txt");
        $contents = str_replace('<description>', $description, $contents);
        $contents = str_replace('<shortDescription>', $shortDescription, $contents);
        $contents = str_replace("<name>", $name, $contents);
        $contents = str_replace("<class>", $class, $contents);
        $contents = str_replace('<ns>', $ns, $contents);
        file_put_contents($filename, $contents);

        // Command registration
        $commands = file_get_contents(APPDIR . '/app/commands.php');
        $commands = str_replace('use Molle\\App;', "use Molle\\App;\nuse {$ns}\\Commands\\{$class};", $commands);
        $commands = str_replace('};', "    \$app->registerCommand({$class}::class);\n};", $commands);
        file_put_contents(APPDIR . '/app/commands.php', $commands);
        return 0;
    }

    public function getName(): string
    {
        return 'create';
    }

    public function getShortDescription(): string
    {
        return 'Creates a new command';
    }

    public function getDescription(): string
    {
        return 'Command used for the creation of new commands';
    }

    /**
     * @inheritdoc
     */
    public function getOperands()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getOptions()
    {
        return [
            (new Option('n', 'name', GetOpt::REQUIRED_ARGUMENT))
                ->setDescription('New command name'),
            (new Option('d', 'description', GetOpt::REQUIRED_ARGUMENT))
                ->setDescription('Command description'),
            (new Option('s', 'short-description', GetOpt::REQUIRED_ARGUMENT))
                ->setDescription('Command short description'),
        ];
    }
}
