<?php

use \Workerman\Worker;
use \Workerman\WebServer;
use \GatewayWorker\Gateway;
use \GatewayWorker\BusinessWorker;
use \Workerman\Autoloader;

include "gateway_config.php";

// gateway 进程，这里使用Text协议，可以用telnet测试
//tcp://0.0.0.0:8282
//websocket://0.0.0.0:8282
$gateway = new Gateway("Websocket://0.0.0.0:7272");
// gateway名称，status方便查看
$gateway->name = 'z9168';
// gateway进程数
$gateway->count = 4;
// 本机ip，分布式部署时使用内网ip
$gateway->lanIp = $register_ip;
// 内部通讯起始端口，假如$gateway->count=4，起始端口为4000
// 则一般会使用4000 4001 4002 4003 4个端口作为内部通讯端口
$gateway->startPort = 2900;
// 服务注册地址
$gateway->registerAddress = "$register_ip:" . $register_port;

// 心跳间隔
$gateway->pingInterval = 60;
//连续监测心跳的次数
$gateway->pingNotResponseLimit = 2;
// 心跳数据
$gateway->pingData = '{"type":"ping"}';

  // 当客户端连接上来时，设置连接的onWebSocketConnect，即在websocket握手时的回调
//  $gateway->onConnect = function($connection) {
//      $connection->onWebSocketConnect = function($connection , $http_header) {
//          $pingInterval = Gateway::$pingInterval;
//          $pingNotResponseLimit = Gateway::$pingNotResponseLimit;
//          if($pingNotResponseLimit*$pingInterval>120){
//              $connection->close();
//          }
//      };
//  };


// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

