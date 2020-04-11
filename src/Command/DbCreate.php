<?php

namespace App\Command;

use App\CommandConfigurator\ConfigurableCommandInterface;
use App\CommandConfigurator\DatabaseName;
use App\Environment\ArrayConfigData;
use App\Environment\MagentoConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbCreate extends Command implements ConfigurableCommandInterface
{
    /**
     * @var ArrayConfigData
     */
    private $magentoConfig;

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('db:create');
        $this->setDescription('Create database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $merged = MagentoConfig::merged();
        $hasElasticSearch = (bool)$merged->getValue('[modules][Magento_Elasticsearch]');
        $magentoConfig = MagentoConfig::env();
        $host = $magentoConfig->data()->getValue('[db][connection][default][host]');
        $magentoConfig->data()->setValue('[db][connection][default][host]', '127.0.0.1');
        $magentoConfig->write();
        $output->writeln('<error>Command not implemented</error>');
        return 1;
    }

    public function getConfiguratorsList(): array
    {
        return [DatabaseName::class];
    }
}
