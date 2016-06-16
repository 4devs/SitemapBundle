<?php
/**
 * @author    Andrey Samusev <andrey_simfi@list.ru>
 * @copyright andrey 12/7/13
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FDevs\SitemapBundle\Service;

use FDevs\SitemapBundle\Adapter\AdapterInterface;
use FDevs\SitemapBundle\Model\Url;

class Sitemap extends AbstractManager
{
    /** @var AdapterInterface[] */
    private $urlSets;

    /** @var null */
    private $lastmod = null;

    /** @var array */
    private $insert = [];

    /**
     * {@inheritdoc}
     */
    protected function getRootName()
    {
        return 'urlset';
    }

    /**
     * init.
     *
     * @param string $dir
     */
    public function __construct($dir = '')
    {
        $this->webPath = $dir;
    }

    /**
     * add Adapter.
     *
     * @param AdapterInterface $urlSets
     *
     * @return $this
     */
    public function addAdapter(AdapterInterface $urlSets)
    {
        $this->urlSets[] = $urlSets;

        return $this;
    }

    /**
     * init all Adapters.
     *
     * @param array $params
     *
     * @return $this
     */
    public function init(array $params = [])
    {
        $param = current($params);
        foreach ($this->urlSets as $urlSets) {
            $urlSets->init($param);
        }

        return $this;
    }

    /**
     * generate Sitemap.
     *
     * @param array $params
     *
     * @return \DOMDocument
     */
    public function generate(array $params = [], \DOMElement $element)
    {
        foreach ($params as $param) {
            $this->appendChildList($element, $param);
        }

        return $this->dom;
    }

    /**
     * @param \DOMElement $root
     * @param array       $params
     *
     * @return \DOMDocument
     */
    public function appendChildList(\DOMElement $root, array $params = [])
    {
        foreach ($this->urlSets as $urlSets) {
            $urlSets->setParams($params)->first();
            while ($urlSets->valid()) {
                $url = $urlSets->current();
                if ($url instanceof Url && !isset($this->insert[$url->getLoc()])) {
                    $root->appendChild($url->getElement($this->dom));
                    $this->setLastMod($url);
                    $this->insert[$url->getLoc()] = true;
                }
                $urlSets->next();
            }
        }

        return $this->dom;
    }

    /**
     * get Lastmod.
     *
     * @return string
     */
    public function getLastmod()
    {
        return $this->lastmod;
    }

    /**
     * set Last Mod.
     *
     * @param Url $url
     *
     * @return $this
     */
    private function setLastMod(Url $url)
    {
        $this->lastmod = !$this->lastmod || $url->getLastmod() > $this->lastmod
            ? $url->getLastmod()
            : $this->lastmod;

        return $this;
    }
}
