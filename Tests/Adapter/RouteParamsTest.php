<?php

namespace FDevs\SitemapBundle\Tests\Adapter;

use FDevs\SitemapBundle\Adapter\RouteParams;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouteParamsTest extends WebTestCase
{
    public function testPrepareParams()
    {
        $num = mt_rand(3, 5);
        $mun = mt_rand(1, 4);
        $data = array_fill(0, $num, array_fill(0, $mun, 'value'));
        $result = RouteParams::prepareParams($data);

        $this->assertCount(pow($mun, $num), $result);
    }
}
