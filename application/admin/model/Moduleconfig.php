<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/24
 * Time: 13:59
 */

namespace app\admin\model;

use think\Model;

/**
 * Class Moduleconfig
 * @package app\admin\model
 * 模块的配置模型
 */
class Moduleconfig extends Model
{

    // 设置当前模型对应的完整数据表名称
    protected $table = '__ADMIN_MODULE_CONFIG__';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
}