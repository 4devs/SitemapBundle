<?php

namespace FDevs\SitemapBundle\Service;

abstract class AbstractManager
{
    /** @var \DOMDocument */
    protected $dom;

    /** @var string */
    protected $webPath;

    /** @var string */
    protected $filename;

    /** @var array */
    protected $attr = ['xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9'];

    /**
     * generate sitemap.
     *
     * @param array       $params
     * @param \DOMElement $element
     *
     * @return \DOMDocument
     */
    abstract public function generate(array $params = [], \DOMElement $element);

    /**
     * init service.
     *
     * @param array $params
     *
     * @return mixed
     */
    abstract public function init(array $params = []);

    /**
     * @return string
     */
    abstract protected function getRootName();

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function addAttribute($name, $value)
    {
        $this->attr[$name] = $value;

        return $this;
    }

    /**
     * get Root Element.
     *
     * @return \DOMElement
     */
    public function getRootElement()
    {
        $root = $this->dom->createElement($this->getRootName());
        $this->dom->appendChild($root);

        // Add attribute of root element
        foreach ($this->getAttributeList() as $attr => $namespace) {
            $xmlns = $this->dom->createAttribute($attr);
            $text = $this->dom->createTextNode($namespace);
            $root->appendChild($xmlns);
            $xmlns->appendChild($text);
        }

        return $root;
    }

    /**
     * set DomDocument.
     *
     * @param \DOMDocument $doc
     */
    public function setDomDocument(\DOMDocument $doc)
    {
        $this->dom = $doc;
    }

    /**
     * create Dom Document.
     *
     * @return \DOMDocument
     */
    public function createDomDocument()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $dom->substituteEntities = false;

        return $dom;
    }

    /**
     * get File Name.
     *
     * @param array  $params
     * @param string $dir
     *
     * @return string
     */
    public function getFileName(array $params = [], $dir = '')
    {
        $strParams = count($params) ? implode('.', $params).'.' : '';

        return $this->webPath.DIRECTORY_SEPARATOR.$dir.$strParams.$this->filename.'.xml';
    }

    /**
     * set File Name.
     *
     * @param string $filename
     *
     * @return $this
     */
    public function setFileName($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * get Namespace list.
     *
     * @return array
     */
    protected function getAttributeList()
    {
        return $this->attr;
    }
}
