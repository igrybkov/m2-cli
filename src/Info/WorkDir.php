<?php

namespace App\Info;

class WorkDir
{
    public static function getPath(): string
    {
        return getcwd();
    }
}