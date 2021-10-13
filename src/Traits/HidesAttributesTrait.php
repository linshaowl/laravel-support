<?php

/**
 * (c) linshaowl <linshaowl@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lswl\Support\Traits;

use Closure;
use Lswl\Support\Utils\Helper;

/**
 * 隐藏属性 Trait
 */
trait HidesAttributesTrait
{
    /**
     * 隐藏属性
     * @var array
     */
    protected $hidden = [];

    /**
     * 显示属性
     * @var array
     */
    protected $visible = [];

    /**
     * 获取隐藏属性
     * @return array
     */
    public function getHidden(): array
    {
        return $this->hidden;
    }

    /**
     * 设置隐藏属性
     * @param array $hidden
     * @return self
     */
    public function setHidden(array $hidden): self
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * 获取显示属性
     * @return array
     */
    public function getVisible(): array
    {
        return $this->visible;
    }

    /**
     * 设置显示属性
     * @param array $visible
     * @return self
     */
    public function setVisible(array $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * 创建显示属性
     * @param array|string|null $attributes
     * @return self
     */
    public function makeVisible($attributes): self
    {
        $attributes = is_array($attributes) ? $attributes : func_get_args();

        $this->hidden = array_diff($this->hidden, $attributes);

        $this->visible = array_merge($this->visible, $attributes);

        return $this;
    }

    /**
     * 判断创建显示属性
     * @param bool|Closure $condition
     * @param array|string|null $attributes
     * @return self
     */
    public function makeVisibleIf($condition, $attributes): self
    {
        $condition = $condition instanceof Closure ? $condition($this) : $condition;

        return $condition ? $this->makeVisible($attributes) : $this;
    }

    /**
     * 创建隐藏属性
     * @param array|string|null $attributes
     * @return self
     */
    public function makeHidden($attributes): self
    {
        $this->hidden = array_merge(
            $this->hidden,
            is_array($attributes) ? $attributes : func_get_args()
        );

        return $this;
    }

    /**
     * 判断创建隐藏属性
     * @param bool|Closure $condition
     * @param array|string|null $attributes
     * @return self
     */
    public function makeHiddenIf($condition, $attributes): self
    {
        $condition = $condition instanceof Closure ? $condition($this) : $condition;

        return ($condition instanceof Closure ? $condition() : $condition) ? $this->makeHidden($attributes) : $this;
    }

    /**
     * 递归隐藏属性
     * @param array $arr
     * @return array
     */
    private function hideAttributeRecursive(array $arr): array
    {
        if (Helper::isOneDimensional($arr)) {
            return $this->hideAttribute($arr);
        }

        $results = [];
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $results[$k] = $this->hideAttributeRecursive($v);
            } else {
                $results[$k] = $v;
            }
        }
        return $results;
    }

    /**
     * 隐藏属性
     * @param array $arr
     * @return array
     */
    private function hideAttribute(array $arr): array
    {
        if (count($this->getVisible()) > 0) {
            $arr = array_intersect_key($arr, array_flip($this->getVisible()));
        }

        if (count($this->getHidden()) > 0) {
            $arr = array_diff_key($arr, array_flip($this->getHidden()));
        }

        return $arr;
    }

    public function all(): array
    {
        return $this->hideAttributeRecursive($this->items);
    }
}
