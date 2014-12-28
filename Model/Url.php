<?php
/**
 * @author    Andrey Samusev <andrey_simfi@list.ru>
 * @copyright andrey 12/7/13
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FDevs\SitemapBundle\Model;

class Url extends AbstractElement
{
    /**
     * @var string
     */
    private $loc;

    /**
     * @var \DateTime
     */
    private $lastmod = null;

    /**
     * @var string
     */
    private $changefreq;

    /**
     * @var float
     */
    private $priority = 0.7;

    /**
     * init
     *
     * @param string $loc
     */
    public function __construct($loc)
    {
        $this->loc = $loc;
    }

    /**
     * get Tags
     *
     * @return array
     */
    public function getTags()
    {
        return array('loc', 'lastmod', 'changefreq', 'priority');
    }

    /**
     * @param string $changefreq
     *
     * @return $this
     */
    public function setChangefreq($changefreq)
    {
        $this->changefreq = $changefreq;

        return $this;
    }

    /**
     * @return string
     */
    public function getChangefreq()
    {
        return $this->changefreq ?: ChangeFrequency::WEEKLY;
    }

    /**
     * @param \DateTime|null $lastmod
     *
     * @return $this
     */
    public function setLastmod(\DateTime $lastmod = null)
    {
        $this->lastmod = $lastmod;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastmod()
    {
        return $this->lastmod ? $this->lastmod->format('Y-m-d') : null;
    }

    /**
     * @param string $loc
     *
     * @return $this
     */
    public function setLoc($loc)
    {
        $this->loc = $loc;

        return $this;
    }

    /**
     * @return string
     */
    public function getLoc()
    {
        return $this->loc;
    }

    /**
     * @param float $priority
     *
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
