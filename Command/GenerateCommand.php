<?php

namespace FDevs\SitemapBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $manager = $this->getContainer()->get('f_devs_sitemap.manager');

        $document = $manager->generate();
        $filename = $manager->getFileName();
        $document->save($filename);
        $output->writeln('<info>sitemap created</info>');
    }

}
