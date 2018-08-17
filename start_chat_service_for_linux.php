<?php

/**
 * run with command
 * php start.php start
 */
ini_set('display_errors', 'on');

use Workerman\Worker;

if (strpos(strtolower(PHP_OS), 'win') === 0) {
    exit("start_chat_service_for_linux.php 只能运行在linux下,如果是windows请运行 start_chat_service_for_win.bat\n");
}

// 检查扩展
if (!extension_loaded('pcntl')) {
    exit("请安装 pcntl 扩展. 查看 http://doc3.workerman.net/appendices/install-extension.html\n");
}

if (!extension_loaded('posix')) {
    exit("请安装 posix 扩展. 查看 http://doc3.workerman.net/appendices/install-extension.html\n");
}

// 标记是全局启动
define('GLOBAL_START', 1);

require_once __DIR__ . '/vendor/autoload.php';

// 加载所有Applications/*/start.php，以便启动所有服务
foreach (glob(__DIR__ . '/application/lp_worker_im/gatewayworker/start_linux*.php') as $start_file) {
    require_once $start_file;
}
// 运行所有服务
Worker::runAll();

