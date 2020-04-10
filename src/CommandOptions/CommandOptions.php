<?php

namespace App\CommandOptions;

use Ahc\Cli\IO\Interactor;

interface CommandOptions
{
    public static function addOptionsToCommand(\Ahc\Cli\Input\Command $command): void;

    public static function readOptionsAndAskForMissingValues(\Ahc\Cli\Input\Command $command, Interactor $io): array;
}