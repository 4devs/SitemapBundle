<?php

namespace FDevs\SitemapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FDevsSitemapExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(
            $this->getAlias().'.web_dir',
            $config['web_dir'] ?: $container->getParameter('kernel.root_dir').'/../web'
        );
        $container->setParameter($this->getAlias().'.sitemaps_dir', $config['sitemaps_dir']);
        $container->setParameter($this->getAlias().'.domain', $config['domain']);
        $container->setParameter($this->getAlias().'.filename', $config['filename']);
        $container->setParameter($this->getAlias().'.parameters', $config['parameters']);
        $container->setParameter($this->getAlias().'.generate_sitemapindex', $config['generate_sitemapindex']);

        if ($config['generate_sitemapindex']) {
            $container->setAlias($this->getAlias().'.default', $this->getAlias().'.generator_index');
        } else {
            $container->setAlias($this->getAlias().'.default', $this->getAlias().'.generator');
        }

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if ($config['document_class'] && $container->hasDefinition('f_devs_sitemap.adapter.document_route')) {
            $definition = $container->getDefinition('f_devs_sitemap.adapter.document_route');
            $definition->addArgument($config['document_manager']);
            $definition->addArgument($config['document_class']);
            $definition->addTag('f_devs_sitemap.adapter');
        }
    }
}
