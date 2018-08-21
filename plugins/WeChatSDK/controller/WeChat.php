<?php
namespace plugins\WeChatSDK\controller;
// +----------------------------------------------------------------------
// | 微果工作台 [ WeGoShop ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广西多美乐商贸有限公司 [ http://www.gxdml.com ]
// | 官方网站: http://www.gxdml.com
// +----------------------------------------------------------------------
use app\common\controller\Common;
use think\Db;
use think\Request;
use think\Session;
use Wechat\Loader;

require dirname(__FILE__) . DS . '..' . DS . 'Wechat/Loader.php';

/**
 * Class WeChat 微信SDK操作接口类
 * @package plugins\WeChatSDK\home
 */
class WeChat extends Common {
    /**
     * @var string 传递给微信插件的配置
     */
    private static $config;
    /**
     * @var string 微信缓存目录
     */
    private static $CacheDir;
    /**
     * @var bool 本类单例对象存放
     */
    private static $_instance = null;
    /**
     * @var array 实例化的微信类
     */
    private static $wechat = [];

    /**
     * WeChat constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        // 定义缓存目录
        self::$CacheDir = RUNTIME_PATH . 'wechat';
        // 初始化微信SDK
        $this->initWechatSDK();
        parent::__construct($request);
    }

    /**
     * 微信插件初始化检测
     */
    private function initWechatSDK() {
        // 读取微信插件配置
        $Config = plugin_config('WeChatSDK');
        // 插件启用状态检测
        $Status = $this->getPluginStatus();
        if (!$Status) $this->error('微信插件未开启或未安装!');
        // 检测插件必填项
        if (!$Config['AppID'] || !$Config['AppSecret'] || !$Config['Token']) {
            $this->error('微信AppID/Secret/Token配置不完整!');
        }
        // 缓存目录写权限检测
        if (!is_dir(self::$CacheDir)) {
            if (!mkdir(self::$CacheDir, '0644')) {
                $this->error('缓存目录 ../Cache 不存在,且自动创建失败!');
            } else {
                chmod(self::$CacheDir, '0644');
            }
        }
        if (!is_writable(self::$CacheDir)) {
            $this->error('缓存目录 ../Cache 不可写!');
        }
        // 构造初始化配置
        self::$config = [
            'token'          => $Config['Token'],
            'appid'          => $Config['AppID'],
            'appsecret'      => $Config['AppSecret'],
            'encodingaeskey' => $Config['AESKey'],
            'cachepath'      => self::$CacheDir
        ];
        // 注入配置参数
        \Wechat\Loader::config(self::$config);
    }

    /**
     * 检测插件是否安装和开启
     * @return bool
     */
    private function getPluginStatus() {
        $pluginRecord = Db::name('admin_plugin')->where('identifier', '=', 'wechat_sdk.evalor.plugin')->find();
        if (is_null($pluginRecord)) {
            return false;
        } else {
            // 检测插件是否开启
            $Status = $pluginRecord['status'];
            return $Status != 1 ? false : true;
        }
    }

    /**
     * 类单例获取
     * @param string $type 需要取得的实例
     * @return self 返回自身
     */
    public static function instance() {
        // 检测类是否已被实例化
        if (is_null(self::$_instance) || isset (self::$_instance)) {
            self::$_instance = new self ();
        }
        return self::$_instance;
    }

    /**
     * 单例加载操作类
     * @param string $type 操作类名称
     * @return object 返回类对象
     */
    public function load_wechat($type) {
        $index = md5(strtolower($type));
        if (!isset(self::$wechat[$index])) {
            $config = self::$config;
            self::$wechat[$index] = Loader::get($type, $config);
        }
        return self::$wechat[$index];
    }

    // +------------------------------
    // | 授权方法封装
    // +------------------------------
    /**
     * 发起微信授权
     * @param string $callback 授权回调地址
     * @param bool $base 只获取基本信息(false时获取全量信息)
     * @param string $state 自定义返回状态码
     */
    public function Oauth_Redirect($callback, $base = true, $state = '') {
        $scope = $base ? 'snsapi_base' : 'snsapi_userinfo';
        $Oauth = $this->load_wechat('Oauth');
        $url = $Oauth->getOauthRedirect($callback, $state, $scope);
        $this->redirect($url);
    }

    /**
     * 获取用户信息
     * @return array 用户信息
     */
    public function Oauth_UserInfo() {
        // 换取AccessToken
        $Oauth = $this->load_wechat('Oauth');
        $Token = $Oauth->getOauthAccessToken();
        $openid = $Token['openid'];
        // 获取详细信息
        if ($Token['scope'] == 'snsapi_userinfo') {
            $info = $Oauth->getOauthUserInfo($Token['access_token'], $openid);
            return $info;
        } else {
            return ['openid' => $openid];
        }
    }
}