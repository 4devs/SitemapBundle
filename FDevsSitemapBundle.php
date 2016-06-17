<?php

namespace FDevs\SitemapBundle;

use FDevs\Bridge\Sitemap\DependencyInjection\Compiler\AdapterPass;
use FDevs\Bridge\Sitemap\DependencyInjection\Compiler\FactoryPass;
use FDevs\Bridge\Sitemap\DependencyInjection\FDevsSitemapExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FDevsSitemapBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new AdapterPass())
            ->addCompilerPass(new FactoryPass())
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function createContainerExtension()
    {
        return new FDevsSitemapExtension();
    }
}
