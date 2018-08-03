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

// 为方便系统核心升级，二次开发中需要用到的公共函数请写在这个文件，不要去修改common.php文件

/**
 * 发送短信验证码,每个手机号，每分钟只能发送1次，每天最多5次
 * @param string $phone 发送的手机号
 * @param string $send_type 发送的类型标识，用于区别不同的操作
 * @return array 返回[code=0,msg=消息]
 */
function sendSMSCode($phone, $send_type)
{
    //总共每天可以发送多少次
    $allcount = 5;
    $result = ["code" => 1, "msg" => "错误", "count" => 0, "allcount" => $allcount];
    $cache_name = "sendSMSCode_" . $phone . "_" . $send_type;
    $send_count_log = cache($cache_name);

    if ($send_count_log === false) {
        $send_count_log = ["count" => 0, "up_send_time" => 0];
    }
    if ($send_count_log["count"] >= $allcount) {
        $result["msg"] = "手机号已超过今日最大发送次数，请明日再试！";
        return $result;
    }
    if ($send_count_log["up_send_time"] != 0 && $send_count_log["up_send_time"] >= strtotime("-1 Minute")) {
        $result["msg"] = "操作太频繁，请稍后再试！";
        return $result;
    }

    $sms_result = plugin_action('AliDayu/AliDayu/send', [$phone, $send_type]);
    if ($sms_result["code"] == 0) {
        //记录发送数
        $count = ($send_count_log["count"] + 1);
        $send_count_log = ["count" => $count, "up_send_time" => time()];
        $result["count"] = $count;
        $result["allcount"] = $allcount;
        //缓存1天
        cache($cache_name, $send_count_log, 84600);
    } else {
        $result = ["code" => 0, "msg" => $sms_result["msg"], "count" => 0, "allcount" => 0];
    }
    return $result;
}


/**
 * 校验验证码是否正确，校验成功后需要手动删除验证码
 * @param type $code 接收到的验证码
 * @param type $phone 手机号
 * @param type $send_type 发送类型，和发送验证码一致
 */
function ckSMSCode($code, $phone, $send_type = "注册")
{
    $cache_name = "sendCode_" . $phone . "_" . $send_type;
    $send_code = cache($cache_name);

    if ($code == $send_code) {

        return true;
    }
    return false;
}

/**
 * 删除验证码
 * @param type $phone 手机号
 * @param type $send_type 发送类型，和发送验证码一致
 */
function delSMSCode($phone, $send_type = "注册")
{
    //删除验证码
    $cache_name = "sendCode_" . $phone . "_" . $send_type;
    cache($cache_name, null);
}


/**
 * 获取来源域名
 */
function getReffrerDomain()
{
    if (isset($_SERVER['HTTP_REFERER'])) {
        if (empty($_SERVER['HTTP_REFERER'])) {
            return "";
        }
        $reffrer = $_SERVER['HTTP_REFERER'];
        $str = str_replace("http://", "", $reffrer);
        //去掉http://
        $strdomain = explode("/", $str);
        // 以“/”分开成数组
        return $strdomain[0];
        //取第一个“/”以前的字符
    }
}

/**
 * 处理换行
 * @param type $value 原始字符串
 * @return type
 */
function replace_br($value)
{
    return str_replace(PHP_EOL, '<br/>', $value);
}

/**
 * 反射系统模块类函数
 * @param array $params 需要传递的参数
 * @param string $model_class_path 模块的类路径，如lp_company\\home\\Mainuserex
 * @param string $actionName 请求函数
 * @return object 方法返回对象
 * @throws \Exception 类或函数不存在
 */
function actionSys($params, $model_class_path, $actionName)
{
    $moduleName = "app\\" . $model_class_path;

    $reflection = new \ReflectionClass($moduleName);
    if (!$reflection || !$reflection->hasMethod($actionName)) {
        throw new \Exception("类或函数不存在");
    }
    $method = $reflection->getMethod($actionName);
    $handle = $reflection->newInstance();
    $data = $method->invokeArgs($handle, $params);
    return $data;
}

//生成url详情页token
function url_info_token($module, $controller = "", $action = "")
{
    if (is_array($module)) {
        return think_encrypt(json_encode($module));
    }
    return think_encrypt(json_encode([$module, $controller, $action]));
}

//解密url详情页token
function deurl_info_token($token)
{
    return json_decode(think_decrypt($token), true);
}


/** * 加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 (单位:秒)
 * @return string
 */
function think_encrypt($data, $key, $expire = 0)
{
    $key = md5($key);
    $data = base64_encode($data);
    $x = 0;
    $len = strlen($data);
    $l = strlen($key);
    $char = '';
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }
    $str = sprintf('%010d', $expire ? $expire + time() : 0);
    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
    }
    $str = base64_encode($str);
    $str = str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), $str);
    return $str;
}

/**
 * 解密方法
 * @param string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param string $key  加密密钥
 * @return string
 */
function think_decrypt($data, $key)
{
    $data = str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $data);
    $key = md5($key);
    $x = 0;
    $data = base64_decode($data);
    $expire = substr($data, 0, 10);
    $data = substr($data, 10);
    if ($expire > 0 && $expire < time()) {
        return null;
    }
    $len = strlen($data);
    $l = strlen($key);
    $char = $str = '';
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }
    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        } else {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}

/**
 * 计算年龄
 * @param int $age_time
 * @return boolean|int
 */
function getAge($age_time) {
    $age = $age_time;
    if ($age === false) {
        return false;
    }
    list($y1, $m1, $d1) = explode("-", date("Y-m-d", $age));
    $now = strtotime("now");
    list($y2, $m2, $d2) = explode("-", date("Y-m-d", $now));
    $age = $y2 - $y1;
    if ((int)($m2 . $d2) < (int)($m1 . $d1))
        $age -= 1;
    return $age;
}


/*
 * 计算星座的函数 string get_zodiac_sign(string month, string day)
 * 输入：月份，日期
 * 输出：星座名称或者错误信息
 */

function get_zodiac_sign($month, $day) {
    // 检查参数有效性
    if ($month < 1 || $month > 12 || $day < 1 || $day > 31) {
        return (false);
    }

    // 星座名称以及开始日期
    $signs = array( array("20" => "水瓶座"), array("19" => "双鱼座"), array("21" => "白羊座"), array("20" => "金牛座"), array("21" => "双子座"), array("22" => "巨蟹座"), array("23" => "狮子座"), array("23" => "处女座"), array("23" => "天秤座"), array("24" => "天蝎座"), array("22" => "射手座"), array("22" => "摩羯座"), );
    list($sign_start, $sign_name) = each($signs[(int)$month - 1]);
    if ($day < $sign_start) {
        list($sign_start, $sign_name) = each($signs[($month - 2 < 0) ? $month = 11 : $month -= 2]);
    }

    return $sign_name;
}

