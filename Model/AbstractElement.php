<?php
namespace FDevs\SitemapBundle\Model;

abstract class AbstractElement implements ElementInterface
{
    public function getElement(\DOMDocument $dom)
    {
        $name = trim(strrchr(strtolower(get_called_class()), '\\'), '\\');
        $element = $dom->createElement($name);

        foreach ($this->getTags() as $tag) {
            if ($val = $this->{'get'.ucfirst($tag)}()) {
                $el = $dom->createElement($tag, $val);
                $element->appendChild($el);
            }
        }

        return $element;
    }
}
