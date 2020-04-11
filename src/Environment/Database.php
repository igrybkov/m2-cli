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
    /** @var int */
    private $port;

    public function __construct(ProjectName $projectName)
    {
        $this->database = $projectName->get();
        $this->username = 'root';
        $this->password = '';
        $this->host = 'localhost';
        $this->port = 3306;
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
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }
}
