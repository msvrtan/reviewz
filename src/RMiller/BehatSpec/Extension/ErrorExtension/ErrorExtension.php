<?php

namespace RMiller\BehatSpec\Extension\ErrorExtension;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class ErrorExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('services.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return 'error';
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
        $errorTesterDefinition = $container->getDefinition('rmiller.error_extension.error_tester');

        $errorListeners = [];

        foreach ($container->findTaggedServiceIds('rmiller.error_listener') as $id => $tags) {
            $errorListeners[] = new Reference($id);
        }

        $errorTesterDefinition->replaceArgument(2, $errorListeners);
    }
}
