<?php

namespace Sxqibo\FastIp\IpCity;

use Sxqibo\FastIp\IpCityInterface;
use Sxqibo\FastIp\util\HttpUtil;

/**
 * 太平洋接口的实现类
 * https://whois.pconline.com.cn/ipJson.jsp?ip=8.8.8.8
 */
final class IpCityForOnline extends IpCity implements IpCityInterface
{
    /**
     * @var string ip地址 或 主机地址
     */
    const HOST = 'https://whois.pconline.com.cn';

    /**
     * @var string api 的 uri
     */
    const URI = '/ipJson.jsp';

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
        $result = mb_convert_encoding($result, 'utf-8', 'GB2312');

        $addr = json_decode(str_replace(');}', '', str_replace('if(window.IPCallBack) {IPCallBack(', '', trim($result))), true);

        return [
            'data' => [
                'continent' => '',
                'country' => '',
                'prov' => $addr['pro'],
                'city' => $addr['city'],
                'district' => '',
                'isp' => '',
                'addr' => $addr['addr'],
            ],
            'org' => $addr
        ];
    }

    /**
     * 获取 ip 地址对应的归属地
     *
     * @param string $ipAddress ip 地址
     * @param array $config 配置，和构造的配置相同
     * @return array|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getIpCityForStatic(string $ipAddress, array $config = [])
    {
        $query = [
            'ip' => $ipAddress
        ];

        $result = HttpUtil::request($query, self::URI, self::HOST);

        return (new IpCityForOnline($config))->standardResult($result);
    }
}
