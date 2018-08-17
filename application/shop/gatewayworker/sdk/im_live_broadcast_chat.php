<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/25
 * Time: 15:10
 */

namespace app\lp_worker_im\gatewayworker\sdk;

use GatewayWorker\Lib\Gateway;
use app\lp_worker_im\gatewayworker\sdk\im_base;

class im_live_broadcast_chat extends im_base
{
    /**
     * @param $data
     * 直播聊天
     */
    public function LiveBroadcastChat($data){
        //message_type
        $send_data = $this->sendBeforeCheck(getUserToken(), $data);
        //发送消息
        $friends_client_ids = Gateway::getClientIdByUid($data["user_token"]);
        foreach ($friends_client_ids as $client_ids){
            //绑定client_id到群
            Gateway::joinGroup($client_ids,$data['main_token']);
            //消息发送到群(在线用户)
            Gateway::sendToGroup($data['main_token'],$send_data);
            //被@的详细信息,推送消息
            if($send_data['data_at']){
                $connet_at = $send_data['data_at'];
                $data_list_main = Gateway::getClientSessionsByGroup($connet_at['form_token']);
                foreach ($data_list_main as $key=>$value){
                    $ClientId = $key;
                    $friends_token_m = $data_list_main[$key];
                    $fields = ["nickname", "age", "avatar"];
                    $contents = $connet_at['content'];
                    $userfeil = getWeixinUserInfoByField(getUserToken(), $fields);
                    if($connet_at['friends_token'] ==$friends_token_m['user_token']){
                        Gateway::sendToClient($ClientId, result_json("at_group_text_msg", 0,  '用户'.$userfeil['nickname'] . $contents, "接收消息"));
                    }
                }
            }
        }
    }
}