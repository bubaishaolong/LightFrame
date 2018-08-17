<?php

namespace app\lp_worker_im\gatewayworker\sdk\org;

/**
 * 消息通知类型
 * code 消息标识代码
 * params 消息必须传递的参数,type为int的max_length表示大小,为0表示不限制
 * class 消息类名
 * is_conversation 消息是否需要创建会话列表
 * is_filter 消息是否需要过滤敏感词
 * is_count 消息是否需要计算未读数量
 * is_save 消息是否需要保存聊天记录
 * desc 描述文本
 */
class NotificationType
{
    //内容类消息
    public static $RCTxtMsg = ["code" => "RC:TxtMsg", "params" => [
        ["name" => "content", "type" => "string", "max_length" => "500", "is_must" => true, "title" => "消息内容", "max_length" => "500", "desc" => ""],
        ["name" => "extra", "type" => "string", "max_length" => "500", "is_must" => false, "title" => "附加消息", "desc" => ""],
    ], "class" => "TextMessage", "is_conversation" => true, "is_filter" => true, "is_count" => true, "is_save" => true, "desc" => "文字消息"];
    public static $RCVcMsg = ["code" => "RC:VcMsg", "params" => [
        ["name" => "content", "type" => "string", "max_length" => "500", "is_must" => true, "title" => "消息内容", "desc" => "表示语音内容，格式为 AMR，以 Base64 进行 Encode 后需要将所有 \r\n 和 \r 和 \n 替换成空，大小建议不超过 60k"],
        ["name" => "duration", "type" => "int", "max_length" => "60", "is_must" => true, "title" => "语音长度", "desc" => "表示语音长度，最长为 60 秒"],
        ["name" => "extra", "type" => "string", "max_length" => "500", "is_must" => false, "title" => "附加消息", "desc" => ""],
    ], "class" => "VoiceMessage", "is_conversation" => true, "is_filter" => false, "is_count" => true, "is_save" => true, "desc" => "语音消息"];
    public static $RCImgMsg     = ["code" => "RC:ImgMsg", "class" => "ImageMessage", "is_conversation" => true, "is_filter" => false, "is_count" => true, "is_save" => true, "desc" => "图片消息"];
    public static $RCImgTextMsg = ["code" => "RC:ImgTextMsg", "class" => "RichContentMessage", "is_conversation" => true, "is_filter" => false, "is_count" => true, "is_save" => true, "desc" => "图文消息"];
    public static $RCLBSMsg     = ["code" => "RC:LBSMsg", "class" => "LocationMessage", "is_conversation" => true, "is_filter" => false, "is_count" => true, "is_save" => true, "desc" => "位置消息"];
    //通知类消息
    public static $RCContactNtf = ["code" => "RC:ContactNtf", "class" => "ContactNotificationMessage", "is_conversation" => false, "is_filter" => false, "is_count" => false, "is_save" => true, "desc" => "好友通知消息"];
    public static $RCProfileNtf = ["code" => "RC:ProfileNtf", "class" => "ProfileNotificationMessage", "is_conversation" => false, "is_filter" => false, "is_count" => false, "is_save" => true, "desc" => "资料通知消息"];
    public static $RCCmdNtf     = ["code" => "RC:CmdNtf", "class" => "CommandNotificationMessage", "is_conversation" => false, "is_filter" => false, "is_count" => false, "is_save" => true, "desc" => "通用命令通知消息"];
    public static $RCInfoNtf    = ["code" => "RC:InfoNtf", "class" => "InformationNotificationMessage", "is_conversation" => false, "is_filter" => false, "is_count" => false, "is_save" => true, "desc" => "提示条通知消息"];
    public static $RCGrpNtf     = ["code" => "RC:GrpNtf", "class" => "GroupNotificationMessage", "is_conversation" => false, "is_filter" => false, "is_count" => false, "is_save" => true, "desc" => "群组通知消息	"];
    public static $RCDizNtf     = ["code" => "RC:DizNtf", "class" => "DiscussionNotificationMessage", "is_conversation" => false, "is_filter" => false, "is_count" => false, "is_save" => true, "desc" => "讨论组通知消息"];
    public static $RCReadNtf    = ["code" => "RC:ReadNtf", "class" => "ReadReceiptMessage", "is_conversation" => false, "is_filter" => false, "is_count" => false, "is_save" => false, "desc" => "已读通知消息"];
    public static $RCCmdMsg     = ["code" => "RC:CmdMsg", "class" => "CommandMessage", "is_conversation" => false, "is_filter" => false, "is_count" => false, "is_save" => false, "desc" => "命令消息"];
    //状态类消息
    public static $RCTypSts = ["code" => "RC:TypSts", "class" => "TypingStatusMessage", "is_conversation" => false, "is_filter" => false, "is_count" => false, "is_save" => false, "desc" => "对方正在输入状态消息"];

    //获取属性值
    public static function getAttr($name)
    {
        $return_attr = false;
        $name        = str_replace(":", "", $name);
        switch ($name) {
            case "RCTxtMsg":
                $return_attr = selt::$RCTxtMsg;
                break;
            case "RCVcMsg":
                $return_attr = selt::$RCVcMsg;
                break;
            case "RCImgMsg":
                $return_attr = selt::$RCImgMsg;
                break;
            case "RCImgTextMsg":
                $return_attr = selt::$RCImgTextMsg;
                break;
            case "RCLBSMsg":
                $return_attr = selt::$RCLBSMsg;
                break;
            case "RCContactNtf":
                $return_attr = selt::$RCContactNtf;
                break;
            case "RCProfileNtf":
                $return_attr = selt::$RCProfileNtf;
                break;
            case "RCCmdNtf":
                $return_attr = selt::$RCCmdNtf;
                break;
            case "RCInfoNtf":
                $return_attr = selt::$RCInfoNtf;
                break;
            case "RCGrpNtf":
                $return_attr = selt::$RCGrpNtf;
                break;
            case "RCDizNtf":
                $return_attr = selt::$RCDizNtf;
                break;
            case "RCReadNtf":
                $return_attr = selt::$RCReadNtf;
                break;
            case "RCCmdMsg":
                $return_attr = selt::$RCCmdMsg;
                break;
            case "RCTypSts":
                $return_attr = selt::$RCTypSts;
                break;
        }
        return $return_attr;
    }
}
