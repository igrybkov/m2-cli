<?php

namespace App\Command;

use App\CommandConfigurator\ConfiguratorAwareCommand;
use App\CommandConfigurator\Database;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbCreate extends Command implements ConfiguratorAwareCommand
{
    protected function configure(): void
    {
        $this->setName('db:create');
        $this->setDescription('Create database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<error>Command not implemented</error>');
        return 1;
    }

    public function getConfiguratorsList(): array
    {
        return [Database::class];
    }
}
