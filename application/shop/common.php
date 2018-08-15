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

 function headers(){
     // 定义一个允许跨域请求接口的域名列表，这里你可以用配置也可以用其它形式，我这里只是用$GLOBALS简单演示一下
     $GLOBALS['API_ALLOW_ORIGINS'] = array(
         'baidu.com',
         'yurunsoft.com'
     );
// 判断是否有origin请求头
     if(isset($_SERVER['HTTP_ORIGIN']))
     {
         // 遍历域名列表判断
         foreach($GLOBALS['API_ALLOW_ORIGINS'] as $domain)
         {
             if($_SERVER['HTTP_ORIGIN'] === $domain || substr($_SERVER['HTTP_ORIGIN'], -strlen($domain) - 1) === '.' . $domain)
             {
                 header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                 break;
             }
         }
     }
 }
