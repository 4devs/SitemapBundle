<?php

namespace FDevs\SitemapBundle\DependencyInjection\ContainerBuilder;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AdapterCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('f_devs_sitemap.generator')) {
            return;
        }

        $definition = $container->getDefinition(
            'f_devs_sitemap.generator'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'f_devs_sitemap.adapter'
        );
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall('addAdapter', [new Reference($id)]);
        }
    }

}
