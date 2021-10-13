<?php

/**
 * (c) linshaowl <linshaowl@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lswl\Support\Utils;

use Illuminate\Http\Request;

/**
 * 请求信息
 */
class RequestInfo
{
    /**
     * 获取
     * @return string
     */
    public static function get(): string
    {
        $request = request();
        $data = json_encode($request->all(), JSON_UNESCAPED_UNICODE);
        $headers = static::getJsonHeaders($request);
        return <<<EOL
ip : {$request->ip()}
referer : {$request->server('HTTP_REFERER', '-')}
user_agent : {$request->server('HTTP_USER_AGENT', '-')}
method : {$request->method()}
url : {$request->fullUrl()}
headers : {$headers}
data : {$data}
EOL;
    }

    /**
     * 获取参数
     * @param Request $request
     * @param string $name
     * @param null $default
     * @param bool $isset
     * @return mixed
     */
    public static function getParam(Request $request, string $name, $default = null, bool $isset = false)
    {
        $param = $request->header(ucwords(str_replace('_', '-', $name), '-'), $default);
        $isset = $isset ? isset($param) : (!empty($param));
        if (!$isset) {
            $param = $request->input($name, $default);
        }

        return $param;
    }

    /**
     * 获取 json 格式请求头
     * @param Request $request
     * @return false|string
     */
    protected static function getJsonHeaders(Request $request)
    {
        $headers = [];
        foreach ($request->headers as $k => $v) {
            $headers[$k] = $v[0];
        }

        return json_encode($headers, JSON_UNESCAPED_UNICODE);
    }
}
