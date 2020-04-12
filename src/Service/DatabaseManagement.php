<?php

namespace App\Service;

use Symfony\Component\Process\Process;

class DatabaseManagement
{
    public function create(string $database): ?string
    {
        $process = new Process(['mysql']);
        $process->setInput(sprintf("create database if not exists`%s`;", $database));
        $process->run();
        return $process->isSuccessful() ? null : $process->getErrorOutput();
    }

    public function drop(string $database): ?string
    {
        $process = new Process(['mysql']);
        $process->setInput(sprintf("drop database if exists`%s`;", $database));
        $process->run();
        return $process->isSuccessful() ? null : $process->getErrorOutput();
    }
}
