<?php

namespace app\lp_worker_im\gatewayworker\sdk\org;

/**
 * 错误类型
 * code 错误标识代码
 * msg 描述文本
 */
class ErrorCode
{
    public static $TIMEOUT               = ["code" => "TIMEOUT", "msg" => "超时"];
    public static $UNKNOWN_ERROR         = ["code" => "UNKNOWN_ERROR", "msg" => "未知错误"];
    public static $REJECTED_BY_BLACKLIST = ["code" => "REJECTED_BY_BLACKLIST", "msg" => "在黑名单中，无法向对方发送消息"];
    public static $NOT_IN_DISCUSSION     = ["code" => "NOT_IN_DISCUSSION", "msg" => "不在讨论组中"];
    public static $NOT_IN_GROUP          = ["code" => "NOT_IN_GROUP", "msg" => "不在群组中"];
    public static $NOT_IN_CHATROOM       = ["code" => "NOT_IN_CHATROOM", "msg" => "不在聊天室中"];
    public static $ERR_CONVERSATION      = ["code" => "ERR_CONVERSATION", "msg" => "错误会话"];
    public static $ERR_PARAM             = ["code" => "ERR_PARAM", "msg" => "参数传递错误"];
}
