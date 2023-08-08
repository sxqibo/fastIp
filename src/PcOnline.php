<?php

namespace Sxqibo\FastIp;

use GuzzleHttp\Client;

class PcOnline
{
    const HOST = 'https://whois.pconline.com.cn';

    const IP_JSON = '/ipJson.jsp';

    public function __construct()
    {
    }

    public function getIpCity(string $ipAddress)
    {
        $query = [
            'ip' => $ipAddress
        ];

        return $this->request($query, self::IP_JSON);
    }

    private function request($query, string $apiUri): string
    {
        $uri = http_build_query($query);

        $client   = new Client();
        $response = $client->request('GET', self::HOST . $apiUri . '?' . $uri);

        return (string)$response->getBody();
    }
}

//$obj = new IpCityForPcOnline();
//$obj->getIpCity('39.144.96.133');
