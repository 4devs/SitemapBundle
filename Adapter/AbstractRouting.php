<?php
/**
 * @author    Andrey Samusev <andrey_simfi@list.ru>
 * @copyright andrey 12/8/13
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FDevs\SitemapBundle\Adapter;

use FDevs\SitemapBundle\Model\Url;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Route;

abstract class AbstractRouting implements AdapterInterface
{

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;

    /**
     * {@inheritDoc}
     */
    public function setParams(array $parameters = [])
    {
        $this->params = $parameters;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setUrlGenerator(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;

        return $this;
    }

    /**
     * @param string                           $name
     * @param \Symfony\Component\Routing\Route $route
     *
     * @return Url|null
     */
    protected function generateUrl($name, $route)
    {
        $url = null;
        if ($route instanceof Route) {
            $url = new Url(
                $this->urlGenerator->generate(
                    $name,
                    array_intersect_key($this->params, array_flip($route->compile()->getVariables())),
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            );
            $url->setPriority($route->getDefault('priority'));
            $url->setLastmod($route->getDefault('lastmod'));
            $url->setChangefreq($route->getDefault('changefreq'));
        }

        return $url;
    }

    /**
     * is Route Variables Complete
     *
     * @param Route $route
     * @param array $variables
     *
     * @return bool
     */
    public static function isRouteVariablesComplete(Route $route, array $variables)
    {
        return !count(
            array_diff($route->compile()->getVariables(), array_keys(array_merge($variables, $route->getDefaults())))
        );
    }
}
