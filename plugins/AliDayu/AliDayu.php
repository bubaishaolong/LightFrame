<?php
namespace plugins\AliDayu;
use app\common\controller\Plugin;
/**
 * Created by PhpStorm.
 * User: wem
 * Date: 2017/1/17
 * Time: 16:31
 */
class AliDayu extends Plugin
{

    public $info = [
        // 插件名[必填]
        'name'        => 'AliDayu',
        // 插件标题[必填]
        'title'       => '阿里短信验证码',
        // 插件唯一标识[必填],格式：插件名.开发者标识.plugin
        'identifier'  => 'AliDayu.ksen.plugin',
        // 插件图标[选填]
        'icon'        => 'fa fa-fw  fa-comment',
        // 插件描述[选填]
        'description' => '阿里大鱼短信验证码发送（仅限发送短信验证码）',
        // 插件作者[必填]
        'author'      => '楚留香',
        // 插件版本[必填],格式采用三段式：主版本号.次版本号.修订版本号
        'version'     => '1.0.0',
        // 是否有后台管理功能[选填]
        'admin'       => '0',
    ];

    /**
     * 安装方法

     * @return bool
     */
    public function install(){
        return true;
    }

    /**
     * 卸载方法必

     * @return bool
     */
    public function uninstall(){
        return true;
    }
}