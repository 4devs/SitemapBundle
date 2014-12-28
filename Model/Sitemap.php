<?php
/**
 * @author    Andrey Samusev <andrey_simfi@list.ru>
 * @copyright andrey 12/7/13
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FDevs\SitemapBundle\Model;

class Sitemap extends AbstractElement
{
    /**
     * @var string
     */
    private $loc;

    /**
     * @var \DateTime
     */
    private $lastmod;

    /**
     * init
     *
     * @param string    $loc
     * @param \DateTime $lastmod
     *
     */
    public function __construct($loc, \DateTime $lastmod = null)
    {
        $this->loc = $loc;
        $this->lastmod = $lastmod;
    }

    /**
     * {@inheritDoc}
     */
    public function getTags()
    {
        return ['loc', 'lastmod'];
    }

    /**
     * @param \DateTime $lastmod
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
        return $this->lastmod;
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
}
