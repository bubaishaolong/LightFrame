<?php

use \Workerman\Worker;
use \GatewayWorker\Register;

include "gateway_config.php";

// register 服务必须是text协议
$register = new Register("text://$register_ip:" . $register_port);

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

