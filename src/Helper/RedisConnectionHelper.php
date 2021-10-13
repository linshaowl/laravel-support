<?php

/**
 * (c) linshaowl <linshaowl@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lswl\Support\Helper;

use Illuminate\Redis\Connections\Connection;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;

/**
 * Redis链接辅助
 */
class RedisConnectionHelper
{
    /**
     * 获取默认 redis 操作句柄
     * @param string|null $name
     * @return Connection
     */
    public static function get(?string $name = null): Connection
    {
        return static::make('redis', true, '', $name);
    }

    /**
     * 获取默认无前缀 redis 操作句柄
     * @param string|null $name
     * @return Connection
     */
    public static function getNoPrefix(?string $name = null): Connection
    {
        return static::make('redis.no.prefix', false, '', $name);
    }

    /**
     * 获取 phpredis 驱动的操作句柄
     * @param string|null $name
     * @return PhpRedisConnection
     */
    public static function getPhpRedis(?string $name = null): PhpRedisConnection
    {
        return static::make('phpredis', true, 'phpredis', $name);
    }

    /**
     * 获取无前缀 phpredis 驱动的操作句柄
     * @param string|null $name
     * @return PhpRedisConnection
     */
    public static function getPhpRedisNoPrefix(?string $name = null): PhpRedisConnection
    {
        return static::make('phpredis.no.prefix', false, 'phpredis', $name);
    }

    /**
     * 创建并返回链接
     * @param string $id
     * @param string|null $name
     * @return Connection|PhpRedisConnection
     */
    protected static function make(
        string $id,
        bool $withPrefix = true,
        string $driver = '',
        ?string $name = null
    ) {
        // 存在
        if (app()->has($id)) {
            return app()->get($id)->connection($name);
        }

        // 配置
        $config = config('database.redis', []);

        // 不需要前缀
        if (!$withPrefix) {
            $config['options']['prefix'] = '';
        }

        // 驱动不存在
        if (empty($driver)) {
            $driver = Arr::pull($config, 'client', 'phpredis');
        }

        // 创建
        $redis = new RedisManager(app(), $driver, $config);

        // 单例
        app()->instance($id, $redis);

        // 链接
        return $redis->connection($name);
    }
}
