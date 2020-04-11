<?php

namespace App\Command;

use App\CommandConfigurator\ConfigurableCommandInterface;
use App\CommandConfigurator\DatabaseCredentials;
use App\Environment\Database;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class MysqlConfig extends Command implements ConfigurableCommandInterface
{
    /**
     * @var Database
     */
    private $database;
    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Database $database, Filesystem $filesystem)
    {
        parent::__construct(null);
        $this->database = $database;
        $this->filesystem = $filesystem;
    }

    protected function configure()
    {
        $this->setName('mysql:config');
        $this->setDescription('Configure MySql client');
        $configPath = $this->getConfigPath();
        $this->setHelp(
            <<<HELP
Helps configure my.cnf in user's home directory <comment>(${configPath})</comment> to use mysql client without password.

Defaults values are pre-filled with values from Magento installation in current directory.
So if you have Magento installation with correct database credentials, you only need to run this command without parameters.

It does not override or delete existing options in my.cnf unless they were changed in this command.

<comment>Example usage:</comment>

<info>If you in directory with working Magento installation</info>
m2-cli mysql:config

<info>If you want set credentials manually</info>
m2-cli mysql:config --db-username=root --db-password=123123q --db-host=127.0.0.1
HELP
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configData = [];
        $configPath = $this->getConfigPath();
        if ($this->filesystem->exists($configPath)) {
            $configData = parse_ini_file($configPath, true);
        }
        if ($this->database->getHost()) {
            $configData['client']['host'] = $this->database->getHost();
        }
        if ($this->database->getUsername()) {
            $configData['client']['user'] = $this->database->getUsername();
        }
        if ($this->database->getPassword()) {
            $configData['client']['password'] = $this->database->getPassword();
        }
        $iniConfig = $this->convertToINI($configData);
        file_put_contents($configPath, $iniConfig);
        return 0;
    }

    private function convertToINI(array $data): string
    {
        $output = '';

        $values = [];
        $sections = [];

        foreach ($data as $option => $item) {
            if (is_array($item)) {
                $sections[$option] = $item;
            } else {
                $values[$option] = $item;
            }
        }
        foreach ($values as $option => $value) {
            $output .= $option . '=' . $value . "\n";
        }
        foreach ($sections as $section => $items) {
            $output .= "[{$section}]\n";
            foreach ($items as $option => $item) {
                $output .= $option . '=' . $item . "\n";
            }
            $output .= "\n";
        }
        return $output;
    }

    private function getConfigPath(): string
    {
        return getenv('HOME') . '/.my.cnf';
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        parent::interact($input, $output);
    }

    public function getConfiguratorsList(): array
    {
        return [
            DatabaseCredentials::class
        ];
    }
}
