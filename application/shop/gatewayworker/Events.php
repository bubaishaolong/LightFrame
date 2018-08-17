<?php

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;

use \app\lp_worker_im\gatewayworker\sdk\im_single_chat;
use \app\lp_worker_im\gatewayworker\sdk\im_group_chat;
use \app\lp_worker_im\gatewayworker\sdk\im_live_broadcast_chat;
/**
 * 主逻辑:修改代码后必须重新启动服务才能生效
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        //像客户端发送初始化链接
        Gateway::sendToClient($client_id, json_encode(array(
            'type'      => 'init',
            'client_id' => $client_id,
        )));
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $message)
    {
        if (!$message) {return;}

        if ($message == "test") {
            // 通知客户端uid生成并存储成功
            Gateway::sendToClient($client_id, "ok");
            return true;
        }

        // $message = '{"type":"say_to_one","to_client_id":100,"content":"hello"}'
        // 向所有人发送
        $req_data = json_decode($message, true);
        $GroupChat = new im_group_chat();
        switch ($req_data["type"]) {
            case 'bindUser':
                // 绑定uid
                $_SESSION["user_token"]=$req_data["user_token"];
                Gateway::bindUid($client_id, $req_data["user_token"]);
                // 通知客户端uid生成并存储成功
                Gateway::sendToClient($client_id, self::result_json("bindUser", 0, $req_data, '绑定成功'));

                break;
            case 'ping':
                //当client_id下线（连接断开）时会自动与uid解绑
                Gateway::closeClient($client_id);
                return;
            case 'getGroupOnlineUserTokens':
                $session_lists = Gateway::getClientSessionsByGroup($req_data['group_token']);
                $user_tokens=[];
                foreach ($session_lists as $session_info){
                    $user_tokens[] = $session_info["user_token"];
                }
                // 通知客户端uid生成并存储成功
                Gateway::sendToGroup($client_id, self::result_json("getGroupOnlineUserTokens", 0, $user_tokens, '获取成功'));
                break;
            case 'SingleChat':
                //单聊 friends_token对方的token值  content消息内容  objectName_type消息类型
                $im_single_chat = new im_single_chat();
                $im_single_chat->SingleChat($req_data);
                return;
                break;
            case 'GroupChat':
                //群聊 content内容  objectName_type消息类型 friends_token对方的token值  group_token群组的token
                $GroupChat->GroupChat($req_data);
                return;
                break;
            case 'LiveBroadcastChat':
                //直播 content内容  objectName_type消息类型 friends_token对方的token值  main_token群组的token
                $LiveBroadcastChat = new im_live_broadcast_chat();
                $LiveBroadcastChat->LiveBroadcastChat($req_data);
                return;
                break;
            default:
                # code...
                break;
        }
    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
        // 向所有人发送
        // GateWay::sendToAll("$client_id logout");
        Gateway::closeClient($client_id);
    }

    public static function result_json($type = null, $code = 0, $data, $msg = "")
    {
        return json_encode(["type" => $type, "data" => $data, "msg" => $msg, "code" => $code]);
    }

}
