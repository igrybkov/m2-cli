<?php

namespace App\Environment;

class ProjectName
{
    /**
     * @var DirectoryName
     */
    private $directoryName;

    /**
     * ProjectName constructor.
     * @param DirectoryName $directoryName
     */
    public function __construct(DirectoryName $directoryName)
    {
        $this->directoryName = $directoryName;
    }

    public function get(): string
    {
        return str_replace(' ', '-', $this->directoryName->get());
    }
}
