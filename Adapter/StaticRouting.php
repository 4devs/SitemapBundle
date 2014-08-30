<?php
/**
 * @author    Andrey Samusev <andrey_simfi@list.ru>
 * @copyright andrey 12/7/13
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FDevs\SitemapBundle\Adapter;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

class StaticRouting extends AbstractRouting
{

    /**
     * @var ArrayCollection
     */
    private $urlCollection;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * init
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
        $this->setUrlGenerator($router);
        $this->urlCollection = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function init(array $params = [])
    {
        $this->setParams($params);
        $routes = array_filter(
            $this->router->getRouteCollection()->all(),
            function (Route $route) {
                return $route->getDefault('sitemap');
            }
        );
        /**
         * @var string                           $name
         * @var \Symfony\Component\Routing\Route $route
         */
        foreach ($routes as $name => $route) {
            $name = method_exists($route, 'getName') ? $route->getName() : $name;
            if (is_string($name) && self::isRouteVariablesComplete($route, $this->params)) {
                $this->urlCollection->set($name, $route);
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        $route = $this->urlCollection->current();

        return $this->generateUrl($this->urlCollection->key(), $route);
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        $this->urlCollection->next();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function first()
    {
        $this->urlCollection->first();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        return !!$this->urlCollection->current();
    }

}
