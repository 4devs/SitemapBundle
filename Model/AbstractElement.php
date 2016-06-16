<?php

namespace FDevs\SitemapBundle\Model;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

abstract class AbstractElement implements ExtendedElementInterface
{
    /**
     * @var array
     */
    private $namespace = [];

    /**
     * @var PropertyAccessor
     */
    private $propertyAccessor;

    /**
     * @param \DOMDocument $dom
     *
     * @return \DOMElement
     */
    public function getElement(\DOMDocument $dom)
    {
        $element = $dom->createElement($this->getName());

        foreach ($this->getTags() as $tag) {
            if ($val = $this->getTagValue($tag)) {
                $this->appendChild($dom, $tag, $val, $element);
            }
        }
        $children = $this->getChildren();
        foreach ($children as $child) {
            $this->appendExtendingElement($dom, $element, $child);
        }

        return $element;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    protected function getTagValue($name)
    {
        if (!$this->propertyAccessor) {
            $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        }

        return $this->propertyAccessor->getValue($this, $name);
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
     * @param \DOMDocument             $dom
     * @param \DOMElement              $element
     * @param ExtendedElementInterface $extendingElement
     *
     * @return \DOMElement
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

        return $el;
    }

    /**
     * @param \DOMDocument      $dom
     * @param \DOMElement       $element
     * @param string            $name
     * @param string|null|array $val
     *
     * @return \DOMElement
     */
    private function appendChild(\DOMDocument $dom, $name, $val, \DOMElement $element = null)
    {
        $element = $element ?: $dom->createElement($name);
        $el = null;
        if (is_array($val)) {
            foreach ($val as $name => $item) {
                if ($item instanceof ExtendedElementInterface) {
                    $el = $this->appendExtendingElement($dom, $element, $item);
                } else {
                    $el = $this->appendChild($dom, $name, $item, $element);
                }
            }
        } else {
            $el = $dom->createElement($name, $val);
            $element->appendChild($el);
        }

        return $el ?: $element;
    }
}
