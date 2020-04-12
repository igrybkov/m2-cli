<?php

namespace App\Command;

use App\CommandConfigurator\ConfigurableCommandInterface;
use App\CommandConfigurator\DatabaseName;
use App\Environment\Database;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class DbDrop extends Command implements ConfigurableCommandInterface
{
    /**
     * @var Database
     */
    private $database;

    public function __construct(Database $database)
    {
        parent::__construct(null);
        $this->database = $database;
    }

    protected function configure(): void
    {
        $this->setName('db:drop');
        $this->setDescription('Drop database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $process = new Process(['mysql']);
        $process->setInput(sprintf("drop database if exists`%s`;", $this->database->getDatabase()));
        $process->run();

        $exitCode = (int)$process->getExitCode();
        $output->writeln('Query complete. Exit code ' . $exitCode);
        return $exitCode;
    }

    public function getConfiguratorsList(): array
    {
        return [DatabaseName::class];
    }
}
