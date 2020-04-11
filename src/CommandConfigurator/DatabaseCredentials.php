<?php

namespace App\CommandConfigurator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseCredentials implements ConfiguratorInterface
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
            'db-username',
            null,
            InputOption::VALUE_REQUIRED,
            'Database username',
            $this->config->getUsername()
        );
        $command->addOption(
            'db-password',
            null,
            InputOption::VALUE_REQUIRED,
            'Database password',
            $this->config->getPassword() ? '<hidden>' : '<empty>'
        );
        $command->addOption(
            'db-host',
            null,
            InputOption::VALUE_REQUIRED,
            'Database host',
            $this->config->getHost()
        );
        $command->addOption(
            'db-port',
            null,
            InputOption::VALUE_REQUIRED,
            'Database port',
            $this->config->getPort()
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param Command $command
     * @psalm-suppress PossiblyInvalidArgument
     */
    public function collectUserInput(InputInterface $input, OutputInterface $output, Command $command): void
    {
        $this->config->setUsername($input->getOption('db-username'));
        $password = $input->getOption('db-password');
        if (is_string($password) && !in_array($password, ['<hidden>', '<empty>'])) {
            $this->config->setPassword($password);
        }
        $this->config->setHost($input->getOption('db-host'));
        $port = $input->getOption('db-port');
        $this->config->setPort((int)$port);
    }
}
