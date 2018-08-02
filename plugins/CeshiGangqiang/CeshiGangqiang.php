<?php
// +----------------------------------------------------------------------
// |THINKPHP
// +----------------------------------------------------------------------
// | 版权所有 2016~2017  [  ]
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace plugins\CeshiGangqiang;

use app\common\controller\Plugin;

/**
 * 系统环境信息插件
 * @package plugins\SystemInfo
 * @author 无名氏
 */
class CeshiGangqiang extends Plugin
{
    /**
     * @var array 插件信息
     */
    public $info = [
        // 插件名[必填]
        'name'        => 'CeshiGangqiang',
        // 插件标题[必填]
        'title'       => '测试刚强',
        // 插件唯一标识[必填],格式：插件名.开发者标识.plugin
        'identifier'  => 'ceshi.ming.module',
        // 插件图标[选填]
        'icon'        => 'fa fa-fw fa-camera',
        // 插件描述[选填]
        'description' => '颠三倒四',
        // 插件作者[必填]
        'author'      => '的速度',
        // 作者主页[选填]
        'author_url'  => '都是都是',
        // 插件版本[必填],格式采用三段式：主版本号.次版本号.修订版本号
        'version'     => '1.0.0',
        // 是否有后台管理功能[选填]
        'admin'       => '1',
    ];

    /**
     * @var array 插件钩子
     */
    public $hooks = [
        'form_table' =>'表单插件'
    ];
    /**
     * page_tips钩子方法
     * @param $params
     * @author 页面的提示  这里可以做任何操作
     */
    public function pageTips(&$params)
    {
        echo '<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <p>我是测试页面</p>
        </div>';
    }


    /**
     * 安装方法
     * @author 无名氏
     * @return bool
     */
    public function install(){
        return true;
    }

    /**
     * 卸载方法必
     * @author 无名氏
     * @return bool
     */
    public function uninstall(){
        return true;
    }
}