<?php

namespace FDevs\SitemapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $xml = $this->container->get('f_devs_sitemap.manager')->generate();

        return new Response($xml->saveXML(), 200, ['Content-Type' => 'application/xml']);
    }
}
