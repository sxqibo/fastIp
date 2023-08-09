# 根据 IP 获取 归属地

做后整理日期：2023-08-09

## 一、介绍

本 composer 包实现了 3 个接口，分别是

- 太平洋：https://whois.pconline.com.cn/ipJson.jsp?ip=8.8.8.8
- 百度：https://qifu-api.baidubce.com/ip/geo/v1/district?ip=39.144.96.133
- 阿里云：https://market.aliyun.com/products/57002003/cmapi021970.html#sku=yuncode15970000020

其中，太平洋 和 百度 是免费的，阿里云 是按此收费。

太平洋 请求成功率高，但是返回的信息较少；

百度 请求频繁会限流，但是返回的信息较多；

阿里云 请求成功率高，返回的信息较多，但是按次收费。


## 二、使用方法

### 1、引入

引入方式是直接使用 composer 命令引入即可

```shell
composer require sxqibo/fast-ip
```

### 2、实例化

实例化的方式是通过工厂方式进行实例化的
```php
$obj = IpCityFactory::getIpCityObject('online');
```

该工厂通过参数获取对应的具体实现类，目前支持的参数有：
- online
- baidu
- aliyun

如果没有找到传入的类，则默认返回 online 的

### 3、调用方法

调用方法有两种方式，一种方式调用实例方法，另外一种方法是调用静态方法

#### （1）调用实例方法

调用实例方法，需要通过工厂实例化后调用 `getIpCity` 方法得到 `归属地`

```php
$obj = IpCityFactory::getIpCityObject('online');
$addr = $obj->getIpCity($ipAdd);
```

#### （2）调用静态方法

直接调用实现类下的静态方法即可

```php
$addr = IpCityForOnline::getIpCityForStatic($ipAdd);
```

*注意：目前静态方法只有 IpCityForOnline 实现了，其他的都没有实现*

### 4、返回结果

返回结果是数组，数组分为两部分：
1. 一部分是 格式化 后的通用数据，其中保存了 省、市、县（区）
2. 一部分是接口返回的原始数据，原始数据字段多少各不相同，不太方便实用

其中 格式化 后的部分在 `'data'` 中，原始数据在 `'org'` 中

#### （1）举例

##### a、阿里云

```json
{
    "data": {
        "continent": "",
        "country": "中国",
        "prov": "山西",
        "city": "大同",
        "district": "",
        "isp": "移动",
        "addr": ""
    },
    "org": {
        "data": {
            "ip": "39.144.96.133",
            "long_ip": "663773317",
            "isp": "移动",
            "area": "华北",
            "region_id": "140000",
            "region": "山西",
            "city_id": "140200",
            "city": "大同",
            "district": "",
            "district_id": "",
            "country_id": "CN",
            "country": "中国"
        },
        "ret": 200,
        "msg": "success",
        "log_id": "6dad820f8e5746649a9d1df1bc5a6e91"
    }
}
```

##### b、百度

```json
{
    "data": {
        "continent": "亚洲",
        "country": "中国",
        "prov": "山西省",
        "city": "朔州市",
        "district": "",
        "isp": "中国移动",
        "addr": ""
    },
    "org": {
        "code": "Success",
        "data": {
            "continent": "亚洲",
            "country": "中国",
            "zipcode": "036000",
            "timezone": "UTC+8",
            "accuracy": "城市",
            "owner": "中国移动",
            "isp": "中国移动",
            "source": "数据挖掘",
            "areacode": "CN",
            "adcode": "140600",
            "asnumber": "56042",
            "lat": "39.330645",
            "lng": "112.466666",
            "radius": "79.8028",
            "prov": "山西省",
            "city": "朔州市",
            "district": ""
        },
        "charge": true,
        "msg": "查询成功",
        "ip": "39.144.96.133",
        "coordsys": "WGS84"
    }
}
```

##### c、太平洋

```json
{
    "data": {
        "continent": "",
        "country": "",
        "prov": "山西省",
        "city": "",
        "district": "",
        "isp": "",
        "addr": "山西省 "
    },
    "org": {
        "ip": "39.144.96.133",
        "pro": "山西省",
        "proCode": "140000",
        "city": "",
        "cityCode": "0",
        "region": "",
        "regionCode": "0",
        "addr": "山西省 ",
        "regionNames": "",
        "err": "nocity"
    }
}
```


## 三、备注

下面是各个接口返回的数据的格式

### 1、阿里云

```json
{
    "data": {
        "ip": "39.144.96.133",
        "long_ip": "663773317",
        "isp": "移动",
        "area": "华北",
        "region_id": "140000",
        "region": "山西",
        "city_id": "140200",
        "city": "大同",
        "district": "",
        "district_id": "",
        "country_id": "CN",
        "country": "中国"
    },
    "ret": 200,
    "msg": "success",
    "log_id": "9f1a7a9fbd7440b2aa17eacf558c30b6"
}
```

### 2、百度

```json
{
    "code": "Success",
    "data": {
        "continent": "亚洲",
        "country": "中国",
        "zipcode": "036000",
        "timezone": "UTC+8",
        "accuracy": "城市",
        "owner": "中国移动",
        "isp": "中国移动",
        "source": "数据挖掘",
        "areacode": "CN",
        "adcode": "140600",
        "asnumber": "56042",
        "lat": "39.330645",
        "lng": "112.466666",
        "radius": "79.8028",
        "prov": "山西省",
        "city": "朔州市",
        "district": ""
    },
    "charge": false,
    "msg": "查询成功",
    "ip": "39.144.96.133",
    "coordsys": "WGS84"
}
```

### 3、太平洋

```json
{
    "ip": "39.144.96.133",
    "pro": "山西省",
    "proCode": "140000",
    "city": "",
    "cityCode": "0",
    "region": "",
    "regionCode": "0",
    "addr": "山西省 ",
    "regionNames": "",
    "err": "nocity"
}
```

## 四、报错处理

若出现错误如下：
Fatal error: Uncaught GuzzleHttp\Exception\RequestException: cURL error 60: SSL certificate problem: unable to get local issuer certificate (see https://curl.haxx.se/libcurl/… in xxx.php

其原因是由于本地的CURL的SSL证书太旧了，导致不识别此证书。

解决方法
1. 从 http://curl.haxx.se/ca/cacert.pem 下载一个最新的证书。然后保存到一个任意目录。
2. 然后把catr.pem放到php的bin目录下，然后编辑php.ini，用记事本或者notepad++打开 php.ini文件，大概在1932行。
   去掉curl.cainfo前面的注释“;”，然后在后面写上cacert.pem证书的完整路径及文件名，我的如下：
3. curl.cainfo = /Applications/EasySrv/software/php/php-8.2/bin/cacert.pem

