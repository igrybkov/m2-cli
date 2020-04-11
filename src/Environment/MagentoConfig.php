<?php

namespace App\Environment;

class MagentoConfig
{
    private static $instances = [];

    private $isFileExists;
    private $data;
    /**
     * @var string
     */
    private $path;

    public function __construct(string $file)
    {
        $this->isFileExists = ArrayConfigFile::isValidArrayConfig($file);
        $this->data = ArrayConfigData::fromConfig(ArrayConfigFile::read($file));
        $this->path = $file;
    }

    public function data()
    {
        return $this->data;
    }

    public function isFileExists()
    {
        return $this->isFileExists;
    }

    public function write()
    {
        ArrayConfigFile::write($this->path, $this->data->getValue('.'));
        $this->isFileExists = true;
    }

    public static function env(): self
    {
        $path = WorkDir::getPath() . '/app/etc/env.php';
        if (!isset(self::$instances[$path])) {
            self::$instances[$path] = new self($path);
        }
        return self::$instances[$path];
    }

    public static function config(): self
    {
        $path = WorkDir::getPath() . '/app/etc/config.php';
        if (!isset(self::$instances[$path])) {
            self::$instances[$path] = new self($path);
        }
        return self::$instances[$path];
    }

    public static function merged(): ArrayConfigData
    {
        // don't cache it to keep it always up to date
        $mergedConfig = ArrayConfigData::fromConfig(self::config()->data()->getValue('.'));
        $mergedConfig->merge(self::env()->data()->getValue('.'));
        return $mergedConfig;
    }
}
