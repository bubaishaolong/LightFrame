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
     * @param string $table_name 附加表名
     * @author 无名氏
     * @return string
     */
    function table_exist($table_name = '')
    {
        return true == Db::query("SHOW TABLES LIKE '{$table_name}'");
    }
}