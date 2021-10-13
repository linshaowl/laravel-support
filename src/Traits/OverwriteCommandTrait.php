<?php

/**
 * (c) linshaowl <linshaowl@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lswl\Support\Traits;

/**
 * 重写 Command 类
 */
trait OverwriteCommandTrait
{
    public function option($key = null)
    {
        return $this->getCommandClass(parent::option($key));
    }

    public function argument($key = null)
    {
        return $this->getCommandClass(parent::argument($key));
    }

    /**
     * 获取命令行类名称
     * @param $value
     * @return mixed
     */
    protected function getCommandClass($value)
    {
        if (!is_string($value)) {
            return $value;
        }

        return preg_replace('/\/+/', '\\', trim($value, '/'));
    }
}
