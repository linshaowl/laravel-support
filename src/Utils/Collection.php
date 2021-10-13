<?php

/**
 * (c) linshaowl <linshaowl@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lswl\Support\Utils;

use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\HigherOrderCollectionProxy;
use Lswl\Support\Traits\HidesAttributesTrait;

/**
 * 集合
 */
class Collection extends BaseCollection
{
    use HidesAttributesTrait;

    public function __get($key)
    {
        if (!in_array($key, static::$proxies)) {
            return $this->get($key);
        }

        return new HigherOrderCollectionProxy($this, $key);
    }

    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    public function __isset($name)
    {
        return $this->has($name);
    }

    public function __unset($name)
    {
        $this->offsetUnset($name);
    }
}
