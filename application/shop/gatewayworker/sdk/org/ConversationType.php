<?php

namespace app\lp_worker_im\gatewayworker\sdk\org;

/**
 * 会话类型
 * code 会话标识代码
 * class 会话类名
 * desc 描述文本
 */
class ConversationType
{
    //类型
    public static $PRIVATE          = ["code" => "PRIVATE", "class" => "PrivateConversation", "desc" => "单聊", "is_at" => false];
    public static $DISCUSSION       = ["code" => "DISCUSSION", "class" => "DiscussionConversation", "desc" => "讨论组", "is_at" => true];
    public static $GROUP            = ["code" => "GROUP", "class" => "GroupConversation", "desc" => "群聊", "is_at" => true];
    public static $CHATROOM         = ["code" => "CHATROOM", "class" => "ChatroomConversation", "desc" => "聊天室", "is_at" => true];
    public static $CUSTOMER_SERVICE = ["code" => "CUSTOMER_SERVICE", "class" => "CustomerServiceConversation", "desc" => "客服", "is_at" => false];
    public static $SYSTEM           = ["code" => "SYSTEM", "class" => "SystemConversation", "desc" => "系统", "is_at" => false];

    //获取属性值
    public static function getAttr($name)
    {
        $return_attr = false;
        switch ($name) {
            case "PRIVATE":
                $return_attr = selt::$PRIVATE;
                break;
            case "DISCUSSION":
                $return_attr = selt::$DISCUSSION;
                break;
            case "GROUP":
                $return_attr = selt::$GROUP;
                break;
            case "CHATROOM":
                $return_attr = selt::$CHATROOM;
                break;
            case "CUSTOMER_SERVICE":
                $return_attr = selt::$CUSTOMER_SERVICE;
                break;
            case "SYSTEM":
                $return_attr = selt::$SYSTEM;
                break;
        }
        return $return_attr;
    }
}
