<?php

namespace LogsExtension\ServiceContainer;

use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use LogsExtension\Context\Initializer\LogsInitializer;

class LogsExtension implements Extension
{
    public function getConfigKey()
    {
        return 'logs_extension';
    }

    /**
     * Called after extensions activation, but before `configure()`.
     * Used to hook into other extensions' configuration.
     */
    public function initialize(ExtensionManager $extensionManager)
    {
        // emtpy for our case
    }

    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->addDefaultsIfNotSet()
                ->children()
                    ->booleanNode('enable')->defaultFalse()->end()
                    ->scalarNode('filepath')->defaultValue('behat.log')->end()
                ->end()
            ->end();
    }

    public function load(ContainerBuilder $container, array $config)
    {
        $definition = new Definition(LogsInitializer::class, [
            $config['filepath'],
            $config['enable'],
        ]);
        $definition->addTag(ContextExtension::INITIALIZER_TAG);
        $container->setDefinition('logs_extension.context_initializer', $definition);
    }

    // needed as Extension interface implements CompilerPassInterface
    public function process(ContainerBuilder $container)
    {
    }
}
