<?php

namespace App\CommandConfigurator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface ConfiguratorInterface
{
    public function configureCommand(Command $command): void;

    public function collectUserInput(InputInterface $input, OutputInterface $output, Command $command): void;
}
