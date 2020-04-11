<?php

namespace App\CommandConfigurator;

interface ConfiguratorAwareCommand
{
    /**
     * Returns list of classes of supported configurators
     *
     * @return string[]
     */
    public function getConfiguratorsList(): array;
}
