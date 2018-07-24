<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/24
 * Time: 17:06
 */

namespace app\admin\validate;

use think\Validate;

/**
 * Class Moduleconfig
 * @package app\admin\validate
 * 模型配置文件
 */
class Moduleconfig extends Validate
{

    // 定义验证规则
    protected $rule = [
        'name|字段名称' => 'require',
        'group_name|分组名称'  => 'require',
        'title|字段标题' => 'require',
    ];

    // 定义验证提示
    protected $message = [
        'name.regex' => '配置名称由字母和下划线组成',
    ];

    // 定义场景，供快捷编辑时验证
    protected $scene = [
        'name'  => ['name'],
        'title' => ['title'],
    ];
}