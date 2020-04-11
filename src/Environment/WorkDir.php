<?php

namespace App\Environment;

use Assert\Assert;

class WorkDir
{
    public static function getPath(): string
    {
        $path = getcwd();
        Assert::that($path)->string();
        return $path;
    }
}
