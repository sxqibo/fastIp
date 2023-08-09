<?php

namespace Sxqibo\FastIp\IpCity;

use Sxqibo\FastIp\IpCityInterface;

/**
 * 阿里云的实现接口
 * https://market.aliyun.com/products/57002003/cmapi021970.html#sku=yuncode15970000020
 */
final class IpCityForAliyun extends IpCity implements IpCityInterface
{
    /**
     * @var string ip地址 或 主机地址
     */
    const HOST = 'https://c2ba.api.huachen.cn';

    /**
     * @var string api 的 uri
     */
    const URI = '/ip';

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

        if ($result['ret'] != 200) {
            return $result['msg'];
        }

        return [
            'data' => [
                'continent' => '',
                'country' => $result['data']['country'],
                'prov' => $result['data']['region'],
                'city' => $result['data']['city'],
                'district' => $result['data']['district'],
                'isp' => $result['data']['isp'],
                'addr' => $result['data']['region'] . $result['data']['city'] . $result['data']['district'] . ' ' . $result['data']['isp']
            ],
            'org' => $result
        ];
    }
}
