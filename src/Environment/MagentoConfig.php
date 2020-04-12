<?php

namespace App\Environment;

class MagentoConfig
{
    /**
     * @var self[]
     */
    private static $instances = [];

    /**
     * @var ArrayConfigData
     */
    private $data;
    /**
     * @var string
     */
    private $path;

    public function __construct(string $file)
    {
        $this->data = ArrayConfigData::fromConfig(ArrayConfigFile::read($file));
        $this->path = $file;
    }

    public function data(): ArrayConfigData
    {
        return $this->data;
    }

    public function write(): void
    {
        ArrayConfigFile::write($this->path, (array)$this->data->getValue('.'));
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
        // don't cache merged config to keep it always up to date
        $mergedConfig = ArrayConfigData::fromConfig((array)self::config()->data()->getValue('.'));
        $mergedConfig->merge((array)self::env()->data()->getValue('.'));
        return $mergedConfig;
    }
}
