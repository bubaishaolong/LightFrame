<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/21
 * Time: 16:59
 */

namespace app\gatewayworker\home;


use GatewayWorker\Lib\Gateway;

class Events
{
    /**
     * 有消息时
     * @param integer $client_id 连接的客户端
     * @param mixed $message
     * @return void
     */
    public static function onMessage($client_id, $message)
    {
        // debug
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:".json_encode($_SESSION)." onMessage:".$message."\n";
    }

    /**
     * 当用户连接时触发的方法
     * @param integer $client_id 连接的客户端
     * @return void
     */
    public static function onConnect($client_id)
    {
        Gateway::sendToClient($client_id, "Your client_id is $client_id");
    }

    /**
     * 当用户断开连接时触发的方法
     * @param integer $client_id 断开连接的客户端
     * @return void
     */
    public static function onClose($client_id)
    {
        Gateway::sendToAll("client[$client_id] logout\n");
    }

    /**
     * 当进程启动时
     * @param integer $businessWorker 进程实例
     */
    public static function onWorkerStart($businessWorker)
    {
        echo "WorkerStart\n";
    }

    /**
     * 当进程关闭时
     * @param integer $businessWorker 进程实例
     */
    public static function onWorkerStop($businessWorker)
    {
        echo "WorkerStop\n";
    }
}