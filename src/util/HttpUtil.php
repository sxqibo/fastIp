<?php

namespace Sxqibo\FastIp\util;

use GuzzleHttp\Client;

/**
 * Http 的工具类
 */
class HttpUtil
{
    /**
     * 请求类
     *
     * @param array $query 一般就是请求的 ip 地址
     * @param string $apiUri 请求的接口名
     * @param string $host 请求的主机地址
     * @param array $config 请求的头信息，比如请求阿里接口需要带 appcode
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function request($query, string $apiUri, string $host, array $config = []): string
    {
        $headers = [];

        // 后续有其他 http 头可以在这里扩展
        if (count($config) > 0) {
            if (!empty($config['appcode'])) {
                $headers['Authorization'] = 'APPCODE ' . $config['appcode'];
            }
        }

        $uri = http_build_query($query);

        $client   = new Client();
        $response = $client->request('GET', $host . $apiUri . '?' . $uri, [
            'headers' => $headers
        ]);

        return (string)$response->getBody();
    }
}
