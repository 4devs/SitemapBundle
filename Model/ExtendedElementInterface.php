<?php

namespace FDevs\SitemapBundle\Model;


interface ExtendedElementInterface extends ElementInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string|null
     */
    public function getValue();

    /**
     * @return ExtendedElementInterface[]
     */
    public function getChildren();

    /**
     * @return array
     */
    public function getAttr();

    /**
     * @return array
     */
    public function getNamespace();
}