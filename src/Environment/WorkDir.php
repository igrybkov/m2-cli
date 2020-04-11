<?php

namespace App\Environment;

use Assert\Assert;

class WorkDir
{
    public function getPath(): string
    {
        $path = getcwd();
        Assert::that($path)->string();
        return $path;
    }
}
