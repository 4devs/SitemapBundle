<?php

namespace FDevs\SitemapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('f_devs_sitemap');
        $rootNode
            ->children()
                ->scalarNode('web_dir')->defaultNull()->end()
                ->scalarNode('document_class')->defaultNull()->end()
                ->scalarNode('document_manager')->defaultNull()->end()
                ->booleanNode('generate_sitemapindex')->defaultFalse()->end()
                ->scalarNode('filename')->defaultValue('sitemap')->end()
                ->scalarNode('domain')->isRequired()->end()
                ->scalarNode('sitemaps_dir')->defaultValue('sitemaps/')->end()
                ->arrayNode('parameters')
                    ->useAttributeAsKey('name')
                    ->defaultValue([])
                    ->prototype('array')
                        ->prototype('scalar')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
