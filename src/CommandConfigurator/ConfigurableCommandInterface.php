<?php

namespace App\CommandConfigurator;

interface ConfigurableCommandInterface
{
    /**
     * Returns list of classes of supported configurators
     *
     * @return string[]
     */
    public function getConfiguratorsList(): array;
}
