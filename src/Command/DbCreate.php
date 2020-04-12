<?php

namespace App\Command;

use App\CommandConfigurator\ConfigurableCommandInterface;
use App\CommandConfigurator\DatabaseName;
use App\Environment\Database;
use App\Service\DatabaseManagement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbCreate extends Command implements ConfigurableCommandInterface
{
    /**
     * @var Database
     */
    private $database;
    /**
     * @var DatabaseManagement
     */
    private $databaseManagement;

    public function __construct(Database $database, DatabaseManagement $databaseManagement)
    {
        parent::__construct(null);
        $this->database = $database;
        $this->databaseManagement = $databaseManagement;
    }

    protected function configure(): void
    {
        $this->setName('db:create');
        $this->setDescription('Create database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $createError = $this->databaseManagement->create($this->database->getDatabase());
        if (null !== $createError) {
            $output->writeln(sprintf("<error>Cannot create database: %s</error>", $createError));
            return 1;
        }
        $output->writeln('Database created.');
        return 0;
    }

    public function getConfiguratorsList(): array
    {
        return [DatabaseName::class];
    }
}
