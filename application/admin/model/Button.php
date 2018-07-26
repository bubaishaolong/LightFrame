<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/26
 * Time: 13:10
 */

namespace app\admin\model;

use think\Model as ThinkModel;

/**
 * Class Button
 * @package app\admin\model
 * 模型按钮配置
 */
class Button extends ThinkModel
{

    // 设置当前模型对应的完整数据表名称
    protected $table = '__ADMIN_BUTTON__';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
}