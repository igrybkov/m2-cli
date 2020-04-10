<?php

namespace App\Validator;

use App\Shell\CliCommands;

class IsMagentoDirectory
{
    public function execute()
    {
        CliCommands::isFile('bin/magento');
    }
}