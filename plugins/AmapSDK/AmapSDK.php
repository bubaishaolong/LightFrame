<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
namespace plugins\AmapSDK;

use app\common\controller\Plugin;

/**
 * 高德地图支持插件
 * @package plugins\AmapSDK
 */
class AmapSDK extends Plugin {
    /**
     * @var array 插件信息
     */
    public $info = [
        // 插件名[必填]
        'name'        => 'AmapSDK',
        // 插件标题[必填]
        'title'       => '高德地图插件',
        // 插件唯一标识[必填],格式：插件名.开发者标识.plugin
        'identifier'  => 'amapSDK.herd21.plugin',
        // 插件图标[选填]
        'icon'        => 'fa fa-fw fa-map-marker',
        // 插件描述[选填]
        'description' => '集成了常用的一类查询接口',
        // 插件作者[必填]
        'author'      => '楚留香',
        // 作者主页[选填]
        'author_url'  => '',
        // 插件版本[必填],格式采用三段式：主版本号.次版本号.修订版本号
        'version'     => '1.0.1'
    ];
    /**
     * @var array 触发器配置
     * 此处用于控制加密签名开启/关闭的触发器
     */
    public $trigger = [
        ['isEncrypt', '1', 'encryptKey'],
    ];

    /**
     * 安装方法必须实现
     * 一般只需返回true即可
     * 如果安装前有需要实现一些业务，可在此方法实现
     * @author herd21 <mipone@foxmail.com>
     * @return bool
     */
    public function install() {
        return true;
    }

    /**
     * 卸载方法必须实现
     * 一般只需返回true即可
     * 如果安装前有需要实现一些业务，可在此方法实现
     * @author herd21 <mipone@foxmail.com>
     * @return bool
     */
    public function uninstall() {
        return true;
    }
}