<?php

/**
 * (c) linshaowl <linshaowl@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lswl\Support\Utils;

use GuzzleHttp\Client;
use Lswl\Support\Traits\InstanceTrait;

/**
 * 请求客户端
 */
class RequestClient extends Client
{
    use InstanceTrait;

    /**
     * @var string
     */
    protected $userAgent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36';

    public function __construct(array $config = [])
    {
        $default = [
            'verify' => false,
            'headers' => [
                'User-Agent' => $this->userAgent,
            ],
        ];
        parent::__construct($default + $config);
    }
}
