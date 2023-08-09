<?php

namespace Sxqibo\FastIp\IpCity;

use Sxqibo\FastIp\IpCityInterface;

/**
 * 百度接口的实现类
 * https://qifu-api.baidubce.com/ip/geo/v1/district?ip=39.144.96.133
 */
final class IpCityForBaidu extends IpCity implements IpCityInterface
{
    /**
     * @var string ip地址 或 主机地址
     */
    const HOST = 'https://qifu-api.baidubce.com';

    /**
     * @var string api 的 uri
     */
    const URI = '/ip/geo/v1/district';

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->host = self::HOST;
        $this->uri = self::URI;
    }

    /**
     * 获取 ip 地址对应的归属地
     *
     * @param string $ipAddress
     * @return mixed
     */
    public function getIpCity(string $ipAddress)
    {
        $result = parent::getIpCity($ipAddress);

        return $this->standardResult($result);
    }

    /**
     * 对请求结果的处理
     *
     * @param $result
     * @return array
     */
    private function standardResult($result)
    {
        $result = json_decode($result, true);

        if ($result['code'] != 'Success') {
            return $result['msg'];
        }

        return [
            'data' => [
                'continent' => $result['data']['continent'],
                'country' => $result['data']['country'],
                'prov' => $result['data']['prov'],
                'city' => $result['data']['city'],
                'district' => $result['data']['district'],
                'isp' => $result['data']['isp'],
                'addr' => ''
            ],
            'org' => $result
        ];
    }
}
