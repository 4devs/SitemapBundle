<?php

namespace FDevs\SitemapBundle\Adapter;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Cmf\Bundle\RoutingBundle\Model\Route as CmfRoute;
use Symfony\Component\Routing\Route;
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
     * @param SecurityContext $securityContext
     * @param ManagerRegistry $repo
     * @param string|null     $manager
     * @param string          $class
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
        if ($route instanceof Route
            && method_exists($route, 'getName')
            && self::isRouteVariablesComplete($route, $this->params)) {
            if ($route instanceof CmfRoute) {
                try {
                    $content = $route->getContent();
                    if ($route->getDefault('sitemap')) {
                        $url = $this->generateUrl($route->getName(), $route);
                    } elseif ($content && $this->securityContext->isGranted('VIEW_ANONYMOUS', $content)) {
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
