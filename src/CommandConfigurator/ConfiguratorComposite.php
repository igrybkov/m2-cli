<?php

namespace App\CommandConfigurator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConfiguratorComposite implements ConfiguratorInterface
{
    /**
     * @var ConfiguratorInterface[]
     */
    private $configurators;

    /**
     * ConfiguratorComposite constructor.
     * @param ConfiguratorInterface[] $configurators
     */
    public function __construct(array $configurators)
    {
        $this->configurators = $configurators;
    }


    public function configureCommand(Command $command): void
    {
        if ($command instanceof ConfigurableCommandInterface) {
            foreach ($command->getConfiguratorsList() as $name) {
                if (isset($this->configurators[$name])) {
                    $this->configurators[$name]->configureCommand($command);
                }
            }
        }
    }

    public function collectUserInput(
        InputInterface $input,
        OutputInterface $output,
        Command $command,
        ConsoleCommandEvent $event
    ): void {
        if ($command instanceof ConfigurableCommandInterface) {
            foreach ($command->getConfiguratorsList() as $name) {
                if (isset($this->configurators[$name])) {
                    $this->configurators[$name]->collectUserInput($input, $output, $command, $event);
                }
            }
        }
    }
}
