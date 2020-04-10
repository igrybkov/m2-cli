<?php

namespace App\Shell;

use Assert\Assert;
use Symfony\Component\Process\Process;

class CliCommands
{
    public static function which(string $name)
    {
        $cmd = new Process(['which', $name]);
        $cmd->run();
        Assert::that($cmd->isSuccessful())->true("{$name} binary not found");
        return $cmd->getOutput();
    }

    public static function isDirectory(string $path)
    {
        Assert::that($path)->directory("$path is not a directory");
    }

    public static function isFile(string $path)
    {
        Assert::that($path)->file("$path is not a file");
    }
}