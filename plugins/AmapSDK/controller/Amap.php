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
namespace plugins\AmapSDK\controller;

use app\common\controller\Common;
use think\Db;
use think\Request;

/**
 * Class Amap 高德地图Web接口封装类
 * @package plugins\AmapSDK\controller
 */
class Amap extends Common {
    /**
     * @var string 高德地图AppKey
     */
    private $appkey;
    /**
     * @var int 是否启用数字签名 0-关闭 1-开启
     */
    private $isEncrypt;
    /**
     * @var string 数字签名用户私钥
     */
    private $encryptKey;
    /**
     * @var resource 存放初始化好的Curl句柄
     */
    private static $Curl;

    /**
     * Amap constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        // 赋值插件参数
        $Config = plugin_config('AmapSDK');
        $this->appkey = isset($Config['appKey']) ? $Config['appKey'] : '';
        $this->isEncrypt = isset($Config['isEncrypt']) ? $Config['isEncrypt'] : 0;
        $this->encryptKey = isset($Config['encryptKey']) ? $Config['encryptKey'] : '';
        // 进行环境检测
        $this->amapCheckEnv();
        // 初始化curl
        self::$Curl = curl_init();
        $opt = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT        => 3,
            CURLOPT_HEADER         => 0,
        ];
        curl_setopt_array(self::$Curl, $opt);
        // 执行父类方法
        parent::__construct($request);
    }

    /**
     * Amap destructor.
     */
    public function __destruct() {
        // 销毁Curl
        curl_close(self::$Curl);
    }

    /**
     * 确认插件状态
     * @return bool true-启用 false-未安装或禁用
     */
    private function plugin_status() {
        // 读取插件记录
        $record = Db::name('admin_plugin')
            ->where('name', '=', 'AmapSDK')
            ->field('status')
            ->find();
        // 返回插件现行状态
        $status = !empty($record) && $record['status'] == 1;
        return $status;
    }

    /**
     * 插件运行环境检测
     */
    private function amapCheckEnv() {
        if (!function_exists('curl_init')) {
            // 环境支持检测
            $this->error('您的环境不支持PHPCurl，请先安装扩展再使用Amap插件');
        } elseif (!$this->plugin_status()) {
            // 插件可用性检测
            $this->error('高德地图插件未安装或未开启!');
        } elseif (empty($this->appkey)) {
            // 插件配置Key检测
            $this->error('尚未设置高德地图AppKey');
        } elseif ($this->isEncrypt && empty($this->encryptKey)) {
            // 加密密钥配置检测
            $this->error('已开启高德数字签名但未设置签名密钥');
        }
    }

    /**
     * 执行Curl请求
     * @param string $url 需要请求的Url
     * @param string|array $param 请求的参数
     * @param bool $isPost 是否Post请求
     * @return bool|mixed 返回false则请求失败/成功返回内容
     */
    private function doCurl($url, $param) {
        // AppKey & Sig
        $param['key'] = $this->appkey;
        $this->isEncrypt == 1 ? $param['sig'] = $this->makeSig($param) : null;
        // 拼接请求Url
        $requestUrl = $url . http_build_query($param);
        curl_setopt(self::$Curl, CURLOPT_URL, $requestUrl);
        // 失败重试处理
        $retry = 3;
        $ret = curl_exec(self::$Curl);
        while ($ret === false && $retry--) {
            sleep(usleep(rand(300000, 800000)));
            $ret = curl_exec(self::$Curl);
        }
        return $ret;
    }

    /**
     * 生产签名Sig
     * @param array $param 请求参数
     * @return string 签名Sig
     */
    private function makeSig(array $param) {
        // 升序排列数组
        ksort($param);
        // 生成请求字符串
        $urlParam = http_build_query($param);
        // 计算返回Sig
        return md5($urlParam . $this->encryptKey);
    }

    // +----------------------------------------------
    // + 助手方法
    // +----------------------------------------------
    /**
     * 获取错误信息
     * @param string $errorCode 错误代码
     * @return mixed|string 错误信息
     */
    public function getErrorInfo($errorCode = '10000') {
        $Info = [
            "10000" => "请求正常",
            "10001" => "AppKey不正确或过期",
            "10002" => "AppKey没有该权限",
            "10003" => "超出每日访问次数限制",
            "10004" => "超出每分钟访问次数限制",
            "10005" => "该服务器不在IP白名单内",
            "10006" => "绑定域名无效",
            "10007" => "数字签名未通过验证",
            "10008" => "MD5安全码未通过验证",
            "10009" => "请求AppKey与绑定平台不符",
            "10010" => "IP访问超限",
            "10011" => "服务不支持https请求",
            "10012" => "权限不足服务请求被拒绝",
            "10013" => "AppKey被删除",
            "10014" => "每秒请求次数超限",
            "10015" => "服务器单机每秒请求超限",
            "10016" => "服务器负载过高",
            "10017" => "所请求的资源不可用",
            "20000" => "请求参数非法",
            "20001" => "缺少必填参数",
            "20002" => "请求协议非法",
            "20003" => "其他未知错误",
            "20800" => "规划点不在中国陆地范围内",
            "20801" => "划点附近搜不到路",
            "20802" => "路线计算失败",
            "20803" => "起点终点距离过长",
        ];
        $ret = $Info[$errorCode];
        if (empty($ret)) {
            $ret = '未知错误';
        }
        return $ret;
    }

    /**
     * PNG内容转Base64
     * @param string $imageContent PNG内容
     * @return string 转码Base64字符串
     */
    public function base64EncodeImage($imageContent) {
        $base64_image = 'data:image/png;base64,' . chunk_split(base64_encode($imageContent));
        return $base64_image;
    }

    // +----------------------------------------------
    // + 地理/逆地理编码
    // +----------------------------------------------
    /**
     * 地理编码查询服务
     * @param string|array $address 查询地址(省+市+区+街道+门牌号) 多个地址传入数组
     * @param string $city 限定查询城市(城市中文/中文全拼/citycode/adcode)
     * @return bool|mixed 返回false则请求失败 成功返回信息
     */
    public function geo($address, $city = '') {
        $url = 'http://restapi.amap.com/v3/geocode/geo?';
        $param = [
            'address' => $address,
            'city'    => $city,
            'batch'   => 'false'
        ];
        // 按数组传入时进行批量地址查询
        if (is_array($address)) {
            $param['address'] = implode('|', $address);
            $param['batch'] = 'true';
        }
        // 执行Curl请求
        return $this->doCurl($url, $param);
    }

    /**
     * 逆地理编码查询服务
     * @param string|array $location 需要查询的坐标，传入高德系坐标，多个坐标传入数组
     * @param string $poitype 返回附近POI类型
     * @param int $radius 搜索半径 范围0-3000
     * @param string $extensions 可选值base/all base仅返回基本信息
     * @param int $roadlevel 可选值 0-显示全部道路 1-过滤非主干道路
     * @return bool|mixed 返回false则请求失败 成功返回信息
     */
    public function reGeo($location, $poitype = '', $radius = 1000, $extensions = 'base', $roadlevel = 0) {
        $url = 'http://restapi.amap.com/v3/geocode/regeo?';
        // 入参兼容处理
        $radius > 3000 ? $radius = 3000 : null;
        $radius < 0 ? $radius = 0 : null;
        $param = [
            'location'   => $location,
            'poitype'    => $poitype,
            'radius'     => $radius,
            'extensions' => $extensions,
            'roadlevel'  => $roadlevel,
            'batch'      => 'false',
        ];
        // 按数组传入时进行批量坐标查询
        if (is_array($location)) {
            $param['location'] = implode('|', $location);
            $param['batch'] = 'true';
        }
        // 执行Curl请求
        return $this->doCurl($url, $param);
    }
    // +----------------------------------------------
    // + 行政区域查询
    // +----------------------------------------------
    /**
     * 全国行政区划查询服务
     * @param string $keywords 查询关键字
     * @param int $subdistrict 子级行政区/0、1、2、3
     * @param bool $showbiz 是否显示商圈 true/false
     * @param string $extensions 返回结果控制 base/all
     * @param string $filter 根据区划过滤 adcode
     * @param int $page 需要第几页数据
     * @param int $offset 最外层返回数据个数
     * @return bool|mixed 失败返回false/成功返回获取到的数据
     */
    public function district($keywords = '', $subdistrict = 0, $showbiz = false, $extensions = 'base', $filter = '', $page = 1, $offset = 20) {
        $url = 'http://restapi.amap.com/v3/config/district?';
        $Param = [
            'keywords'    => $keywords,
            'subdistrict' => $subdistrict,
            'showbiz'     => $showbiz,
            'extensions'  => $extensions,
            'filter'      => $filter,
            'page'        => $page,
            'offset'      => $offset,
        ];
        return $this->doCurl($url, $Param);
    }
    // +----------------------------------------------
    // + IP定位
    // +----------------------------------------------
    /**
     * IP定位服务
     * @param string $ip 需要查询的IP地址
     * @return bool|mixed 失败返回false/成功返回获取到的数据
     */
    public function ipConfig($ip = '') {
        $url = 'http://restapi.amap.com/v3/ip?';
        // 参数兼容处理
        empty($ip) ? $ip = Request::instance()->ip() : null;
        $Param = [
            'ip' => $ip,
        ];
        return $this->doCurl($url, $Param);
    }
    // +----------------------------------------------
    // + 静态地图
    // +----------------------------------------------
    /**
     * 静态图生成服务
     * @param string $location 静态图生成中心点坐标(当使用标签/标注划定中心点时可传空字符串)
     * @param int $zoom 缩放等级可选1-17
     * @param int $size 地图尺寸 最大1024*1024
     * @param int $scale 是否显示高清图 1-普通 2-高清
     * @param int $traffic 是否显示交通路况 0-隐藏 1-显示
     * @param string $markers 标注(可使用本类附带的助手方法生产并传入)
     * @param string $labels 标签(可使用本类附带的助手方法生产并传入)
     * @param string $paths 折线(暂未提供助手方法,可自行拼接)
     * @return bool|mixed
     */
    public function staticMaps($location, $zoom = 15, $size = '400*400', $scale = 1, $traffic = 0, $markers = '', $labels = '', $paths = '') {
        $url = 'http://restapi.amap.com/v3/staticmap?';
        $Param = [
            'location' => $location,
            'zoom'     => $zoom,
            'size'     => $size,
            'scale'    => $scale,
            'traffic'  => $traffic,
            'markers'  => $markers,
            'labels'   => $labels,
            'paths'    => $paths,
        ];
        // 处理空参数
        if (empty($markers)) {
            unset($Param['markers']);
        }
        if (empty($labels)) {
            unset($Param['labels']);
        }
        if (empty($paths)) {
            unset($Param['paths']);
        }
        return $this->doCurl($url, $Param);
    }

    /**
     * 生成文字标注
     * @param array|string $location 坐标点
     * @param string $size 标注尺寸 [small,mid,large]
     * @param string $color 标注颜色 默认0xFC6054
     * @param string $label 标注文字 small尺寸时隐藏
     * @return string 处理好的标注字符串
     */
    public function makeTextMarkers($location, $size = 'small', $color = '0xFC6054', $label = '') {
        if (is_array($location)) {
            $location = implode(';', $location);
        } else {
            $location = $location . ';';
        }
        return $size . ',' . $color . ',' . $label . ':' . $location;
    }

    /**
     * 生成图片标注
     * @param string $picUrl 图片链接地址
     * @return string 处理好的标注字符串
     */
    public function makePicMarkers($picUrl) {
        return '-1,' . $picUrl;
    }

    /**
     * 生成文字标签
     * @param array|string $location 坐标点
     * @param string $content 标签内容
     * @param int $font 字体 0-微软雅黑 1-宋体 2-Times New Roman 3-Helvetica
     * @param int $bold 是否粗体 0-非粗体 1-粗体
     * @param int $fontSize 可选1-72大小
     * @param string $fontColor 字体色可选 0x000000-0xffffff
     * @param string $background 背景色可选 0x000000-0xffffff
     * @return string 标签字符串
     */
    public function makeLabels($location, $content, $font = 0, $bold = 0, $fontSize = 10, $fontColor = '0xFFFFFF', $background = '0x5288d8') {
        if (is_array($location)) {
            $location = implode(';', $location);
        } else {
            $location = $location . ';';
        }
        $array = [$content, $font, $bold, $fontSize, $fontColor, $background,];
        $Str = implode(',', $array) . ':' . $location;
        return $Str;
    }
    // +----------------------------------------------
    // + 天气查询
    // +----------------------------------------------
    /**
     * 天气查询服务
     * @param string $city 需要查询的城市adcode
     * @param string $extensions 是否返回详细信息 可选 base/all
     * @return bool|mixed 失败返回false/成功返回获取到的数据
     */
    public function weatherInfo($city, $extensions = 'base') {
        $url = 'http://restapi.amap.com/v3/weather/weatherInfo?';
        $Param = [
            'city'       => $city,
            'extensions' => $extensions,
        ];
        return $this->doCurl($url, $Param);
    }
}