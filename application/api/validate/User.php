<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 10:14
 */
namespace app\api\validate;

use think\Validate;

/**
 * Class User 跟model里面User相对应
 * @package app\api\validate
 * 验证器
 */
class User extends Validate
{
    //定义验证规则
    protected $rule = [
        'value'=>'email',
    ];
    //定义验证提示语
    protected $message = [
        'value' =>  '邮箱格式错误',
    ];
    //定义验证场景  方法=>需要验证的字段
    protected $scene = [
        'add'   =>  ['name','email'],
        'edit'  =>  ['email'],
    ];
}