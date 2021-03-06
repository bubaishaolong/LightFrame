<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017  [  ]
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace plugins\Barcode;

use app\common\controller\Plugin;

/**
 * 条形码生成插件
 * @package plugins\Barcode
 */
class Barcode extends Plugin
{
    /**
     * @var array 插件信息
     */
    public $info = [
        // 插件名[必填]
        'name'        => 'Barcode',
        // 插件标题[必填]
        'title'       => '条形码生成插件',
        // 插件唯一标识[必填],格式：插件名.开发者标识.plugin
        'identifier'  => 'barcode.ming.plugin',
        // 插件图标[选填]
        'icon'        => 'fa fa-fw fa-barcode',
        // 插件描述[选填]
        'description' => '条形码生成插件',
        // 插件作者[必填]
        'author'      => '楚留香',
        // 作者主页[选填]
        'author_url'  => '',
        // 插件版本[必填],格式采用三段式：主版本号.次版本号.修订版本号
        'version'     => '1.0.0'
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
            <p>欢迎来到我的页面</p>
        </div>';
    }

    /**
     * 安装方法必须实现
     * 一般只需返回true即可
     * 如果安装前有需要实现一些业务，可在此方法实现
     * @author 无名氏
     * @return bool
     */
    public function install(){
        return true;
    }

    /**
     * 卸载方法必须实现
     * 一般只需返回true即可
     * 如果安装前有需要实现一些业务，可在此方法实现
     * @author 无名氏
     * @return bool
     */
    public function uninstall(){
        return true;
    }
}