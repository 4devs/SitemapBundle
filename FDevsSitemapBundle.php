<?php

namespace FDevs\SitemapBundle;

use FDevs\SitemapBundle\DependencyInjection\ContainerBuilder\AdapterCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FDevsSitemapBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new AdapterCompilerPass());
    }
}
