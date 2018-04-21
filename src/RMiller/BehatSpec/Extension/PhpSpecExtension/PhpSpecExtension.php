<?php

namespace RMiller\BehatSpec\Extension\PhpSpecExtension;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class PhpSpecExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('services.xml');

        $container->setParameter('phpspec_extension.path', $config['path']);
        $container->setParameter('phpspec_extension.config', $config['config']);
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('path')->defaultValue('bin/phpspec')->end()
                ->scalarNode('config')->defaultValue('phpspec.yml')->end()
            ->end()
        ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return 'phpspec';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
    }
}
