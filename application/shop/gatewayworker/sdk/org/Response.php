<?php

/**
 * 输出类库
 * */

namespace app\lp_worker_im\gatewayworker\sdk\org;

use \GatewayWorker\Lib\Gateway;

class Response
{

    /**
     * 错误输出
     * @param string $client_id 客户端id！
     * @param integer $code 错误码，必填！
     * @param string  $msg  错误信息，选填！
     * @param array   $data
     */
    public static function error($client_id,$code, $msg = '', $data = array())
    {
        $returnData = array(
            'code' => $code["code"],
            'msg'  => empty($msg) ? $code["msg"] : $msg,
            'data' => $data,
        );
        //给自己发送错误通知消息
        Gateway::sendToClient($client_id, self::format_data($returnData));
        return false;
    }

    //格式化数据
    private static function format_data($arr)
    {
        return json_encode($arr);
    }
}
