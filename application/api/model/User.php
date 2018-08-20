<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 9:25
 */
namespace app\api\model;

use think\Model as ThinkModel;

class User extends ThinkModel
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__API_USER__';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
}