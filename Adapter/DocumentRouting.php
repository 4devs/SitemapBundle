<?php

namespace FDevs\SitemapBundle\Adapter;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Cmf\Bundle\RoutingBundle\Model\Route as CmfRoute;
use Symfony\Component\Security\Core\SecurityContext;

class DocumentRouting extends AbstractRouting
{
    /** @var DocumentRepository */
    private $repo;
    /** @var \Doctrine\MongoDB\EagerCursor */
    private $routes;
    /** @var SecurityContext */
    private $securityContext;

    /**
     * init
     *
     * @param DocumentRepository $repo
     * @param string             $class
     */
    public function __construct(SecurityContext $securityContext, ManagerRegistry $repo, $manager = null, $class)
    {
        $this->repo = $repo->getManager($manager)->getRepository($class);
        $this->securityContext = $securityContext;
    }

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->routes = $this->repo->createQueryBuilder()
            ->eagerCursor(true)
            ->getQuery()->execute();
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        /** @var \FDevs\RoutingBundle\Doctrine\Mongodb\Route $route */
        $route = $this->routes->current();
        $url = null;
        if (method_exists($route, 'getName')) {
            if ($route instanceof CmfRoute) {
                try {
                    $content = $route->getContent();
                    if ($route->getDefault('sitemap')) {
                        $url = $this->generateUrl($route->getName(), $route);
                    } elseif ($content && $this->securityContext->isGranted('VIEW', $content)) {
                        $route->setDefault('priority', 0.7);
                        $url = $this->generateUrl($route->getName(), $route);
                    }
                } catch (\Exception $e) {

                }
            } else {
                $url = $this->generateUrl($route->getName(), $route);
            }
        }

        return $url;
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        $this->routes->next();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function first()
    {
        $this->routes->rewind();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        return $this->routes->valid();
    }
}
