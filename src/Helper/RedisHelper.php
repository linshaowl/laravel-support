<?php

/**
 * (c) linshaowl <linshaowl@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lswl\Support\Helper;

use Illuminate\Redis\Connections\Connection;

/**
 * Redis辅助
 */
class RedisHelper
{
    /**
     * 扫描匹配的键
     * @param Connection $connection
     * @param string $match
     * @param int $count
     * @param int|null $cursor
     * @return array
     */
    public static function scanKeys(Connection $connection, string $match, int $count = 10, ?int $cursor = null): array
    {
        $res = [];

        // 扫描
        [$index, $data] = $connection->scan($cursor, [
            'match' => $match,
            'count' => $count,
        ]);

        // 游标存在
        if (!empty($index)) {
            $res = array_merge($res, static::scanKeys($connection, $match, $count, $index));
        }

        // 数据存在
        if (!empty($data)) {
            $res = array_merge($res, $data);
        }

        return $res;
    }
}
