<?php
// +----------------------------------------------------------------------
// | SwiftMailer邮件
// +----------------------------------------------------------------------
// | Mr-J
// +----------------------------------------------------------------------
// | www.jiuyeyue.com
// +----------------------------------------------------------------------

namespace plugins\PHPMailer;


use app\common\controller\Plugin;

class PHPMailer extends Plugin
{
    public $info = [
        // 插件名[必填]
        'name'        => 'PHPMailer',
        // 插件标题[必填]
        'title'       => 'PHPMailer',
        // 插件唯一标识[必填],格式：插件名.开发者标识.plugin
        'identifier'  => 'PHPMailer.Mr-J.plugin',
        // 插件图标[选填]
        'icon'        => 'fa fa-fw  fa-envelope-o',
        // 插件描述[选填]
        'description' => 'PHPMailer,请先使用命令composer require phpmailer/phpmailer 安装PHPMailer',
        // 插件作者[必填]
        'author'      => '楚留香',
        // 作者主页[选填]
        'author_url'  => '',
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