<?php

namespace FDevs\SitemapBundle\Model;

abstract class AbstractElement implements ExtendedElementInterface
{
    /**
     * @var array
     */
    private $namespace = [];

    /**
     * @param \DOMDocument $dom
     *
     * @return \DOMElement
     */
    public function getElement(\DOMDocument $dom)
    {
        $element = $dom->createElement($this->getName());

        foreach ($this->getTags() as $tag) {
            if ($val = $this->{'get'.ucfirst($tag)}()) {
                $el = $dom->createElement($tag, $val);
                $element->appendChild($el);
            }
        }
        $children = $this->getChildren();
        foreach ($children as $child) {
            $this->appendExtendingElement($dom, $element, $child);
        }

        return $element;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return trim(strrchr(strtolower(get_called_class()), '\\'), '\\');
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
    }

    /**
     * @inheritDoc
     */
    public function getChildren()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAttr()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param \DOMDocument              $dom
     * @param \DOMElement               $element
     * @param ExtendedElementInterface $extendingElement
     */
    private function appendExtendingElement(\DOMDocument $dom, \DOMElement $element, ExtendedElementInterface $extendingElement)
    {
        $el = $this->appendChild($dom, $element, $extendingElement->getName(), $extendingElement->getValue());
        foreach ($extendingElement->getAttr() as $name => $value) {
            $xmlns = $dom->createAttribute($name);
            $text = $dom->createTextNode($value);
            $el->appendChild($xmlns);
            $xmlns->appendChild($text);
        }
        $children = $extendingElement->getChildren();
        foreach ($children as $child) {
            $this->appendExtendingElement($dom, $element, $child);
        }
        $this->namespace = array_merge($this->namespace, $extendingElement->getNamespace());
    }

    /**
     * @param \DOMDocument $dom
     * @param \DOMElement  $element
     * @param string       $name
     * @param string|null  $val
     *
     * @return \DOMElement
     */
    private function appendChild(\DOMDocument $dom, \DOMElement $element, $name, $val)
    {
        $el = $dom->createElement($name, $val);
        $element->appendChild($el);

        return $el;
    }
}
