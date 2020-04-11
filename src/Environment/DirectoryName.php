<?php

namespace App\Environment;

class DirectoryName
{
    /**
     * @var WorkDir
     */
    private $dir;

    public function __construct(WorkDir $dir)
    {
        $this->dir = $dir;
    }

    public function get(): string
    {
        return basename($this->dir->getPath());
    }
}
