<?php

namespace Sxqibo\FastIp;

/**
 * ip 地址转换 归属地 统一都是用该方法名
 */
interface IpCityInterface
{
    /**
     * 获取 ip 地址对应的 归属地
     *
     * @param string $ipAddress ip 地址
     * @return mixed
     */
    public function getIpCity(string $ipAddress);

    public static function getIpCityForStatic(string $ipAddress, array $config = []);
}
