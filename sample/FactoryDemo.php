<?php

require __DIR__ . '/../vendor/autoload.php';

use Sxqibo\FastIp\IpCityFactory;

$appcode = '';
$config  = ['appcode' => $appcode];

$ipAdd = '39.144.96.133';
//$ipAdd = 'localhost';
//$ipAdd = '171.117.41.151';

print '----------------------' . PHP_EOL;
$obj = IpCityFactory::getIpCityObject('111');
$addr = $obj->getIpCity($ipAdd);
print '1.默认的太平洋的接口' . json_encode($addr, JSON_UNESCAPED_UNICODE) . PHP_EOL;

print '----------------------' . PHP_EOL;
$obj = IpCityFactory::getIpCityObject('aliyun', $config);
$addr = $obj->getIpCity($ipAdd);
print '2.阿里云的接口' . json_encode($addr, JSON_UNESCAPED_UNICODE) . PHP_EOL;

print '----------------------' . PHP_EOL;
$obj = IpCityFactory::getIpCityObject('baidu');
$addr = $obj->getIpCity($ipAdd);
print '3.百度的接口' . json_encode($addr, JSON_UNESCAPED_UNICODE) . PHP_EOL;

print '----------------------' . PHP_EOL;
$obj = IpCityFactory::getIpCityObject('online');
$addr = $obj->getIpCity($ipAdd);

print '4.太平洋的接口' . json_encode($addr, JSON_UNESCAPED_UNICODE) . PHP_EOL;
