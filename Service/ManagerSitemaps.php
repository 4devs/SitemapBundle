<?php

namespace FDevs\SitemapBundle\Service;

use FDevs\SitemapBundle\Adapter\RouteParams;

class ManagerSitemaps
{
    /** @var AbstractManager */
    private $manager;
    /** @var bool */
    private $makeIndex;
    /** @var array */
    private $params = [];

    /**
     * init.
     *
     * @param AbstractManager $manager
     * @param string          $fileName
     * @param bool            $makeIndex
     * @param array           $params
     */
    public function __construct(AbstractManager $manager, $fileName, $makeIndex = false, array $params = [])
    {
        $this->manager = $manager;
        $this->manager->setFileName($fileName);
        $this->makeIndex = $makeIndex;
        $this->params = RouteParams::prepareParams($params);
    }

    /**
     * generate.
     *
     * @return \DOMDocument
     */
    public function generate()
    {
        $this->manager->init($this->params);
        $dom = $this->manager->createDomDocument();
        $this->manager->setDomDocument($dom);
        $root = $this->manager->getRootElement();

        return $this->manager->generate($this->params, $root);
    }

    /**
     * get File Name.
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->manager->getFileName();
    }
}
