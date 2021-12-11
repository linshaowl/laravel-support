<?php

/**
 * (c) linshaowl <linshaowl@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lswl\Support\Utils;

use Illuminate\Container\Container;
use Illuminate\Support\Arr;

/**
 * 辅助
 */
class Helper
{
    /**
     * 转换成布尔值
     * @param mixed $value
     * @return bool
     */
    public static function boolean($value): bool
    {
        if (is_bool($value)) {
            return $value;
        } elseif ($value === 'true') {
            return true;
        } elseif ($value === 'false') {
            return false;
        }

        return !!$value;
    }

    /**
     * 数值转金钱
     * @param int|float $value
     * @return float
     */
    public static function int2money($value): float
    {
        return round($value / 100, 2);
    }

    /**
     * 金钱转数值
     * @param int|float $value
     * @return int
     */
    public static function money2int($value): int
    {
        return intval($value * 100);
    }

    /**
     * 处理提示数量
     * @param int $num
     * @param int $max
     * @param int $min
     * @return string
     */
    public static function handleNoticeNum(int $num, int $max = 99, int $min = 0): string
    {
        return (string)($num > $max ? $max . '+' : (($num > $min) ? $num : $min));
    }

    /**
     * 格式化时间
     * @param int $time
     * @param string $format
     * @param string $suffixFormat
     * @return string
     */
    public static function beautifyTime(
        int $time,
        string $format = 'Y-m-d H:i:s',
        string $suffixFormat = 'H:i:s'
    ): string {
        return (new BeautifyTime($time, $format, $suffixFormat))->run();
    }

    /**
     * 是否一维数组
     * @param array $arr
     * @return bool
     */
    public static function isOneDimensional(array $arr): bool
    {
        return count($arr) == count($arr, COUNT_RECURSIVE);
    }

    /**
     * 数组转换成key
     * @param array $arr
     * @param string $flag
     * @return string
     */
    public static function array2key(array $arr, string $flag = ''): string
    {
        return md5(json_encode(Arr::sortRecursive($arr)) . $flag);
    }

    /**
     * 单例辅助
     * @param string $class
     * @param bool $refresh
     * @param array $params
     * @return mixed
     */
    public static function instance(string $class, bool $refresh = false, array $params = [])
    {
        $id = static::array2key($params, $class);
        if (!Container::getInstance()->has($id) || $refresh) {
            Container::getInstance()->instance($id, Container::getInstance()->make($class, $params));
        }

        return Container::getInstance()->get($id);
    }
}
