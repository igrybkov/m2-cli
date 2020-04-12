<?php

namespace App\CommandConfigurator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseName implements ConfiguratorInterface
{
    /**
     * @var \App\Environment\Database
     */
    private $config;

    public function __construct(\App\Environment\Database $databaseConfig)
    {
        $this->config = $databaseConfig;
    }

    public function configureCommand(Command $command): void
    {
        $command->addOption(
            'db-name',
            null,
            InputOption::VALUE_REQUIRED,
            'Database username',
            $this->config->getDatabase()
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param Command $command
     * @param ConsoleCommandEvent $event
     * @psalm-suppress PossiblyInvalidArgument
     */
    public function collectUserInput(
        InputInterface $input,
        OutputInterface $output,
        Command $command,
        ConsoleCommandEvent $event
    ): void {
        $this->config->setDatabase($input->getOption('db-name'));
    }
}
