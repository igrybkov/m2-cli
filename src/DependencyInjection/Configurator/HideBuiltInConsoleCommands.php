<?php

namespace App\DependencyInjection\Configurator;

use Symfony\Component\Console\Command\Command;

/**
 * This configurator hides console commands that does not belong to the application
 */
class HideBuiltInConsoleCommands
{
    public function __invoke(Command $command): void
    {
        $hideCommands = getenv('APP_M2_CLI');
        if ($hideCommands) {
            $command->setHidden(true);
        }
    }
}
