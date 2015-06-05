<?php
/**
 * @author    Andrey Samusev <andrey_simfi@list.ru>
 * @copyright andrey 12/7/13
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FDevs\SitemapBundle\Adapter;

interface AdapterInterface
{
    /**
     * run commands before start iterate url
     *
     * @return self
     */
    public function init();

    /**
     * @param array $params
     *
     * @return self
     */
    public function setParams(array $params = array());

    /**
     * Gets the element of the collection at the current iterator position.
     *
     * @return \FDevs\SitemapBundle\Model\Url|null
     */
    public function current();

    /**
     * Moves the internal iterator position to the next element and returns this element.
     *
     * @return \FDevs\SitemapBundle\Model\Url|null
     */
    public function next();

    /**
     * Sets the internal iterator to the first element in the collection and returns this element.
     *
     * @return \FDevs\SitemapBundle\Model\Url|null
     */
    public function first();

    /**
     * Checks if current position is valid
     *
     * @return bool
     */
    public function valid();
}
