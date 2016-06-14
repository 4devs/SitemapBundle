<?php

namespace FDevs\SitemapBundle\Service;

use FDevs\SitemapBundle\Model\Sitemap as ModelSitemap;

class SitemapIndex extends AbstractManager
{
    /** @var Sitemap */
    private $sitemap;

    /** @var string */
    private $siteMapsDir;

    /** @var string */
    private $domain;

    /**
     * init.
     *
     * @param string $webPath
     * @param string $domain
     * @param string $siteMapsDir
     */
    public function __construct($webPath, $domain, $siteMapsDir)
    {
        $this->webPath = $webPath;
        $this->domain = $domain;
        $this->siteMapsDir = $siteMapsDir;
    }

    public function setSiteMapGenerator(Sitemap $sitemap)
    {
        $this->sitemap = $sitemap;
    }

    public function generate(array $params = [], \DOMElement $element)
    {
        $this->sitemap->setFileName($this->filename);
        foreach ($params as $param) {
            $dom = $this->createDomDocument();
            $this->sitemap->setDomDocument($dom);
            $root = $this->sitemap->getRootElement();
            $sitemap = $this->sitemap->appendChildList($root, $param);
            if ($root->childNodes->length) {
                $filename = $this->sitemap->getFileName($param, $this->siteMapsDir);
                $sitemap->save($filename);
                $loc = str_replace($this->webPath, $this->domain, $filename);
                $model = new ModelSitemap($loc, $this->sitemap->getLastmod());
                $element->appendChild($model->getElement($this->dom));
            }
        }

        return $this->dom;
    }

    public function init(array $params = [])
    {
        $this->sitemap->init($params);
    }

    protected function getRootName()
    {
        return 'sitemapindex';
    }
}
