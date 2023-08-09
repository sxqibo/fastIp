<?php

use Sxqibo\FastIp\IpCity\IpCityForOnline;

require __DIR__ . '/../vendor/autoload.php';

$appcode = '';
$config = ['appcode' => $appcode];

$ipAdd = '39.144.96.133';
//$ipAdd = 'localhost';
//$ipAdd = '171.117.41.151';

print '----------------------' . PHP_EOL;
$addr = IpCityForOnline::getIpCityForStatic($ipAdd);
print '1.' . json_encode($addr, JSON_UNESCAPED_UNICODE) . PHP_EOL;

