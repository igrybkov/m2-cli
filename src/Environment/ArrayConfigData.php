<?php

namespace App\Environment;

use Symfony\Component\PropertyAccess\PropertyAccess;

class ArrayConfigData
{
    /**
     * @var array
     */
    private $config;

    private function __construct(array $config)
    {
        $this->config = $config;
    }

    public static function fromConfig(array $configData): self
    {
        return new self($configData);
    }

    public function merge(array $config): void
    {
        $this->config = array_merge_recursive($this->config, $config);
    }

    /**
     * @param string $path
     * @param string $delimiter
     * @return array|mixed|null
     */
    public function getValue(string $path, string $delimiter = '.')
    {
        if ($path === $delimiter) {
            return $this->config;
        }
        $accessor = PropertyAccess::createPropertyAccessorBuilder()
            ->disableExceptionOnInvalidPropertyPath()
            ->getPropertyAccessor();

        return $accessor->getValue($this->config, $path);
    }

    /**
     * @param string $path
     * @param array|mixed|null $value
     * @param string $delimiter
     */
    public function setValue(string $path, $value, string $delimiter = '.'): void
    {
        if ($path === $delimiter) {
            $this->config = (array)$value;
            return;
        }

        $accessor = PropertyAccess::createPropertyAccessorBuilder()
            ->disableExceptionOnInvalidPropertyPath()
            ->getPropertyAccessor();
        /**
         * @psalm-suppress PossiblyInvalidPropertyAssignmentValue
         */
        $accessor->setValue($this->config, $path, $value);
    }
}
