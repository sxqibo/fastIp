<?php

use Sxqibo\FastIp\PcOnline;

require __DIR__ . '/../vendor/autoload.php';

$obj = new PcOnline();
$result = $obj->getIpCity('39.144.96.133');
print_r($result);