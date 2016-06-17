<?php

namespace FDevs\SitemapBundle;

use FDevs\Bridge\Sitemap\DependencyInjection\Compiler\AdapterPass;
use FDevs\Bridge\Sitemap\DependencyInjection\Compiler\FactoryPass;
use FDevs\Bridge\Sitemap\DependencyInjection\FDevsSitemapExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Console\Application;

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

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        if (null === $this->path) {
            $reflected = new \ReflectionClass('FDevs\Bridge\Sitemap\SitemapEvents');
            $this->path = dirname($reflected->getFileName());
        }

        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function registerCommands(Application $application)
    {
    }
}
