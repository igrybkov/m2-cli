<?php

namespace App\Environment;

use Symfony\Component\VarExporter\VarExporter;

class ArrayConfigFile
{
    /**
     * Returns empty array if config does not exist
     *
     * @param string $configPath
     * @return array
     */
    public static function read(string $configPath): array
    {
        if (!self::isValidArrayConfig($configPath)) {
            return [];
        }
        /**
         * @psalm-suppress UnresolvableInclude
         * @psalm-suppress MixedReturnStatement
         */
        return (array) include $configPath;
    }

    public static function write(string $configPath, array $data): void
    {
        $content = VarExporter::export($data);
        $content = sprintf("<?php\nreturn %s;\n", $content);
        file_put_contents($configPath, $content);
    }

    private static function exists(string $configPath): bool
    {
        return file_exists($configPath) && is_file($configPath);
    }

    /**
     * @param string $configPath
     * @return bool
     */
    public static function isValidArrayConfig(string $configPath): bool
    {
        if (!self::exists($configPath)) {
            return false;
        }

        /**
         * @psalm-suppress MixedAssignment
         * @psalm-suppress UnresolvableInclude
         * @psalm-suppress MixedReturnStatement
         */
        $data = @include $configPath;
        return is_array($data);
    }
}
