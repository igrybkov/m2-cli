<?php

namespace App\Environment;

use Assert\Assert;

class Database
{
    /** @var string */
    private $database;
    /** @var string */
    private $username;
    /** @var string */
    private $password;
    /** @var string */
    private $host;
    /** @var int|null */
    private $port;

    public function __construct(ProjectName $projectName)
    {
        $mergedConfig = MagentoConfig::merged();
        $this->database = $mergedConfig->getValue('[db][connection][default][dbname]') ?: $projectName->get();
        $this->username = $mergedConfig->getValue('[db][connection][default][username]') ?: 'root';;
        $this->password = $mergedConfig->getValue('[db][connection][default][password]') ?: '';
        $this->host = $mergedConfig->getValue('[db][connection][default][host]') ?: '127.0.0.1';
        $this->port = null;
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * @param string $database
     */
    public function setDatabase(string $database): void
    {
        Assert::that($database)->notEmpty('Database name cannot be empty');
        $this->database = $database;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return int|null
     */
    public function getPort(): ?int
    {
        return $this->port;
    }

    /**
     * @param int|null $port
     */
    public function setPort(?int $port): void
    {
        $this->port = $port;
    }
}
