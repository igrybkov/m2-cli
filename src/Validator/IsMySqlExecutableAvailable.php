<?php

namespace App\Validator;
use App\Shell\CliCommands;

class IsMySqlExecutableAvailable
{
    public function execute(): void
    {
        CliCommands::which('mysql');
    }
}