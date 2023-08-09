<?php

namespace Sxqibo\FastIp\IpCity;

use Sxqibo\FastIp\IpCityInterface;
use Sxqibo\FastIp\util\HttpUtil;

/**
 * 获取 IP 地址的基类
 */
abstract class IpCity implements IpCityInterface
{
    /**
     * @var string ip地址 或 主机地址
     */
    public $host = '';

    /**
     * @var string api 的 uri
     */
    public $uri = '';

    /**
     * @var array 配置
     */
    public array $config = [];

    /**
     * 构造一般用于接收 http 请求时的参数
     *      比如 请求阿里接口时需要带 appcode
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * 帮子类调用 http 请求
     *
     * @param string $ipAddress
     * @return mixed|string
     */
    public function getIpCity(string $ipAddress)
    {
        $query = [
            'ip' => $ipAddress
        ];

        return HttpUtil::request($query, $this->uri, $this->host, $this->config);
    }

    public static function getIpCityForStatic(string $ipAddress, array $config = [])
    {
        // TODO: Implement getIpCityForStatic() method.
    }
}
