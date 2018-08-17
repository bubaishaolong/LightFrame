<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/25
 * Time: 10:54
 */

namespace app\lp_worker_im\gatewayworker\sdk;

use app\lp_worker_im\gatewayworker\sdk\im_base;

use \GatewayWorker\Lib\Gateway;

class im_single_chat extends im_base
{
    /**
     * 单聊
     * 根据聊天服务器传过来的消息内容拆分
     */
    public function SingleChat($data)
    {
//        $data['user_token'] = getUserToken();
        //        $data['company_token'] = getCompanyToken();
        //        $post = $this->request->post();
        //        $data['friends_token'] = $post['friends_token'];
        //        $data['content'] = $post['content'];
        //        $data['objectName_type'] = $post['objectName_type'];
        /* $data['status']  = 1;
        $data['is_Read'] = 0;
        //是否有会话列表
        $dataArray = ObtainingCachingRedis('sessionlist_id', 'sessionlist_chat', $data['user_token'], $data['friends_token'], 999);
        if (!$dataArray) {
        $data_where1['user_token']    = getUserToken();
        $data_where1['friends_token'] = $data['friends_token'];
        $data_where1['company_token'] = getCompanyToken();
        $data_where1['status']        = 1;
        CachingDataRedis('sessionlist_id', null, 'sessionlist_chat', null, getUserToken(), $data['friends_token'], $data_where1, null);
        }
        GatewayPush('lp_worker_im/Wordsex', null, 'money_user_send_text_msg', 'black_words_text_msg', '推送消息', '推送消息', 0, $data['content'], $data['friends_token'], 0);
        CachingDataRedis('single_user_chat_id', null, 'single_user_chat', null, getUserToken(), $data['friends_token'], $data, null);
        return true;
         */

        $send_data = $this->sendBeforeCheck(getUserToken(), $data);
        $data_echo = getAnalyzer($data['content']);
        $data_words[] = ['words','in',$data_echo];
        $datainfo = model('lp_worker_im/Wordsex')->_where($data_words)->info();
        //发送消息
        $friends_client_ids = Gateway::getClientIdByUid($data["friends_token"]);
        foreach ($friends_client_ids as $client_ids) {
            if ($datainfo) {
                Gateway::sendToClient($client_ids, result_json("black_words_text_msg", 0, "发送的消息包涵敏感词", "接收消息"));
            }
            for ($i = 0; $i < count($data_echo); $i++) {
                $mobie = preg_match("/^1[34578]{1}\d{9}$/", $data_echo[$i]);
                if ($mobie) {
                    Gateway::sendToClient($client_ids,result_json("money_user_send_text_msg", 0, "涉及到资金账号,电话号码,安全注意保护财产,亲自与本人确认", "推送消息"));
                }
            }
            Gateway::sendToClient($client_ids, $send_data);
        }

    }

}