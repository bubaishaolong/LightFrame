#  PHP-JWT

登陆认证、web api接口调用 token  


## 安装

>composer require lmxdawn/php-jwt

## 示例
```php

$key = "example_key";
$time = time();
//var_dump($time);exit;
$token = array(
    "iss" => "http://example.org",//该JWT的签发者
    "aud" => "http://example.com",//接收该JWT的一方
    "sub" => "xxx@example.com",//该JWT所面向的用户
    "iat" => $time,//在什么时候签发的
    "exp" => $time,// 什么时候过期，这里是一个Unix时间戳

);

echo '<pre>';

$jwt = \lmxdawn\jwt\JWT::encode($token, $key,'HS256');
$decoded = \lmxdawn\jwt\JWT::decode($jwt, $key, array('HS256'));
var_dump($decoded);exit;

print_r($decoded);

$decoded_array = (array) $decoded;

/**
 * 您可以添加一个余地来考虑当存在倍之间的时钟偏差，最好不超过几分钟
 */
\lmxdawn\jwt\JWT::$leeway = 60; // $leeway in seconds
$decoded = \lmxdawn\jwt\JWT::decode($jwt, $key, array('HS256'));

print_r($decoded);
```
    

