<?php

namespace App\DependencyInjection\Configurator;

use App\CommandConfigurator\ConfiguratorComposite;
use Symfony\Component\Console\Command\Command;

class ApplyCommandConfigurators
{
    /**
     * @var ConfiguratorComposite
     */
    private $composite;

    public function __construct(ConfiguratorComposite $composite)
    {
        $this->composite = $composite;
    }

    public function __invoke(Command $command): void
    {
        $this->composite->configureCommand($command);
    }
}
