<?php

namespace App\Info;

use Symfony\Component\Filesystem\Filesystem;

class MagentoConfig
{
    private const CONFIG_FILES = [
        'app/etc/config.php',
        'app/etc/env.php',
    ];

    /**
     * @var array|null
     */
    private $config;

    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var WorkDir
     */
    private $dir;

    public function __construct(Filesystem $filesystem, WorkDir $dir)
    {
        $this->filesystem = $filesystem;
        $this->dir = $dir;
    }

    public function exists()
    {
        foreach (self::CONFIG_FILES as $configFile) {
            if ($this->filesystem->exists($this->dir->getPath() . '/' . $configFile)) {
                return true;
            }
        }
        return false;
    }

    private function readConfigs()
    {
        if (null !== $this->config) {
            return;
        }
        $result = [];
        foreach (self::CONFIG_FILES as $configFile) {
            $configPath = $this->dir->getPath() . '/' . $configFile;
            if ($this->filesystem->exists($configPath)) {
                $config = include $configPath;
                if (!is_array($config)) {
                    throw new \RuntimeException('Config ' . $configFile . ' has wrong structure');
                }
                $result = array_merge_recursive($result, $config);
            }
        }
    }
}