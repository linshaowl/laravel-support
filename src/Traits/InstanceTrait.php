<?php

/**
 * (c) linshaowl <linshaowl@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lswl\Support\Traits;

use Lswl\Support\Utils\Helper;

/**
 * 单例类 Trait
 */
trait InstanceTrait
{
    /**
     * 获取实例
     * @param array $params
     * @return static
     */
    public static function getInstance(array $params = [])
    {
        return Helper::instance(get_called_class(), false, $params);
    }
}
