<?php

namespace App\DependencyInjection;

use App\CommandConfigurator\ConfiguratorComposite;
use App\DependencyInjection\Configurator\ApplyCommandConfigurators;
use App\DependencyInjection\Configurator\HideBuiltInConsoleCommands;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Adds configurators for commands
 */
class ConsoleCommandPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $this->addConfiguratorsToComposite($container);
        $this->addConfigurableCommandsConfigurator($container);
        $this->addHidingForBuiltInCommands($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function addHidingForBuiltInCommands(ContainerBuilder $container): void
    {
        $consoleCommandsIds = $container->findTaggedServiceIds('console.command');
        $configurator = new \Symfony\Component\DependencyInjection\Reference(HideBuiltInConsoleCommands::class);
        foreach (array_keys($consoleCommandsIds) as $consoleCommandsId) {
            if (!$container->getDefinition($consoleCommandsId)->hasTag('app.command')) {
                $container->getDefinition($consoleCommandsId)->setConfigurator($configurator);
            }
        }
    }

    /**
     * @param ContainerBuilder $container
     */
    private function addConfigurableCommandsConfigurator(ContainerBuilder $container): void
    {
        $configurableCommands = $container->findTaggedServiceIds('app.configurable_command');
        $configurator = new \Symfony\Component\DependencyInjection\Reference(ApplyCommandConfigurators::class);
        foreach (array_keys($configurableCommands) as $configurableCommandId) {
            $container->getDefinition($configurableCommandId)->setConfigurator($configurator);
        }
    }

    /**
     * @param ContainerBuilder $container
     */
    private function addConfiguratorsToComposite(ContainerBuilder $container): void
    {
        $commandConfigurators = $container->findTaggedServiceIds('app.command_configurator');
        $references = [];
        $configuratorIds = array_keys($commandConfigurators);
        $configuratorIds = array_diff($configuratorIds, [ConfiguratorComposite::class]);
        foreach ($configuratorIds as $serviceId) {
            $references[$serviceId] = new Reference($serviceId);
        }
        $container->getDefinition(ConfiguratorComposite::class)->setArgument('$configurators', $references);
    }
}
