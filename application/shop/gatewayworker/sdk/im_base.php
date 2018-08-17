<?php
/**
 * 发送消息基类
 * User: Administrator
 * Date: 2018/4/25
 * Time: 10:54
 */

namespace app\lp_worker_im\gatewayworker\sdk;

use app\lp_worker_im\gatewayworker\sdk\org\ConversationType;
use app\lp_worker_im\gatewayworker\sdk\org\ErrorCode;
use app\lp_worker_im\gatewayworker\sdk\org\NotificationType;
use app\lp_worker_im\gatewayworker\sdk\org\Response;

class im_base
{

    /**
     * 发送消息前
     * @param $conversation_type 发送消息会话类型
     * @return 返回待发送的消息对象
     */
    public function sendBeforeCheck($client_id, $msg_data)
    {

        //校验会话数据，参数传递是否合法
        if (!$this->checkParams($msg_data)) {
            return Response::error($client_id, ErrorCode::$ERR_PARAM);
        }

        //校验会话类型是否合法
        $conversation_info = ConversationType::getAttr($msg_data["conversation_type"]);
        if ($conversation_info === false) {
            return Response::error($client_id, ErrorCode::$ERR_CONVERSATION);
        }


        $notification_info = NotificationType::getAttr($msg_data["message_type"]);
        if ($notification_info) {

            //2.过滤铭感词
            if ($notification_info["is_filter"]) {
                $send_data["content"] = $this->filterMessage($msg_data["content"]);
            }

            //待发送的消息对象
            //message_type消息类型
            //"message_type" => $msg_data["message_type"],
            //"conversation_type" => $msg_data["conversation_type"],
            $this->ToBeSent($msg_data);
        }

        $dataRedisCache = new RedisCache();
        //1.判断是否具备会话列表，如果不具备则创建
        if ($notification_info["is_conversation"]) {
            $session_list_cachae = $dataRedisCache->cache('session_list_cache');
            if (!$session_list_cachae) {
                //自增
                $dataRedisCache->cacheinc('session_list_id');
                $session_list_id = $dataRedisCache->cacheinc('session_list_id');//这个id缓存不清除
                $data['id'] = $session_list_id;
                $data['form_token'] = $msg_data['form_token'];
                $data['user_token'] = $msg_data['user_token'];
                $data['company_token'] = $msg_data['company_token'];
                $data['conversation_type'] = $msg_data["conversation_type"];
                $data['create_time'] = time();
                $data['update_time'] = time();
                $dataRedisCache->cache('session_list_cache', $data);
            }
        }

        //3.实现@功能
        if ($conversation_info["is_at"]) {
            $data_at['user_token'] = $msg_data['user_token'];
            $data_at['company_token'] = $msg_data['company_token'];
            $data_at['friends_token'] = $msg_data['friends_token'];//要@的对象的token值
            $data_at['content'] = $msg_data['content'];
            $data_at['form_token'] = $msg_data['form_token'];//传过来的token值  比如group_token  discussion_token
            $data_at['conversation_type'] = $msg_data["conversation_type"];//会话的类型
//            switch ($msg_data["conversation_type"]) {
//                case "GROUP":
//                    $data_at['group_token'] = $msg_data['group_token'];
//                    break;
//                case "DISCUSSION":
//                    $data_at['discussion_token'] = $msg_data['discussion_token'];
//                    break;
//                case "CHATROOM":
//                    $data_at['chatroom_token'] = $msg_data['chatroom_token'];
//                    break;
//                default:
//                    break;
//            }
            $send_data['data_at'] = $data_at;
        }
        //4.缓存记录
        if ($conversation_info["is_save"]) {

            $data_chat['user_token'] = $msg_data['user_token'];
            $data_chat['company_token'] = $msg_data['company_token'];
            $data_chat['content'] = $msg_data['content'];
            $data_chat['form_token'] = $msg_data['form_token'];//传过来的token值  比如group_token  discussion_token
            $data_chat['conversation_type'] = $msg_data['conversation_type'];//会话的类型
            $data_chat['create_time'] = time();
            $data_chat['update_time'] = time();
            $dataRedisCache->cacheinc($msg_data['conversation_type']);
            $singchat_id = $dataRedisCache->cache($msg_data['conversation_type']);//这个id缓存不清除
            $data_chat['id'] = $singchat_id;
            $dataRedisCache->cache('singchat_list_cache', $data_chat);
        }

        return $send_data;
    }

    //根据消息类型检查传递的参数是否正确
    private function checkParams($params)
    {
        $result = true;
        //检查必传参数
        if (!isset($params["message_type"]) || empty($params["message_type"])) {
            return $result;
        }
        if (!isset($params["conversation_type"]) || empty($params["conversation_type"])) {
            return $result;
        }
        //检查消息通知类型配置参数
        $notification_info = NotificationType::getAttr($params["message_type"]);
        foreach ($notification_info["params"] as $param_info) {
            if ($param_info["is_must"]) {
                //检查是否存在
                if (!isset($params[$param_info["name"]]) || empty($params[$param_info["name"]])) {
                    $result = false;
                    break;
                }
                //检查值是否合法
                $param_value = $params[$param_info["name"]];
                switch ($param_info["type"]) {
                    case "string":
                        if (intval($param_info["max_length"]) < mb_strlen($param_value, 'utf8')) {
                            $result = false;
                        }
                        break;
                    case "int":
                        if (!is_numeric($param_value)) {
                            $result = false;
                        }
                        if (intval($param_info["max_length"]) < intval($param_value)) {
                            $result = false;
                        }
                        break;
                    //..更多
                }
            }
        }

        return $result;
    }

    //过滤消息内容，使用**代替
    private function filterMessage($content)
    {
        //拆分字符串变成单个词语
        $content_en = getAnalyzer($content);
        $data_words[] = ['words', 'in', $content_en];
        $datainfo = model('lp_worker_im/Wordsex')->_where($data_words)->info();
        //需要替换的内容
        if ($datainfo) {
            $badword = model('lp_worker_im/Wordsex')->_field('words')->lists();
            $badword1 = array_combine($badword, array_fill(0, count($badword), '****'));
            //查找替换
            $filter_str = strtr($content, $badword1);
        }

        //$filter_str = "";
        //过滤实现
        return $filter_str;
    }

    /**
     * @param $msg_data
     * @return mixed
     * 待消息发送
     */
    private function ToBeSent($msg_data)
    {
        $send_data_extras = ["RC:TxtMsg", "RC:VcMsg", "RC:ImgMsg", "RC:ImgTextMsg", "RC:ContactNtf", "RC:InfoNtf", "RC:GrpNtf"];
        if (in_array($msg_data["message_type"], $send_data_extras)) {
            $send_data['extra'] = $msg_data['extra'];//附加信息
        }
        $send_data_contents = ["RC:TxtMsg", "RC:VcMsg", "RC:ImgMsg", "RC:ImgTextMsg"];
        if (in_array($msg_data["message_type"], $send_data_contents)) {
            $send_data['content'] = $msg_data['content'];//附加信息
        }
        $send_data_cmds = ["RC:CmdNtf", "RC:CmdMsg"];
        if (in_array($msg_data["message_type"], $send_data_cmds)) {
            $send_data['name'] = $msg_data['name'];//为命令名称，可以自行定义
            $send_data['data'] = $msg_data['data'];//为命令的内容，此类型消息没有 Push 通知
        }
        $send_data_manage = ['RC:GrpNtf', "RC:InfoNtf", "RC:ContactNtf"];
        if (in_array($msg_data["message_type"], $send_data_manage)) {
            $send_data['message'] = $msg_data['message'];//为消息内容
        }
        $send_data_operation = ["RC:GrpNtf", "RC:ProfileNtf", "RC:ContactNtf"];
        if (in_array($msg_data["message_type"], $send_data_operation)) {
            $send_data['operation'] = $msg_data['operation'];//为操作名
        }
        switch ($msg_data["message_type"]) {
            //语音消息
            case "RC:VcMsg":
                $send_data['duration'] = $msg_data['duration'];//语音的长短  最长为 60 秒
                break;
            //图片消息
            case "RC:ImgMsg":
                $send_data['imageUri'] = $msg_data['imageUri'];//为图片 Url
                break;
            //图文消息
            case "RC:ImgTextMsg":
                $send_data['title'] = $msg_data['title'];//表示消息的标题
                $send_data['imageUri'] = $msg_data['imageUri'];//为图片地址
                $send_data['url'] = $msg_data['url'];//为跳转的地址
                break;
            //位置消息
            case "RC:LBSMsg":
                $send_data['latitude'] = $msg_data['latitude'];//表示纬度
                $send_data['longitude'] = $msg_data['longitude'];//表示经度
                $send_data['poi'] = $msg_data['poi'];//位置的详细poi信息
                break;
            //文件消息
            case "RC:FileMsg":
                $send_data['name'] = $msg_data['name'];//文件名称
                $send_data['size'] = $msg_data['size'];//文件大小单位为 byte
                $send_data['type'] = $msg_data['type'];//文件扩展名
                $send_data['fileUrl'] = $msg_data['fileUrl'];//文件地址
                break;
            //添加联系人消息
            case "RC:ContactNtf":
                $send_data['sourceUserId'] = $msg_data['sourceUserId'];//表示请求者或者响应者的 UserId
                $send_data['targetUserId'] = $msg_data['targetUserId'];//表示被请求者或者被响应者的 UserId
                break;
            //资料通知消息
            case "RC:ProfileNtf":
                $send_data['data'] = $msg_data['data'];//为操作的数据
                break;
            //群组通知消息
            case "RC:GrpNtf":
                $send_data['operatorUserId'] = $msg_data['operatorUserId'];//为操作人用户 Id
                $send_data['data'] = $msg_data['data'];//为操作数据，详见 data 的 JOSN 数据格式
                break;
            //讨论组通知消息
            case "RC:DizNtf":
                $send_data['type'] = $msg_data['type'];// 为讨论组操作类型 1:加入讨论组 2：退出讨论组 3:讨论组改名 4：讨论组管理员踢人
                $send_data['extension'] = $msg_data['extension'];//为被加入讨论组用户 Id，多个用户 Id 以逗号分割
                $send_data['operator'] = $msg_data['operator'];//为当前操作用户 Id。
                break;
            default:
                $send_data = [
                    "content" => $msg_data['content'],
                    "extra" => $msg_data['extra'],//附加的内容
                ];
                break;
        }
        return $send_data;
    }
    /**
     * @param null $type
     * @param int $code
     * @param $data
     * @param string $msg
     * @return string
     * json 输出封装
     */
    public function result_json($type = null, $code = 0, $data, $msg = "")
    {
        return json_encode(["type" => $type, "data" => $data, "msg" => $msg, "code" => $code]);

    }
}