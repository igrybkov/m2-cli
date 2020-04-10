<?php

namespace App\CommandOptions;

use Ahc\Cli\IO\Interactor;
use App\CommandOptions\CommandOptions;

class Database implements CommandOptions
{
    public static function addOptionsToCommand(\Ahc\Cli\Input\Command $command): void
    {
        $command->option('--db-user', 'Database username', null, 'root');
        $command->option('--db-password', 'Database password');
    }

    /**
     * @param \Ahc\Cli\Input\Command $command
     * @param Interactor $io
     * @return array
     */
    public static function readOptionsAndAskForMissingValues(\Ahc\Cli\Input\Command $command, Interactor $io): array
    {
        $values = $command->values();
        return $values;
        // TODO: Implement read() method.
    }
}