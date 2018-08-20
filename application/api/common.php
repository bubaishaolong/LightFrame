<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 9:24
 * 公共文件
 */
/**
 * @param $param 需要加密的参数
 * @return string
 * @key 是双方约定的值
 * openssl加密方法 encrypt是安卓或者IOS定义的传输协议
 */
function opssl_encrypt($param)
{
    $param = serialize($param);
    $key = md5('www.baidu.com');//加密密钥
    $data['iv'] = base64_encode(substr('openlist;encrypt', 0, 16));
    $data['value'] = openssl_encrypt($param, 'AES-256-CBC', $key, 0, base64_decode($data['iv']));
    $encrypt = base64_encode(json_encode($data));
    return $encrypt;
}

/**
 * @param $encrypt 需要解密的字符串
 * @return int|mixed 返回结果
 * openssl解密方法
 */
function opssl_decrypt($encrypt)
{
    $key = md5('www.baidu.com');//解密钥匙
    $encrypt = json_decode(base64_decode($encrypt), true);
    $iv = base64_decode($encrypt['iv']);
    $decrypt = openssl_decrypt($encrypt['value'], 'AES-256-CBC', $key, 0, $iv);
    $data = unserialize($decrypt);
    if ($data) {
        return $data;
    } else {
        return 0;
    }
}

function Api($code = '', $data = [], $massage = '')
{
    if(!isset($data)){
        $json = [
            'code' => $code,
            'massage' => $massage
        ];
    }else{
        $json = [
            'code' => $code,
            'data' => $data,
            'massage' => $massage
        ];
    }
    return json_encode($json,JSON_UNESCAPED_UNICODE);

}