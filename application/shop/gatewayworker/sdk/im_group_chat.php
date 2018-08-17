<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/25
 * Time: 14:46
 */

namespace app\lp_worker_im\gatewayworker\sdk;


use app\lp_worker_im\home\RedisCache;
use GatewayWorker\Lib\Gateway;
use app\lp_worker_im\gatewayworker\sdk\im_base;

class im_group_chat extends im_base
{
    /**
     * @param $data
     * 群聊
     */
    public  function GroupChat($data){
        /**$friends_token_s= $data['friends_token']? $data['friends_token']:0;
        $friends_token = explode(',',$friends_token_s);
        //当用户@谁时,就推给对应的用户
        if($friends_token !=0){
            for($i=0;$i<count($friends_token);$i++){
                $data_friends_token = $friends_token[$i];
                $data_list_main = Gateway::getClientSessionsByGroup($data['group_token']);
                foreach ($data_list_main as $key=>$value){
                    $ClientId = $key;
                    $friends_token_m = $data_list_main[$key];
                    $fields = ["nickname", "age", "avatar"];
                    $contents = $data['content'];
                    $userfeil = getWeixinUserInfoByField(getUserToken(), $fields);
                    if($data_friends_token ==$friends_token_m['user_token']){
                        Gateway::sendToClient($ClientId, $this->result_json("at_group_text_msg", 0,  '用户'.$userfeil['nickname'] . $contents, "接收消息"));
                    }

                }
            }
        }
        //未测试的方法
        GatewayPush('lp_worker_im/Wordsex',$data['group_token'],'money_send_group_content','words_send_group_content','推送消息','推送消息',0,$data['content'],null,2);

        CachingDataRedis('group_token_id', 'group_redis_id', 'group_token', 'group_redis_user', null, null, $data, $data['group_token']);
         **/
        //message_type
        $send_data = $this->sendBeforeCheck(getUserToken(), $data);
        //发送消息
        $friends_client_ids = Gateway::getClientIdByUid($data["user_token"]);
        foreach ($friends_client_ids as $client_ids){
            //绑定client_id到群
            Gateway::joinGroup($client_ids,$data['group_token']);
            //消息发送到群(在线用户)
            Gateway::sendToGroup($data['group_token'],$send_data);
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

    /**
     * 加入群聊
     */
    public function JoinAGroupChat(){

    }

    /**
     * 创建群
     */
    public function CreateGroupChat($data){

    }

}