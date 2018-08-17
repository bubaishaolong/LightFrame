<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/23
 * Time: 14:10
 */

use think\Db;

if (!function_exists('table_exist')) {
    /**
     * 检查附加表是否存在
     * @param string $table_name 表名
     * @author 无名氏
     * @return string
     */
    function table_exist($table_name = '')
    {
        return true == Db::query("SHOW TABLES LIKE '{$table_name}'");
    }
}

function headers()
{
    // 定义一个允许跨域请求接口的域名列表，这里你可以用配置也可以用其它形式，我这里只是用$GLOBALS简单演示一下
    $GLOBALS['API_ALLOW_ORIGINS'] = array(
        'baidu.com',
        'yurunsoft.com'
    );
// 判断是否有origin请求头
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // 遍历域名列表判断
        foreach ($GLOBALS['API_ALLOW_ORIGINS'] as $domain) {
            if ($_SERVER['HTTP_ORIGIN'] === $domain || substr($_SERVER['HTTP_ORIGIN'], -strlen($domain) - 1) === '.' . $domain) {
                header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                break;
            }
        }
    }
}

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
