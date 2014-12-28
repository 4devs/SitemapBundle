<?php

namespace FDevs\SitemapBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\User\User;

class GenerateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdevs:sitemap:generate')
            ->setDescription('Generate Sitemap');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $manager = $container->get('f_devs_sitemap.manager');
        /** @var \Symfony\Component\Security\Core\SecurityContext $security */
        $container->get('security.context')->setToken(new AnonymousToken('command','cimmand'));
        /** @var \Symfony\Cmf\Component\Routing\ChainRouter $router */
        $parse = parse_url($container->getParameter('f_devs_sitemap.domain'));
        $container->get('router')->getContext()->setHost($parse['host'])->setScheme($parse['scheme']);

        $document = $manager->generate();
        $filename = $manager->getFileName();
        $document->save($filename);
        $output->writeln('<info>sitemap created</info>');
    }

}
