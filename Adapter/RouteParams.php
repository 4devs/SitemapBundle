<?php
/**
 * @author    Andrey Samusev <andrey_simfi@list.ru>
 * @copyright andrey 12/7/13
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FDevs\SitemapBundle\Adapter;

class RouteParams
{
    public static function prepareParams($params = array())
    {
        $positions = array_combine(array_keys($params), array_fill(0, count($params), 0));
        $data = [];

        do {
            $data[] = self::getByIndexes($params, $positions);
        } while (self::updateIndexesToNextIteration($params, $positions));

        return $data;
    }

    private static function getByIndexes(array $original, array $positions)
    {
        $result = [];

        foreach ($positions as $key => $position) {
            $result[$key] = $original[$key][$position];
        }

        return $result;
    }

    private static function updateIndexesToNextIteration(array $original, array &$positions)
    {
        // increment position
        $incremented = false;
        foreach ($positions as $key => $position) {
            ++$position;
            if ($position < count($original[$key])) {
                $positions[$key] = $position;
                $incremented = true;
                break;
            } else {
                $positions[$key] = 0;
            }
        }

        return $incremented;
    }
}
