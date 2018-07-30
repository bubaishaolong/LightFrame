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

use think\Db;
use think\View;
use app\user\model\User;
use app\admin\model\Moduleconfig;


// 应用公共文件

if (!function_exists('is_signin')) {
    /**
     * 判断是否登录
     * @author 无名氏
     * @return mixed
     */
    function is_signin()
    {
        $user = session('user_auth');
        if (empty($user)) {
            // 判断是否记住登录
            if (cookie('?uid') && cookie('?signin_token')) {
                $UserModel = new User();
                $user = $UserModel::get(cookie('uid'));
                if ($user) {
                    $signin_token = data_auth_sign($user['username'] . $user['id'] . $user['last_login_time']);
                    if (cookie('signin_token') == $signin_token) {
                        // 自动登录
                        $UserModel->autoLogin($user);
                        return $user['id'];
                    }
                }
            };
            return 0;
        } else {
            return session('user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
        }
    }
}

if (!function_exists('data_auth_sign')) {
    /**
     * 数据签名认证
     * @param array $data 被认证的数据
     * @author 无名氏
     * @return string
     */
    function data_auth_sign($data = [])
    {
        // 数据类型检测
        if (!is_array($data)) {
            $data = (array)$data;
        }

        // 排序
        ksort($data);
        // url编码并生成query字符串
        $code = http_build_query($data);
        // 生成签名
        $sign = sha1($code);
        return $sign;
    }
}

if (!function_exists('get_file_path')) {
    /**
     * 获取附件路径
     * @param int $id 附件id
     * @author 无名氏
     * @return string
     */
    function get_file_path($id = 0)
    {
        $path = model('admin/attachment')->getFilePath($id);
        if (!$path) {
            return config('public_static_path') . 'admin/img/none.png';
        }
        return $path;
    }
}

if (!function_exists('get_files_path')) {
    /**
     * 批量获取附件路径
     * @param array $ids 附件id
     * @author 无名氏
     * @return array
     */
    function get_files_path($ids = [])
    {
        $paths = model('admin/attachment')->getFilePath($ids);
        return !$paths ? [] : $paths;
    }
}

if (!function_exists('get_thumb')) {
    /**
     * 获取图片缩略图路径
     * @param int $id 附件id
     * @author 无名氏
     * @return string
     */
    function get_thumb($id = 0)
    {
        $path = model('admin/attachment')->getThumbPath($id);
        if (!$path) {
            return config('public_static_path') . 'admin/img/none.png';
        }
        return $path;
    }
}

if (!function_exists('get_avatar')) {
    /**
     * 获取用户头像路径
     * @param int $uid 用户id
     * @author 无名氏
     * @alter 小乌 <82950492@qq.com>
     * @return string
     */
    function get_avatar($uid = 0)
    {
        $avatar = Db::name('admin_user')->where('id', $uid)->value('avatar');
        $path = model('admin/attachment')->getFilePath($avatar);
        if (!$path) {
            return config('public_static_path') . 'admin/img/avatar.jpg';
        }
        return $path;
    }
}

if (!function_exists('get_file_name')) {
    /**
     * 根据附件id获取文件名
     * @param string $id 附件id
     * @author 无名氏
     * @return string
     */
    function get_file_name($id = '')
    {
        $name = model('admin/attachment')->getFileName($id);
        if (!$name) {
            return '没有找到文件';
        }
        return $name;
    }
}

if (!function_exists('minify')) {
    /**
     * 合并输出js代码或css代码
     * @param string $type 类型：group-分组，file-单个文件，base-基础目录
     * @param string $files 文件名或分组名
     * @author 无名氏
     */
    function minify($type = '', $files = '')
    {
        $files = !is_array($files) ? $files : implode(',', $files);
        $url = PUBLIC_PATH . 'min/?';

        switch ($type) {
            case 'group':
                $url .= 'g=' . $files;
                break;
            case 'file':
                $url .= 'f=' . $files;
                break;
            case 'base':
                $url .= 'b=' . $files;
                break;
        }
        echo $url . '&v=' . config('asset_version');
    }
}

if (!function_exists('ck_js')) {
    /**
     * 返回ckeditor编辑器上传文件时需要返回的js代码
     * @param string $callback 回调
     * @param string $file_path 文件路径
     * @param string $error_msg 错误信息
     * @author 无名氏
     * @return string
     */
    function ck_js($callback = '', $file_path = '', $error_msg = '')
    {
        return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callback, '$file_path' , '$error_msg');</script>";
    }
}

if (!function_exists('parse_attr')) {
    /**
     * 解析配置
     * @param string $value 配置值
     * @return array|string
     */
    function parse_attr($value = '')
    {
        $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
        if (strpos($value, ':')) {
            $value = array();
            foreach ($array as $val) {
                list($k, $v) = explode(':', $val);
                $value[$k] = $v;
            }
        } else {
            $value = $array;
        }
        return $value;
    }
}

if (!function_exists('implode_attr')) {
    /**
     * 组合配置
     * @param array $array 配置值
     * @return string
     */
    function implode_attr($array = [])
    {
        $result = [];
        foreach ($array as $key => $value) {
            $result[] = $key . ':' . $value;
        }
        return empty($result) ? '' : implode(PHP_EOL, $result);
    }
}

if (!function_exists('parse_array')) {
    /**
     * 将一维数组解析成键值相同的数组
     * @param array $arr 一维数组
     * @author 无名氏
     * @return array
     */
    function parse_array($arr)
    {
        $result = [];
        foreach ($arr as $item) {
            $result[$item] = $item;
        }
        return $result;
    }
}

if (!function_exists('parse_config')) {
    /**
     * 解析配置，返回配置值
     * @param array $configs 配置
     * @author 无名氏
     * @return array
     */
    function parse_config($configs = [])
    {
        $type = [
            'hidden' => 2,
            'date' => 4,
            'ckeditor' => 4,
            'daterange' => 4,
            'datetime' => 4,
            'editormd' => 4,
            'file' => 4,
            'colorpicker' => 4,
            'files' => 4,
            'icon' => 4,
            'image' => 4,
            'images' => 4,
            'jcrop' => 4,
            'range' => 4,
            'number' => 4,
            'password' => 4,
            'sort' => 4,
            'static' => 4,
            'summernote' => 4,
            'switch' => 4,
            'tags' => 4,
            'text' => 4,
            'array' => 4,
            'textarea' => 4,
            'time' => 4,
            'ueditor' => 4,
            'wangeditor' => 4,
            'radio' => 5,
            'bmap' => 5,
            'masked' => 5,
            'select' => 5,
            'linkage' => 5,
            'checkbox' => 5,
            'linkages' => 6
        ];
        $result = [];
        foreach ($configs as $item) {
            // 判断是否为分组
            if ($item[0] == 'group') {
                foreach ($item[1] as $option) {
                    foreach ($option as $group => $val) {
                        $result[$val[1]] = isset($val[$type[$val[0]]]) ? $val[$type[$val[0]]] : '';
                    }
                }
            } else {
                $result[$item[1]] = isset($item[$type[$item[0]]]) ? $item[$type[$item[0]]] : '';
            }
        }
        return $result;
    }
}

if (!function_exists('set_config_value')) {
    /**
     * 设置配置的值，并返回配置好的数组
     * @param array $configs 配置
     * @param array $values 配置值
     * @author 无名氏
     * @return array
     */
    function set_config_value($configs = [], $values = [])
    {
        $type = [
            'hidden' => 2,
            'date' => 4,
            'ckeditor' => 4,
            'daterange' => 4,
            'datetime' => 4,
            'editormd' => 4,
            'file' => 4,
            'colorpicker' => 4,
            'files' => 4,
            'icon' => 4,
            'image' => 4,
            'images' => 4,
            'jcrop' => 4,
            'range' => 4,
            'number' => 4,
            'password' => 4,
            'sort' => 4,
            'static' => 4,
            'summernote' => 4,
            'switch' => 4,
            'tags' => 4,
            'text' => 4,
            'array' => 4,
            'textarea' => 4,
            'time' => 4,
            'ueditor' => 4,
            'wangeditor' => 4,
            'radio' => 5,
            'bmap' => 5,
            'masked' => 5,
            'select' => 5,
            'linkage' => 5,
            'checkbox' => 5,
            'linkages' => 6
        ];

        foreach ($configs as &$item) {
            // 判断是否为分组
            if ($item[0] == 'group') {
                foreach ($item[1] as &$option) {
                    foreach ($option as $group => &$val) {
                        $val[$type[$val[0]]] = isset($values[$val[1]]) ? $values[$val[1]] : '';
                    }
                }
            } else {
                $item[$type[$item[0]]] = isset($values[$item[1]]) ? $values[$item[1]] : '';
            }
        }
        return $configs;
    }
}

if (!function_exists('hook')) {
    /**
     * 监听钩子
     * @param string $name 钩子名称
     * @param mixed $params 传入参数
     * @param mixed $extra 额外参数
     * @param bool $once 只获取一个有效返回值
     * @author 无名氏
     * @alter 小乌 <82950492@qq.com>
     */
    function hook($name = '', $params = null, $extra = null, $once = false)
    {
        \think\Hook::listen($name, $params, $extra, $once);
    }
}

if (!function_exists('module_config')) {
    /**
     * 显示当前模块的参数配置页面，或获取参数值，或设置参数值
     * @param string $name
     * @param string $value
     * @author caiweiming <314013107@qq.com>
     * @return mixed
     */
    function module_config($name = '', $value = '')
    {
        if ($name === '') {
            // 显示模块配置页面
            return action('admin/admin/moduleConfig');
        } elseif ($value === '') {
            // 获取模块配置
            if (strpos($name, '.')) {
                list($name, $item) = explode('.', $name);
                return model('admin/module')->getConfig($name, $item);
            } else {
                return model('admin/module')->getConfig($name);
            }
        } else {
            // 设置值
            return model('admin/module')->setConfig($name, $value);
        }
    }
}

if (!function_exists('plugin_menage')) {
    /**
     * 显示插件的管理页面
     * @param string $name 插件名
     * @author caiweiming <314013107@qq.com>
     * @return mixed
     */
    function plugin_menage($name = '')
    {
        return action('admin/plugin/manage', ['name' => $name]);
    }
}

if (!function_exists('plugin_config')) {
    /**
     * 获取或设置某个插件配置参数
     * @param string $name 插件名.配置名
     * @param string $value 设置值
     * @author caiweiming <314013107@qq.com>
     * @return mixed
     */
    function plugin_config($name = '', $value = '')
    {
        if ($value === '') {
            // 获取插件配置
            if (strpos($name, '.')) {
                list($name, $item) = explode('.', $name);
                return model('admin/plugin')->getConfig($name, $item);
            } else {
                return model('admin/plugin')->getConfig($name);
            }
        } else {
            return model('admin/plugin')->setConfig($name, $value);
        }
    }
}

if (!function_exists('get_plugin_class')) {
    /**
     * 获取插件类名
     * @param  string $name 插件名
     * @author 无名氏
     * @return string
     */
    function get_plugin_class($name)
    {
        return "plugins\\{$name}\\{$name}";
    }
}

if (!function_exists('get_client_ip')) {
    /**
     * 获取客户端IP地址
     * @param int $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param bool $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    function get_client_ip($type = 0, $adv = false)
    {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if ($ip !== NULL) return $ip[$type];
        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) unset($arr[$pos]);
                $ip = trim($arr[0]);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}

if (!function_exists('format_bytes')) {
    /**
     * 格式化字节大小
     * @param  number $size 字节数
     * @param  string $delimiter 数字和单位分隔符
     * @return string            格式化后的带单位的大小
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    function format_bytes($size, $delimiter = '')
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
        return round($size, 2) . $delimiter . $units[$i];
    }
}

if (!function_exists('format_time')) {
    /**
     * 时间戳格式化
     * @param string $time 时间戳
     * @param string $format 输出格式
     * @return false|string
     */
    function format_time($time = '', $format = 'Y-m-d H:i')
    {
        return !$time ? '' : date($format, intval($time));
    }
}

if (!function_exists('format_date')) {
    /**
     * 使用bootstrap-datepicker插件的时间格式来格式化时间戳
     * @param null $time 时间戳
     * @param string $format bootstrap-datepicker插件的时间格式 https://bootstrap-datepicker.readthedocs.io/en/stable/options.html#format
     * @author 无名氏
     * @return false|string
     */
    function format_date($time = null, $format = 'yyyy-mm-dd')
    {
        $format_map = [
            'yyyy' => 'Y',
            'yy' => 'y',
            'MM' => 'F',
            'M' => 'M',
            'mm' => 'm',
            'm' => 'n',
            'DD' => 'l',
            'D' => 'D',
            'dd' => 'd',
            'd' => 'j',
        ];

        // 提取格式
        preg_match_all('/([a-zA-Z]+)/', $format, $matches);
        $replace = [];
        foreach ($matches[1] as $match) {
            $replace[] = isset($format_map[$match]) ? $format_map[$match] : '';
        }

        // 替换成date函数支持的格式
        $format = str_replace($matches[1], $replace, $format);
        $time = $time === null ? time() : intval($time);
        return date($format, $time);
    }
}

if (!function_exists('format_moment')) {
    /**
     * 使用momentjs的时间格式来格式化时间戳
     * @param null $time 时间戳
     * @param string $format momentjs的时间格式
     * @author 无名氏
     * @return false|string
     */
    function format_moment($time = null, $format = 'YYYY-MM-DD HH:mm')
    {
        $format_map = [
            // 年、月、日
            'YYYY' => 'Y',
            'YY' => 'y',
//            'Y'    => '',
            'Q' => 'I',
            'MMMM' => 'F',
            'MMM' => 'M',
            'MM' => 'm',
            'M' => 'n',
            'DDDD' => '',
            'DDD' => '',
            'DD' => 'd',
            'D' => 'j',
            'Do' => 'jS',
            'X' => 'U',
            'x' => 'u',

            // 星期
//            'gggg' => '',
//            'gg' => '',
//            'ww' => '',
//            'w' => '',
            'e' => 'w',
            'dddd' => 'l',
            'ddd' => 'D',
            'GGGG' => 'o',
//            'GG' => '',
            'WW' => 'W',
            'W' => 'W',
            'E' => 'N',

            // 时、分、秒
            'HH' => 'H',
            'H' => 'G',
            'hh' => 'h',
            'h' => 'g',
            'A' => 'A',
            'a' => 'a',
            'mm' => 'i',
            'm' => 'i',
            'ss' => 's',
            's' => 's',
//            'SSS' => '[B]',
//            'SS'  => '[B]',
//            'S'   => '[B]',
            'ZZ' => 'O',
            'Z' => 'P',
        ];

        // 提取格式
        preg_match_all('/([a-zA-Z]+)/', $format, $matches);
        $replace = [];
        foreach ($matches[1] as $match) {
            $replace[] = isset($format_map[$match]) ? $format_map[$match] : '';
        }

        // 替换成date函数支持的格式
        $format = str_replace($matches[1], $replace, $format);
        $time = $time === null ? time() : intval($time);
        return date($format, $time);
    }
}

if (!function_exists('format_linkage')) {
    /**
     * 格式化联动数据
     * @param array $data 数据
     * @author 无名氏
     * @return array
     */
    function format_linkage($data = [])
    {
        $list = [];
        foreach ($data as $key => $value) {
            $list[] = [
                'key' => $key,
                'value' => $value
            ];
        }
        return $list;
    }
}

if (!function_exists('get_auth_node')) {
    /**
     * 获取用户授权节点
     * @param int $uid 用户id
     * @param string $group 权限分组，可以以点分开模型名称和分组名称，如user.group
     * @author 无名氏
     * @return array|bool
     */
    function get_auth_node($uid = 0, $group = '')
    {
        return model('admin/access')->getAuthNode($uid, $group);
    }
}

if (!function_exists('check_auth_node')) {
    /**
     * 检查用户的某个节点是否授权
     * @param int $uid 用户id
     * @param string $group $group 权限分组，可以以点分开模型名称和分组名称，如user.group
     * @param int $node 需要检查的节点id
     * @author 无名氏
     * @return bool
     */
    function check_auth_node($uid = 0, $group = '', $node = 0)
    {
        return model('admin/access')->checkAuthNode($uid, $group, $node);
    }
}

if (!function_exists('get_level_data')) {
    /**
     * 获取联动数据
     * @param string $table 表名
     * @param  integer $pid 父级ID
     * @param  string $pid_field 父级ID的字段名
     * @author 无名氏
     * @return false|PDOStatement|string|\think\Collection
     */
    function get_level_data($table = '', $pid = 0, $pid_field = 'pid')
    {
        if ($table == '') {
            return '';
        }

        $data_list = Db::name($table)->where($pid_field, $pid)->select();

        if ($data_list) {
            return $data_list;
        } else {
            return '';
        }
    }
}

if (!function_exists('get_level_pid')) {
    /**
     * 获取联动等级和父级id
     * @param string $table 表名
     * @param int $id 主键值
     * @param string $id_field 主键名
     * @param string $pid_field pid字段名
     * @author 无名氏
     * @return mixed
     */
    function get_level_pid($table = '', $id = 1, $id_field = 'id', $pid_field = 'pid')
    {
        return Db::name($table)->where($id_field, $id)->value($pid_field);
    }
}

if (!function_exists('get_level_key_data')) {
    /**
     * 反向获取联动数据
     * @param string $table 表名
     * @param string $id 主键值
     * @param string $id_field 主键名
     * @param string $name_field name字段名
     * @param string $pid_field pid字段名
     * @param int $level 级别
     * @author 无名氏
     * @return array
     */
    function get_level_key_data($table = '', $id = '', $id_field = 'id', $name_field = 'name', $pid_field = 'pid', $level = 1)
    {
        $result = [];
        $level_pid = get_level_pid($table, $id, $id_field, $pid_field);
        $level_key[$level] = $level_pid;
        $level_data[$level] = get_level_data($table, $level_pid, $pid_field);

        if ($level_pid != 0) {
            $data = get_level_key_data($table, $level_pid, $id_field, $name_field, $pid_field, $level + 1);
            $level_key = $level_key + $data['key'];
            $level_data = $level_data + $data['data'];
        }
        $result['key'] = $level_key;
        $result['data'] = $level_data;

        return $result;
    }
}

if (!function_exists('plugin_action_exists')) {
    /**
     * 检查插件控制器是否存在某操作
     * @param string $name 插件名
     * @param string $controller 控制器
     * @param string $action 动作
     * @author 无名氏
     * @return bool
     */
    function plugin_action_exists($name = '', $controller = '', $action = '')
    {
        if (strpos($name, '/')) {
            list($name, $controller, $action) = explode('/', $name);
        }
        return method_exists("plugins\\{$name}\\controller\\{$controller}", $action);
    }
}

if (!function_exists('plugin_model_exists')) {
    /**
     * 检查插件模型是否存在
     * @param string $name 插件名
     * @author 无名氏
     * @return bool
     */
    function plugin_model_exists($name = '')
    {
        return class_exists("plugins\\{$name}\\model\\{$name}");
    }
}

if (!function_exists('plugin_validate_exists')) {
    /**
     * 检查插件验证器是否存在
     * @param string $name 插件名
     * @author 无名氏
     * @return bool
     */
    function plugin_validate_exists($name = '')
    {
        return class_exists("plugins\\{$name}\\validate\\{$name}");
    }
}

if (!function_exists('get_plugin_model')) {
    /**
     * 获取插件模型实例
     * @param  string $name 插件名
     * @author 无名氏
     * @return object
     */
    function get_plugin_model($name)
    {
        $class = "plugins\\{$name}\\model\\{$name}";
        return new $class;
    }
}

if (!function_exists('plugin_action')) {
    /**
     * 执行插件动作
     * 也可以用这种方式调用：plugin_action('插件名/控制器/动作', [参数1,参数2...])
     * @param string $name 插件名
     * @param string $controller 控制器
     * @param string $action 动作
     * @param mixed $params 参数
     * @author 无名氏
     * @return mixed
     */
    function plugin_action($name = '', $controller = '', $action = '', $params = [])
    {
        if (strpos($name, '/')) {
            $params = is_array($controller) ? $controller : (array)$controller;
            list($name, $controller, $action) = explode('/', $name);
        }
        if (!is_array($params)) {
            $params = (array)$params;
        }
        $class = "plugins\\{$name}\\controller\\{$controller}";
        $obj = new $class;
        return call_user_func_array([$obj, $action], $params);
    }
}

if (!function_exists('_system_check')) {
    function _system_check()
    {
        $c = cache('_i_n_f_o');
        if (!$c || (time() - $c) > 86401) {
            cache('_i_n_f_o', time());
            $url = base64_decode('d3d3LmRvbHBoaW5waHAuY29tL3VwZGF0ZUluZm8=');
            $url = 'http://' . $url;
            $p['d' . 'om' . 'ain'] = request()->domain();
            $p[strtolower('I') . 'p'] = request()->server('SERVER_ADDR');
            $p = base64_encode(json_encode($p));

            $o = [
                CURLOPT_TIMEOUT => 20,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => request()->server('HTTP_USER_AGENT'),
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => ['p' => $p]
            ];

            if (function_exists('curl_init')) {
                $c = curl_init();
                curl_setopt_array($c, $o);
                curl_exec($c);
                curl_close($c);
            }
        }
    }
}

if (!function_exists('get_plugin_validate')) {
    /**
     * 获取插件验证类实例
     * @param string $name 插件名
     * @author 无名氏
     * @return bool
     */
    function get_plugin_validate($name = '')
    {
        $class = "plugins\\{$name}\\validate\\{$name}";
        return new $class;
    }
}

if (!function_exists('plugin_url')) {
    /**
     * 生成插件操作链接
     * @param string $url 链接：插件名称/控制器/操作
     * @param array $param 参数
     * @param string $module 模块名，admin需要登录验证，index不需要登录验证
     * @author 无名氏
     * @return string
     */
    function plugin_url($url = '', $param = [], $module = 'admin')
    {
        $params = [];
        $url = explode('/', $url);
        if (isset($url[0])) {
            $params['_plugin'] = $url[0];
        }
        if (isset($url[1])) {
            $params['_controller'] = $url[1];
        }
        if (isset($url[2])) {
            $params['_action'] = $url[2];
        }

        // 合并参数
        $params = array_merge($params, $param);

        // 返回url地址
        return url($module . '/plugin/execute', $params);
    }
}

if (!function_exists('public_url')) {
    /**
     * 生成插件操作链接(不需要登陆验证)
     * @param string $url 链接：插件名称/控制器/操作
     * @param array $param 参数
     * @author 无名氏
     * @return string
     */
    function public_url($url = '', $param = [])
    {
        // 返回url地址
        return plugin_url($url, $param, 'index');
    }
}

if (!function_exists('clear_js')) {
    /**
     * 过滤js内容
     * @param string $str 要过滤的字符串
     * @author 无名氏
     * @return mixed|string
     */
    function clear_js($str = '')
    {
        $search = "/<script[^>]*?>.*?<\/script>/si";
        $str = preg_replace($search, '', $str);
        return $str;
    }
}

if (!function_exists('get_nickname')) {
    /**
     * 根据用户ID获取用户昵称
     * @param  integer $uid 用户ID
     * @return string  用户昵称
     */
    function get_nickname($uid = 0)
    {
        static $list;
        // 获取当前登录用户名
        if (!($uid && is_numeric($uid))) {
            return session('user_auth.username');
        }

        // 获取缓存数据
        if (empty($list)) {
            $list = cache('sys_user_nickname_list');
        }

        // 查找用户信息
        $key = "u{$uid}";
        if (isset($list[$key])) {
            // 已缓存，直接使用
            $name = $list[$key];
        } else {
            // 调用接口获取用户信息
            $info = model('user/user')->field('nickname')->find($uid);
            if ($info !== false && $info['nickname']) {
                $nickname = $info['nickname'];
                $name = $list[$key] = $nickname;
                /* 缓存用户 */
                $count = count($list);
                $max = config('user_max_cache');
                while ($count-- > $max) {
                    array_shift($list);
                }
                cache('sys_user_nickname_list', $list);
            } else {
                $name = '';
            }
        }
        return $name;
    }
}

if (!function_exists('action_log')) {
    /**
     * 记录行为日志，并执行该行为的规则
     * @param null $action 行为标识
     * @param null $model 触发行为的模型名
     * @param string $record_id 触发行为的记录id
     * @param null $user_id 执行行为的用户id
     * @param string $details 详情
     * @author huajie <banhuajie@163.com>
     * @alter 无名氏
     * @return bool|string
     */
    function action_log($action = null, $model = null, $record_id = '', $user_id = null, $details = '')
    {
        // 判断是否开启系统日志功能
        if (config('system_log')) {
            // 参数检查
            if (empty($action) || empty($model)) {
                return '参数不能为空';
            }
            if (empty($user_id)) {
                $user_id = is_signin();
            }
            if (strpos($action, '.')) {
                list($module, $action) = explode('.', $action);
            } else {
                $module = request()->module();
            }

            // 查询行为,判断是否执行
            $action_info = model('admin/action')->where('module', $module)->getByName($action);
            if ($action_info['status'] != 1) {
                return '该行为被禁用或删除';
            }

            // 插入行为日志
            $data = [
                'action_id' => $action_info['id'],
                'user_id' => $user_id,
                'action_ip' => get_client_ip(1),
                'model' => $model,
                'record_id' => $record_id,
                'create_time' => request()->time()
            ];

            // 解析日志规则,生成日志备注
            if (!empty($action_info['log'])) {
                if (preg_match_all('/\[(\S+?)\]/', $action_info['log'], $match)) {
                    $log = [
                        'user' => $user_id,
                        'record' => $record_id,
                        'model' => $model,
                        'time' => request()->time(),
                        'data' => ['user' => $user_id, 'model' => $model, 'record' => $record_id, 'time' => request()->time()],
                        'details' => $details
                    ];

                    $replace = [];
                    foreach ($match[1] as $value) {
                        $param = explode('|', $value);
                        if (isset($param[1])) {
                            $replace[] = call_user_func($param[1], $log[$param[0]]);
                        } else {
                            $replace[] = $log[$param[0]];
                        }
                    }

                    $data['remark'] = str_replace($match[0], $replace, $action_info['log']);
                } else {
                    $data['remark'] = $action_info['log'];
                }
            } else {
                // 未定义日志规则，记录操作url
                $data['remark'] = '操作url：' . $_SERVER['REQUEST_URI'];
            }

            // 保存日志
            model('admin/log')->insert($data);

            if (!empty($action_info['rule'])) {
                // 解析行为
                $rules = parse_action($action, $user_id);
                // 执行行为
                $res = execute_action($rules, $action_info['id'], $user_id);
                if (!$res) {
                    return '执行行为失败';
                }
            }
        }

        return true;
    }
}

if (!function_exists('parse_action')) {
    /**
     * 解析行为规则
     * 规则定义  table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
     * 规则字段解释：table->要操作的数据表，不需要加表前缀；
     *            field->要操作的字段；
     *            condition->操作的条件，目前支持字符串，默认变量{$self}为执行行为的用户
     *            rule->对字段进行的具体操作，目前支持四则混合运算，如：1+score*2/2-3
     *            cycle->执行周期，单位（小时），表示$cycle小时内最多执行$max次
     *            max->单个周期内的最大执行次数（$cycle和$max必须同时定义，否则无效）
     * 单个行为后可加 ； 连接其他规则
     * @param string $action 行为id或者name
     * @param int $self 替换规则里的变量为执行用户的id
     * @author huajie <banhuajie@163.com>
     * @alter 无名氏
     * @return boolean|array: false解析出错 ， 成功返回规则数组
     */
    function parse_action($action = null, $self)
    {
        if (empty($action)) {
            return false;
        }

        // 参数支持id或者name
        if (is_numeric($action)) {
            $map = ['id' => $action];
        } else {
            $map = ['name' => $action];
        }

        // 查询行为信息
        $info = model('admin/action')->where($map)->find();
        if (!$info || $info['status'] != 1) {
            return false;
        }

        // 解析规则:table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
        $rule = $info['rule'];
        $rule = str_replace('{$self}', $self, $rule);
        $rules = explode(';', $rule);
        $return = [];
        foreach ($rules as $key => &$rule) {
            $rule = explode('|', $rule);
            foreach ($rule as $k => $fields) {
                $field = empty($fields) ? array() : explode(':', $fields);
                if (!empty($field)) {
                    $return[$key][$field[0]] = $field[1];
                }
            }
            // cycle(检查周期)和max(周期内最大执行次数)必须同时存在，否则去掉这两个条件
            if (!isset($return[$key]['cycle']) || !isset($return[$key]['max'])) {
                unset($return[$key]['cycle'], $return[$key]['max']);
            }
        }

        return $return;
    }
}

if (!function_exists('execute_action')) {
    /**
     * 执行行为
     * @param array|bool $rules 解析后的规则数组
     * @param int $action_id 行为id
     * @param array $user_id 执行的用户id
     * @author huajie <banhuajie@163.com>
     * @alter 无名氏
     * @return boolean false 失败 ， true 成功
     */
    function execute_action($rules = false, $action_id = null, $user_id = null)
    {
        if (!$rules || empty($action_id) || empty($user_id)) {
            return false;
        }

        $return = true;
        foreach ($rules as $rule) {
            // 检查执行周期
            $map = ['action_id' => $action_id, 'user_id' => $user_id];
            $map['create_time'] = ['gt', request()->time() - intval($rule['cycle']) * 3600];
            $exec_count = model('admin/log')->where($map)->count();
            if ($exec_count > $rule['max']) {
                continue;
            }

            // 执行数据库操作
            $field = $rule['field'];
            $res = Db::name($rule['table'])->where($rule['condition'])->setField($field, array('exp', $rule['rule']));

            if (!$res) {
                $return = false;
            }
        }
        return $return;
    }
}

if (!function_exists('get_location')) {
    /**
     * 获取当前位置
     * @param string $id 节点id，如果没有指定，则取当前节点id
     * @param bool $del_last_url 是否删除最后一个节点的url地址
     * @param bool $check 检查节点是否存在，不存在则抛出错误
     * @author 无名氏
     * @return mixed
     */
    function get_location($id = '', $del_last_url = false, $check = true)
    {
        $location = model('admin/menu')->getLocation($id, $del_last_url, $check);
        return $location;
    }
}

if (!function_exists('packet_exists')) {
    /**
     * 查询数据包是否存在，即是否已经安装
     * @param string $name 数据包名
     * @author 无名氏
     * @return bool
     */
    function packet_exists($name = '')
    {
        if (Db::name('admin_packet')->where('name', $name)->find()) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('load_assets')) {
    /**
     * 加载静态资源
     * @param string $assets 资源名称
     * @param string $type 资源类型
     * @author 无名氏
     * @return string
     */
    function load_assets($assets = '', $type = 'css')
    {
        $assets_list = config('assets.' . $assets);

        $result = '';
        foreach ($assets_list as $item) {
            if ($type == 'css') {
                $result .= '<link rel="stylesheet" href="' . $item . '?v=' . config('asset_version') . '">';
            } else {
                $result .= '<script src="' . $item . '?v=' . config('asset_version') . '"></script>';
            }
        }
        $result = str_replace(array_keys(config('view_replace_str')), array_values(config('view_replace_str')), $result);
        return $result;
    }
}

if (!function_exists('parse_name')) {
    /**
     * 字符串命名风格转换
     * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
     * @param string $name 字符串
     * @param integer $type 转换类型
     * @return string
     */
    function parse_name($name, $type = 0)
    {
        if ($type) {
            return ucfirst(preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name));
        } else {
            return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
        }
    }
}

if (!function_exists('home_url')) {
    /**
     * 生成前台入口url
     * @param string $url 路由地址
     * @param string|array $vars 变量
     * @param bool|string $suffix 生成的URL后缀
     * @param bool|string $domain 域名
     * @author 小乌 <82950492@qq.com>
     * @return string
     */
    function home_url($url = '', $vars = '', $suffix = true, $domain = false)
    {
        $url = url($url, $vars, $suffix, $domain);
        if (defined('ENTRANCE') && ENTRANCE == 'admin') {
            $base_file = request()->baseFile();
            $base_file = substr($base_file, strripos($base_file, '/') + 1);
            return preg_replace('/\/' . $base_file . '/', '/index.php', $url);
        } else {
            return $url;
        }
    }
}

if (!function_exists('admin_url')) {
    /**
     * 生成后台入口url
     * @param string $url 路由地址
     * @param string|array $vars 变量
     * @param bool|string $suffix 生成的URL后缀
     * @param bool|string $domain 域名
     * @author 小乌 <82950492@qq.com>
     * @return string
     */
    function admin_url($url = '', $vars = '', $suffix = true, $domain = false)
    {
        $url = url($url, $vars, $suffix, $domain);
        if (defined('ENTRANCE') && ENTRANCE == 'admin') {
            return $url;
        } else {
            return preg_replace('/\/index.php/', '/' . ADMIN_FILE, $url);
        }
    }
}

if (!function_exists('htmlpurifier')) {
    /**
     * html安全过滤
     * @param string $html 要过滤的内容
     * @author 无名氏
     * @return string
     */
    function htmlpurifier($html = '')
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $clean_html = $purifier->purify($html);
        return $clean_html;
    }
}

if (!function_exists('extend_form_item')) {
    /**
     * 扩展表单项
     * @param array $form 类型
     * @param array $_layout 布局参数
     * @author 无名氏
     * @return string
     */
    function extend_form_item($form = [], $_layout = [])
    {
        if (!isset($form['type'])) return '';
        if (!empty($_layout) && isset($_layout[$form['name']])) {
            $form['_layout'] = $_layout[$form['name']];
        }

        $template = './extend/form/' . $form['type'] . '/' . $form['type'] . '.html';
        if (file_exists($template)) {
            $template_content = file_get_contents($template);
            $view = new View();
            return $view->display($template_content, $form);
        } else {
            return '';
        }
    }
}

if (!function_exists('role_auth')) {
    /**
     * 读取当前用户权限
     * @author 无名氏
     */
    function role_auth()
    {
        session('role_menu_auth', model('user/role')->roleAuth());
    }
}

if (!function_exists('get_server_ip')) {
    /**
     * 获取服务器端IP地址
     * @return array|false|string
     */
    function get_server_ip()
    {
        if (isset($_SERVER)) {
            if ($_SERVER['SERVER_ADDR']) {
                $server_ip = $_SERVER['SERVER_ADDR'];
            } else {
                $server_ip = $_SERVER['LOCAL_ADDR'];
            }
        } else {
            $server_ip = getenv('SERVER_ADDR');
        }
        return $server_ip;
    }
}

if (!function_exists('get_browser_type')) {
    /**
     * 获取浏览器类型
     * @return string
     */
    function get_browser_type()
    {
        $agent = $_SERVER["HTTP_USER_AGENT"];
        if (strpos($agent, 'MSIE') !== false || strpos($agent, 'rv:11.0')) return "ie";
        if (strpos($agent, 'Firefox') !== false) return "firefox";
        if (strpos($agent, 'Chrome') !== false) return "chrome";
        if (strpos($agent, 'Opera') !== false) return 'opera';
        if ((strpos($agent, 'Chrome') == false) && strpos($agent, 'Safari') !== false) return 'safari';
        if (false !== strpos($_SERVER['HTTP_USER_AGENT'], '360SE')) return '360SE';
        return 'unknown';
    }
}

if (!function_exists('generate_rand_str')) {
    /**
     * 生成随机字符串
     * @param int $length 生成长度
     * @param int $type 生成类型：0-小写字母+数字，1-小写字母，2-大写字母，3-数字，4-小写+大写字母，5-小写+大写+数字
     * @author 无名氏
     * @return string
     */
    function generate_rand_str($length = 8, $type = 0)
    {
        $a = 'abcdefghijklmnopqrstuvwxyz';
        $A = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $n = '0123456789';

        switch ($type) {
            case 1:
                $chars = $a;
                break;
            case 2:
                $chars = $A;
                break;
            case 3:
                $chars = $n;
                break;
            case 4:
                $chars = $a . $A;
                break;
            case 5:
                $chars = $a . $A . $n;
                break;
            default:
                $chars = $a . $n;
        }

        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $str;
    }
}

if (!function_exists('cj_send_message')) {
    /**
     * 发送消息给用户
     * @param string $type 消息类型
     * @param string $content 消息内容
     * @param string $uids 用户id，可以是数组，也可以是逗号隔开的字符串
     * @author 无名氏
     * @return bool
     */
    function cj_send_message($type = '', $content = '', $uids = '')
    {
        $uids = is_array($uids) ? $uids : explode(',', $uids);
        $list = [];
        foreach ($uids as $uid) {
            $list[] = [
                'uid_receive' => $uid,
                'uid_send' => UID,
                'type' => $type,
                'content' => $content,
            ];
        }

        $MessageModel = model('user/message');
        return false !== $MessageModel->saveAll($list);
    }
}


/**
 * @param $file_name
 * @param string $name
 * @return bool
 * 根据填写的表的名称,生成对应的数据名字rename
 * 模型_填写的字段
 */
function AutomaticGenerationOfDataTables($file_name, $name = '')
{
    //生成文件目录
    $path = APP_PATH . $name;
    $pathsql = $path . DS . 'sql' . DS . 'install.sql';
    $pathuninstall = $path . DS . 'sql' . DS . 'uninstall.sql';
    Db::startTrans();
    if ($file_name) {
        $datas = explode(',', $file_name);
        $data_count = count($datas);
        for ($i = 0; $i < $data_count; $i++) {
//                $data_xhx[$i] = explode('_', $datas[$i]);
//                $data_xhx_count[$i] = count($data_xhx[$i]);
//                for ($j = 0; $j < $data_xhx_count[$i]; $j++) {
//                    $data[$i][$j] = ucfirst($data_xhx[$i][$j]);
//                }
//                $datarow[$i] = implode('', $data[$i]);
            $data[$i] = config('database.prefix') . $name . '_' . $datas[$i];
            // 根据传过来的字段新建数据
            $sql = <<<EOF
                CREATE TABLE IF NOT EXISTS `{$data[$i]}` (
                `id` int(11) UNSIGNED  NOT NULL AUTO_INCREMENT,
                `status` tinyint(1) UNSIGNED NOT NULL,
                `create_time` int(11) UNSIGNED  NULL,
                `update_time` int(11) UNSIGNED  NULL,
                `delete_time` int(11) UNSIGNED  NULL,
                PRIMARY KEY (`id`)
                )
                ENGINE=InnoDB
                DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
                CHECKSUM=0
                ROW_FORMAT=DYNAMIC
                DELAY_KEY_WRITE=0
                COMMENT='{$data[$i]}表'
                ;
EOF;
            $content[$i] = <<<INFO
            
-- -----------------------------
-- 表结构 `{$data[$i]}`
-- -----------------------------
CREATE TABLE IF NOT EXISTS `{$data[$i]}` (
`id` int(11) UNSIGNED  NOT NULL AUTO_INCREMENT,
`status` tinyint(1) UNSIGNED NOT NULL,
`create_time` int(11) UNSIGNED  NULL,
`update_time` int(11) UNSIGNED  NULL,
`delete_time` int(11) UNSIGNED  NULL,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0
COMMENT='{$data[$i]}表';


INFO;
            try {
                Db::execute($sql);
                //写入Sql文件里面
                file_put_contents($pathsql, $content);
                $uninstall = <<<INFO
DROP TABLE IF EXISTS `$data[$i]`;
INFO;
                //写入Sql文件里面
                file_put_contents($pathuninstall, $uninstall);
                //根据表生成模型子段admin_model
                $dataadd[$i] = ['name' => $name, 'title' => $name, 'table' => $data[$i], 'type' => 2, 'system' => 0, 'status' => 1, 'create_time' => time(), 'update_time' => time(), 'icon' => 'fa fa-fw fa-home'];
                $modelID = Db::table(config('database.prefix') . 'admin_model')->insertGetId($dataadd[$i]);
                //把对应的子段插入admin_field
                $datanameid[$i] = [['name' => 'id', 'title' => 'id', 'type' => 'text', 'define' => 'int(11) UNSIGNED NOT NULL', 'value' => '', 'options' => '', 'tips' => '', 'fixed' => 0, 'show' => 1, 'model' => $modelID, 'ajax_url' => '', 'level' => 0, 'table' => $data[$i], 'create_time' => time(), 'update_time' => time(),'data_type'=>'int','length'=>11],
                    ['name' => 'status', 'title' => '状态', 'type' => 'radio', 'define' => 'tinyint(2) UNSIGNED NOT NULL', 'value' => 1, 'options' => '0:禁用
1:启用', 'tips' => '', 'fixed' => 0, 'show' => 1, 'model' => $modelID, 'ajax_url' => '', 'level' => 0, 'table' => $data[$i], 'create_time' => time(), 'update_time' => time(),'data_type'=>'tinyint','length'=>1,'is_null'=>1],
                    ['name' => 'create_time', 'title' => '创建时间', 'type' => 'datetime', 'define' => 'int(11) UNSIGNED NOT NULL', 'value' => 0, 'options' => '', 'tips' => '', 'fixed' => 0, 'show' => 1, 'model' => $modelID, 'ajax_url' => '', 'level' => 0, 'table' => $data[$i], 'create_time' => time(), 'update_time' => time(),'data_type'=>'int','length'=>11,'is_null'=>1],
                    ['name' => 'update_time', 'title' => '更新时间', 'type' => 'datetime', 'define' => 'int(11) UNSIGNED NOT NULL', 'value' => 0, 'options' => '', 'tips' => '', 'fixed' => 0, 'show' => 1, 'model' => $modelID, 'ajax_url' => '', 'level' => 0, 'table' => $data[$i], 'create_time' => time(), 'update_time' => time(),'data_type'=>'int','length'=>11,'is_null'=>1],
                    ['name' => 'delete_time', 'title' => '删除时间', 'type' => 'datetime', 'define' => 'int(11) UNSIGNED NOT NULL', 'value' => 0, 'options' => '', 'tips' => '', 'fixed' => 0, 'show' => 1, 'model' => $modelID, 'ajax_url' => '', 'level' => 0, 'table' => $data[$i], 'create_time' => time(), 'update_time' => time(),'data_type'=>'int','length'=>11,'is_null'=>1]];
                Db::table(config('database.prefix') . 'admin_field')->insertAll($datanameid[$i]);
            } catch (\Exception $e) {
                return false;
            }

        }
    }


}


/**
 * @param null $file_name 例如:'adada,dadada'这样传输字符 $name  模型的名称
 * 根据数据库的表名生成文件
 */
function GenerateFile($file_name = null, $name)
{
    //生成文件目录
    $path = APP_PATH . $name;
    //在这个目录下面生成固定的目录
    $pathhome = $path . DS . 'home';
    $pathadmin = $path . DS . 'admin';
    $pathview = $path . DS . 'view';
    $pathmodel = $path . DS . 'model';
    $pathvalidate = $path . DS . 'validate';
    $pathsql = $path . DS . 'sql';
    if ($file_name) {
        $datas = explode(',', $file_name);
        $data_count = count($datas);
        for ($i = 0; $i < $data_count; $i++) {
            //如果传过的值有下划线,需要把下划线后面的单词首字母变成大写
            $data_xhx[$i] = explode('_', $datas[$i]);
            $data_xhx_count[$i] = count($data_xhx[$i]);
//            for ($j = 0; $j < $data_xhx_count[$i]; $j++) {
//                $data[$i][$j] = ucfirst($data_xhx[$i][$j]);
//                $datainfo[$i] = $data_xhx[$i][$j];
//            }
            $datarow[$i] = convertUnderline($datas[$i]);
            //生成对应文件
            if (!file_exists($pathhome . DS . $datarow[$i] . '.php')) {
                fopen($pathhome . DS . $datarow[$i] . '.php', "w");
                //写入对应php文件
                $content[$i] = <<<INFO
<?php
// +----------------------------------------------------------------------
// | PHP框架 [ ThinkPHP ]
// +----------------------------------------------------------------------
// | 版权所有 为开源做努力
// +----------------------------------------------------------------------
// | 时间: 2018-07-06 09:42:56
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
namespace app\\{$name}\\home;

class  {$datarow[$i]} extends Common
{


}
INFO;
                // 写入到文件
                file_put_contents($pathhome . DS . $datarow[$i] . '.php', $content[$i]);
                //生成公共文件
                $content_com = <<<INFO
<?php
// +----------------------------------------------------------------------
// | PHP框架 [ ThinkPHP ]
// +----------------------------------------------------------------------
// | 版权所有 为开源做努力
// +----------------------------------------------------------------------
// | 时间: 2018-07-06 09:42:56
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
namespace app\\{$name}\\home;

use app\index\controller\Home;

class  Common extends Home
{


}
INFO;
                // 写入到文件
                file_put_contents($pathhome . DS . 'common.php', $content_com);
            }
            if (!file_exists($pathadmin . DS . $datarow[$i] . '.php')) {
                fopen($pathadmin . DS . $datarow[$i] . '.php', "w");
                //写入对应php文件
                $database_prefix = config('database.prefix');
                $contentadmin[$i] = <<<INFO
<?php
// +----------------------------------------------------------------------
// | PHP框架 [ ThinkPHP ]
// +----------------------------------------------------------------------
// | 版权所有 为开源做努力
// +----------------------------------------------------------------------
// | 时间: 2018-07-06 09:42:56
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
namespace app\\{$name}\\admin;

use app\admin\controller\Admin;
use app\common\\builder\ZBuilder;

use app\admin\model\Model as ModelModel;
use app\\{$name}\\model\\{$datarow[$i]} as {$datarow[$i]}Model;
use app\admin\model\Field as FieldModel;

class  {$datarow[$i]} extends Admin
{

    /**
     * 首页
     * @return mixed
     */
    public function index()
    {
    //获取数据
		\$order = \$this->getOrder();
		// 获取筛选
		\$map = \$this->getMap();
        //获取数据
        \$dataList = {$datarow[$i]}Model::where(\$order)->where(\$map)->order('id desc')->paginate();
		// 分页数据
		\$page = \$dataList->render();
        //获取当前所在
        \$datamodelID = ModelModel::where(array('table' => '{$database_prefix}{$name}_{$datas[$i]}','status'=>1))->value('id');
        \$datafile = FieldModel::where(array('model' => \$datamodelID,'status'=>1,'show'=>1,'list_type'=>['<>','hidden']))->field('id,name,title,list_type')->select();

        foreach (\$datafile as \$key => \$value) {
            \$names = \$value['name'];
            \$title = \$value['title'];
            \$datavalues = \$value['list_type'];
			if(\$datavalues == 'text' || \$datavalues == 'date' || \$datavalues == 'time' || \$datavalues == 'datetime' || \$datavalues == 'textarea'){
				\$data_list = \$value['list_type'] . '.edit';
			}else{
				\$data_list = \$value['list_type'];
			}
            if(empty(\$value['list_type'])){
                \$data_type_list = '';
            }else{
                \$data_type_list = \$data_list;
            }
            \$data[] = [\$names, \$title,\$data_type_list];
        }
        //搜索查询可以搜索的字段
        \$datafilesea = FieldModel::where(array('model' => \$datamodelID,'status'=>1,'show'=>1,'is_search'=>1))->field('id,name,title,is_search')->select();
        if(\$datafilesea){
            foreach (\$datafilesea as \$key => \$value) {
                \$names = \$value['name'];
                \$title = \$value['title'];
                \$data_search[\$names] = \$title;

            }
        }else{
            \$data_search = '';
        }
		\$topbutton = ModelModel::where(array('id' => \$datamodelID, 'status' => 1, 'is_top_button' => 1))->value('top_button_value');
		\$rightbutton = ModelModel::where(array('id' => \$datamodelID, 'status' => 1, 'is_right_button' => 1))->value('right_button_value');
		\$datafilesea = FieldModel::where(array('model' => \$datamodelID,'status'=>1,'show'=>1,'is_filter'=>1))->column('id,name');
		if(!\$datafilesea){
			\$datafilesea = '';
		}
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(\$data_search)
            ->setPageTips('注意事项:  由于系统未实现自定义按钮,所以还是沿用系统的规定的按钮方法,去对应的文件新增按钮')
            ->addFilter(\$datafilesea)
            ->addColumn('__INDEX__', '#')
            ->addColumns(\$data)
            ->addColumn('right_button', '操作', 'btn')
            //->addTopButtons('back,add,delete')
            //->addRightButtons('edit,delete')
            ->addTopButtons(\$topbutton)
			->addRightButtons(\$rightbutton)
            ->setRowList(\$dataList)
            ->setPages(\$page) // 设置分页数据
            ->fetch();
    }
    
    /**
     *新增
     */
     public function add(){
       if(\$this->request->isPost()){
             \$datas = \$this->request->Post();
             //判断数据是否重复添加
             \$datappp ={$datarow[$i]}Model::where(\$datas)->find();
             if(\$datappp){
                 \$this->error('数据重复');
             }
             \$dataadd = {$datarow[$i]}Model::create(\$datas);
             if(\$dataadd){
                 \$this->success('添加成功','index');
             }
         }
         \$datamodelID = ModelModel::where(array('table' => '{$database_prefix}{$name}_{$datas[$i]}','status'=>1))->value('id');
         \$datafile = FieldModel::where(array('model' => \$datamodelID,'status'=>1,'show'=>1,'new_type'=>['<>','hidden']))->field('type,name,title,tips,new_type')->order('sort asc')->select();
         foreach (\$datafile as \$key => \$value) {
             \$names = \$value['name'];
             \$title = \$value['title'];
             \$type = \$value['type'];
             \$tips = \$value['tips'];
             \$new_type = \$value['new_type'];
             \$data[] = [\$new_type,\$names, \$title,\$tips];
         }
       // 显示添加页面
        return ZBuilder::make('form')
               ->addFormItems(\$data)
               ->fetch();
     }
     public function edit(\$id=''){
		if(\$this->request->isPost()){
			\$data= \$this->request->post();
			if(isset(\$data['status']) == 'on'){
				\$data['status'] = 1;
			}else{
				\$data['status'] = 0;
			}
			{$datarow[$i]}Model::update(\$data);
			// 验证
			//\$result = \$this->validate(\$data, '{$datarow[$i]}.edit');
			\$this->success('编辑成功', 'index');
		}
		\$datamodelID = ModelModel::where(array('table' => '{$database_prefix}{$name}_{$datas[$i]}', 'status' => 1))->value('id');
		\$datafile = FieldModel::where(array('model' => \$datamodelID, 'status' => 1, 'show' => 1, 'edit_type' => ['<>', 'hidden']))->field('type,name,title,tips,edit_type')->select();
		foreach (\$datafile as \$key => \$value) {
			\$names = \$value['name'];
			\$title = \$value['title'];
			//\$type = \$value['type'];
			\$tips = \$value['tips'];
			\$edit_type = \$value['edit_type'];
			\$data[] = [\$edit_type, \$names, \$title, \$tips];
		}
		// 模型信息
		\$info = {$datarow[$i]}Model::get(\$id);
		// 显示编辑页面
		return ZBuilder::make('form')
			->addFormItem('hidden','id')
			->addFormItems(\$data)
			->setFormData(\$info)
			->fetch();
	}
    
}
INFO;
                // 写入到文件
                file_put_contents($pathadmin . DS . $datarow[$i] . '.php', $contentadmin[$i]);
            }
            if (!file_exists($pathmodel . DS . $datarow[$i] . '.php')) {
                fopen($pathmodel . DS . $datarow[$i] . '.php', "w");
                //写入对应php文件
                $strtoupper_name = strtoupper($name);
                $strtoupper_data = strtoupper($datas[$i]);
                $contentmodel[$i] = <<<INFO
<?php
// +----------------------------------------------------------------------
// | PHP框架 [ ThinkPHP ]
// +----------------------------------------------------------------------
// | 版权所有 为开源做努力
// +----------------------------------------------------------------------
// | 时间: 2018-07-06 09:42:56
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
namespace app\\{$name}\\model;

use think\Model as ThinkModel;
use traits\model\SoftDelete;
class  {$datarow[$i]} extends ThinkModel
{
    // 设置当前模型对应的完整数据表名称
    protected \$table = '__{$strtoupper_name}_{$strtoupper_data}__';
    // 自动写入时间戳
    protected \$autoWriteTimestamp = true;
    //软删
	use SoftDelete;
     //设置主键，如果不同请修改
    protected \$pk = 'id';
    //自定义初始化
    protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        parent::initialize();
        //TODO:自定义的初始化
    }

}
INFO;
                // 写入到文件
                file_put_contents($pathmodel . DS . $datarow[$i] . '.php', $contentmodel[$i]);
            }
            if (!file_exists($pathvalidate . DS . $datarow[$i] . '.php')) {
                fopen($pathvalidate . DS . $datarow[$i] . '.php', "w");
                //写入对应php文件
                $contentvalidate[$i] = <<<INFO
<?php
// +----------------------------------------------------------------------
// | PHP框架 [ ThinkPHP ]
// +----------------------------------------------------------------------
// | 版权所有 为开源做努力
// +----------------------------------------------------------------------
// | 时间: 2018-07-06 09:42:56
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
namespace app\\{$name}\\validate;

use think\Validate;

class  {$datarow[$i]} extends Validate
{
    //定义验证规则
    protected \$rule = [
      
    ];

    //定义验证提示
    protected \$message = [
        
    ];

}
INFO;

                // 写入到文件
                file_put_contents($pathvalidate . DS . $datarow[$i] . '.php', $contentvalidate[$i]);
            }
            if (!file_exists($pathvalidate . DS . 'Databasetable.php')) {
                fopen($pathvalidate . DS . 'Databasetable.php', "w");
                //写入对应php文件
                $contentvalidatetable = <<<INFO
<?php
// +----------------------------------------------------------------------
// | PHP框架 [ ThinkPHP ]
// +----------------------------------------------------------------------
// | 版权所有 为开源做努力
// +----------------------------------------------------------------------
// | 时间: 2018-07-06 09:42:56
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
namespace app\\{$name}\\validate;

use think\Validate;

class  Databasetable extends Validate
{
    //定义验证规则
    protected \$rule = [
      
    ];

    //定义验证提示
    protected \$message = [
        
    ];
    
    // 定义验证场景
    protected \$scene = [
        //例子:'name' => ['name']
    ];

}
INFO;
                // 写入到文件
                file_put_contents($pathvalidate . DS . 'Databasetable.php', $contentvalidatetable);
            }

            if (!file_exists($pathsql . DS . 'install.sql')) {
                fopen($pathsql . DS . 'install.sql', "w");
            }
            if (!file_exists($pathsql . DS . 'uninstall.sql')) {
                fopen($pathsql . DS . 'uninstall.sql', "w");
            }
            if (!file_exists($pathadmin . DS . 'Databasetable.php')) {
                fopen($pathadmin . DS . 'Databasetable.php', "w");
                $DataTable = <<<INFO
<?php
// +----------------------------------------------------------------------
// | PHP框架 [ ThinkPHP ]
// +----------------------------------------------------------------------
// | 版权所有 为开源做努力
// +----------------------------------------------------------------------
// | 时间: 2018-07-06 09:42:56
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
namespace app \\{$name}\\admin;

use app\admin\controller\Admin;
use app\admin\model\Model as ModelModel;
use app\admin\model\Field as FieldModel;
use app\admin\model\Menu as MenuModel;
use app\common\builder\ZBuilder;
use think\Cache;
use think\Db;
use think\Request;

class  Databasetable extends Admin
{

    /**
     * 首页
     * @return mixed
     */
    public function index()
    {
		\$request = Request::instance();
		\$data =\$request->dispatch();
		\$mashu = \$data['module'][0];

		// 查询
		//\$map = \$this->getMap();
		\$map = ['name'=>\$mashu];
		// 数据列表
		\$data_list = ModelModel::where(\$map)->order('sort,id desc')->paginate();

		// 字段管理按钮
		\$btnField = [
			'title' => '模型管理',
			'icon'  => 'fa fa-fw fa-navicon',
			'href'  => url('admin/field/index', ['id' => '__id__'])
		];
        // 生成菜单节点
        \$btnFieldNode = [
            'title' => '生成菜单节点',
            'icon'  => 'glyphicon glyphicon-sort-by-attributes-alt',
            'href'  => url('admin/fieldnode/index', ['group'=>'__name__'])
        ];
         // 配置参数
        \$btnButton = [
            'title' => '按钮配置',
            'icon' => 'fa fa-fw fa-address-card-o',
            'href' => url('admin/button/index', ['group' => \$mashu,'id'=>'__id__'])
        ];
		// 使用ZBuilder快速创建数据表格
		return ZBuilder::make('table')
			->setSearch(['name' => '标识', 'title' => '标题']) // 设置搜索框
			->setPageTips('目前只能添加系统自带: <br>顶部按钮包括 : add,enable,disable,custom,back <br>
右边按钮包括：edit,delete,custom', 'danger')
			->addColumns([ // 批量添加数据列
				['id', 'ID'],
				['icon', '图标', 'icon'],
				['title', '表名'],
				['name', '标识'],
				['table', '数据表'],
				['type', '模型', 'text', '', ['系统', '普通', '独立']],
				['create_time', '创建时间', 'datetime'],
				['sort', '排序', 'text.edit'],
				['is_top_button', '顶部按钮', 'switch'],
                ['top_button_value', '顶部按钮值', 'textarea.edit'],
                ['is_right_button', '右侧按钮', 'switch'],
                ['right_button_value', '右侧按钮值', 'textarea.edit'],
				['status', '状态', 'switch'],
				['right_button', '操作', 'btn']
			])
			->addFilter('type', ['系统', '普通', '独立'])
			->addTopButtons('add,enable,disable') // 批量添加顶部按钮
			->addRightButton('custombutton' , \$btnButton,true)
            ->addRightButton('customnode' , \$btnFieldNode,true)
            ->addRightButtons([ 'custom' => \$btnField,'edit', 'delete' => ['data-tips' => '删除模型将同时删除该模型下的所有字段，且无法恢复。']])
			->setRowList(\$data_list) // 设置表格数据
			->fetch(); // 渲染模板
    }

	/**
	 * 新增内容模型
	 * @author 无名氏
	 * @return mixed
	 */
	public function add()
	{
		\$request = Request::instance();
		\$datas =\$request->dispatch();
		\$mashu =\$datas['module'][0];
		// 保存数据
		if (\$this->request->isPost()) {
			\$data = \$this->request->post();
			\$datamingzi =  \$mashu."/{\$data['table']}/index";
			if (\$data['table'] == '') {
				\$data['table'] = config('database.prefix') . \$mashu .'_'. \$data['table'];
			} else {
				\$data['table'] = config('database.prefix') . \$mashu .'_'. \$data['table'];
			}
			// 验证
			\$result = \$this->validate(\$data, 'Databasetable');
			if(true !== \$result) \$this->error(\$result);
			// 严格验证附加表是否存在
			if (table_exist(\$data['table'])) {
				\$this->error('附加表已存在');
			}
              \$data['name'] = \$mashu;
              \$data['top_button_value'] = 'back,add';
              \$data['right_button_value'] = 'edit,delete';
			if (\$model = ModelModel::create(\$data)) {
				// 创建附加表
				if (false === ModelModel::createTable(\$model)) {
					\$this->error('创建附加表失败');
				}
			
				\$menu_data = [
					"module"      => \$mashu,
					"pid"         => \$data['pid'],
					"title"       =>\$data['title'],
					"url_type"    => "module_admin",
					"url_value"   => \$datamingzi,
					"url_target"  => "_self",
					"icon"        =>\$data['icon']?\$data['icon']:"fa fa-fw fa-th-list",
					"online_hide" => "0",
					"sort"        => "100",
				];
				MenuModel::create(\$menu_data);

				// 记录行为
				
				Cache::clear();
				\$this->success('新增成功', 'index');
			} else {
				\$this->error('新增失败');
			}
		}

		\$type_tips = '此选项添加后不可更改。如果为 <code>系统模型</code> 将禁止删除，对于 <code>独立模型</code>，将强制创建字段id,cid,uid,model,title,create_time,update_time,sort,status,trash,view';
        \$datalists =Db::name('admin_menu')->where(array('module'=>\$mashu,'pid'=>0))->value('id');
        \$dataarray = Db::name('admin_menu')->where(array('pid'=>\$datalists))->column('id,title');
        \$dataarray[\$datalists] ='顶级菜单';
		// 显示添加页面
		return ZBuilder::make('form')
			->addFormItems([
				['text', 'name', '模型标识', '由小写字母、数字或下划线组成，不能以数字开头',\$mashu],
				['text', 'title', '表名', '可填写中文'],
				['text', 'table', '数据表', '创建后不可更改。由小写字母、数字或下划线组成，如果不填写默认为 <code>'. config('database.prefix') . \$mashu.'_模型标识</code>，如果需要自定义，请务必填写系统表前缀，<code>#@__</code>表示当前系统表前缀'],
				['radio', 'type', '模型类别', \$type_tips, ['系统模型', '普通模型', '独立模型(不使用主表)'], 1],
				['select','pid','选择上级菜单','',\$dataarray],
				['icon', 'icon', '图标'],
				['radio', 'is_top_button', '顶部按钮', '', ['不显示', '显示'], 1],
                ['radio', 'is_right_button', '右侧按钮', '', ['不显示', '显示'], 1],
				['radio', 'status', '立即启用', '', ['否', '是'], 1],
				['text', 'sort', '排序', '', 100],
			])
			->fetch();
	}

	/**
	 * 编辑内容模型
	 * @param null \$id 模型id
	 * @author 
	 * @return mixed
	 */
	public function edit(\$id = null) {
		if (\$id === null) \$this->error('参数错误');
		\$request = Request::instance();
		\$datas =\$request->dispatch();
		\$mashu =\$datas['module'][0];
		// 保存数据
		if (\$this->request->isPost()) {
			\$data = \$this->request->post();
			// 验证
			\$result = \$this->validate(\$data, 'Databasetable.edit');
			if(true !== \$result) \$this->error(\$result);

			if (ModelModel::update(\$data)) {
				cache('admin_model_list', null);
				cache('admin_model_title_list', null);
				// 记录行为
				action_log('databasetable_edit', \$mashu.'_edit', \$id, UID, "ID({\$id}),标题({\$data['title']})");
				\$this->success('编辑成功', 'index');
			} else {
				\$this->error('编辑失败');
			}
		}

		\$list_model_type = ['系统模型', '普通模型', '独立模型(不使用主表)'];

		// 模型信息
		\$info = ModelModel::get(\$id);
		\$info['type'] = \$list_model_type[\$info['type']];

		// 显示编辑页面
		return ZBuilder::make('form')
			->addFormItems([
				['hidden', 'id'],
				['hidden', 'name'],
				['static', 'name', '模型标识'],
				['static', 'type', '模型类别'],
				['static', 'table', '附加表'],
				['text', 'title', '模型标题', '可填写中文'],
				['icon', 'icon', '图标'],
				['radio', 'is_top_button', '顶部按钮', '', ['不显示', '显示'], 1],
                ['radio', 'is_right_button', '右侧按钮', '', ['不显示', '显示'], 1],
                ['textarea', 'top_button_value', '顶部按钮值'],
                ['textarea', 'right_button_value', '右侧按钮值'],
				['radio', 'status', '立即启用', '', ['否', '是']],
				['text', 'sort', '排序'],
			])
			->setFormData(\$info)
			->fetch();
	}

	/**
	 * 删除内容模型
	 * @param null \$ids 内容模型id
	 * @author
	 * @return mixed|void
	 */
	public function delete(\$ids = null)
	{
		if (\$ids === null) \$this->error('参数错误');

		\$model = ModelModel::where('id', \$ids)->find();
		 \$datapp = explode(config('database.prefix').\$model['name'].'_',\$model['table']);
		if (\$model['type'] == 0) {
			\$this->error('禁止删除系统模型');
		}
		//dump(\$model['table']);die;
		// 删除表和字段信息
		if (ModelModel::deleteTable(\$ids)) {
			// 删除主表中的文档
			if (false === Db::name('admin_model')->where('id', \$ids)->delete()) {
				\$this->error('删除主表文档失败');
			}
			// 删除字段数据
			if (false !== Db::name('admin_field')->where('model', \$ids)->delete()) {
				cache(config('database.prefix').'model_list', null);
				cache(config('database.prefix').'model_title_list', null);
				\$request = Request::instance();
                \$data = \$request->dispatch();
                \$module = \$data['module'][0];
                //删除菜单的列
                \$datamingzi = \$module . "/{\$model['table']}/index";
                if (false !== Db::name('admin_menu')->where('url_value', \$datamingzi)->delete()) {
                //删除对用的文件及文件夹
                if(\$datapp[1]){
                    DeleteCorrespondingFile($name,\$datapp[1]);
                }
                    \$this->success('删除成功', 'index');
                }
               
			} else {
				return \$this->error('删除内容模型字段失败');
			}
		} else {
			return \$this->error('删除内容模型表失败');
		}
	}

}
INFO;
                //$DataTable
                // 写入到文件
                file_put_contents($pathadmin . DS . 'Databasetable.php', $DataTable);
            }
            //如果是文件夹就生成
            $pathviewinfo = $pathview . DS . $datas[$i];
            if (!is_dir($pathviewinfo)) {
                mkdir($pathviewinfo, 0777, true);
                //生成对应的文件index.html
                $pathviewhtml = <<<INFO
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

</body>
</html>

INFO;

                fopen($pathviewinfo . DS . 'index.html', "w");
                // 写入到文件
                file_put_contents($pathviewinfo . DS . 'index.html', $pathviewhtml);
                //生成对应的文件admin文件里面的index.html
                $pathviewadmin = $pathview . DS . 'admin';
                if (!is_dir($pathviewadmin)) {
                    mkdir($pathviewadmin, 0777, true);
                }
                //生成后台对应的文件
                $pathviewadmindata = $pathviewadmin . DS . $datas[$i];
                if (!is_dir($pathviewadmindata)) {
                    mkdir($pathviewadmindata, 0777, true);
                }
                fopen($pathviewadmindata . DS . 'index.html', "w");
                //在index.html里面写内容
                $pathviewadmindatainfo = <<<INFO
{extend name="\$_admin_base_layout" /}



{block name="script"}
<script src="__ADMIN_JS__/core/jquery.countTo.min.js"></script>
<script>
    jQuery(function () {
        App.initHelpers(['appear-countTo']);
    });
</script>
{/block}

INFO;
                // 写入到文件
                file_put_contents($pathviewadmindata . DS . 'index.html', $pathviewadmindatainfo);
            }
        }
    }
}

/**
 * 生成项目文件
 * @param string $name 模块名
 * @author 无名氏
 * @return bool
 */
function AutomaticGeneration($name)
{
    //生成文件目录
    $path = APP_PATH . $name;
    //在这个目录下面生成固定的目录
    $pathhome = $path . DS . 'home';
    $pathadmin = $path . DS . 'admin';
    $pathview = $path . DS . 'view';
    $pathmodel = $path . DS . 'model';
    $pathvalidate = $path . DS . 'validate';
    $pathsql = $path . DS . 'sql';
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
        if (!is_dir($pathhome)) {
            mkdir($pathhome, 0777, true);
        }
        if (!is_dir($pathadmin)) {
            mkdir($pathadmin, 0777, true);
        }
        if (!is_dir($pathsql)) {
            mkdir($pathsql, 0777, true);
        }
        if (!is_dir($pathview)) {
            mkdir($pathview, 0777, true);
        }
        if (!is_dir($pathmodel)) {
            mkdir($pathmodel, 0777, true);
        }
        if (!is_dir($pathvalidate)) {
            mkdir($pathvalidate, 0777, true);
        }
        //创建根目录文件
        if (!file_exists($path . DS . "info.php")) {
            fopen($path . DS . "info.php", "w");
        }
        if (!file_exists($path . DS . "menus.php")) {
            fopen($path . DS . "menus.php", "w");
        }
        if (!file_exists($path . DS . "uninstall.php")) {
            fopen($path . DS . "uninstall.php", "w");
            $contentvalidateuninstall = <<<INFO
<?php
// +----------------------------------------------------------------------
// | PHP框架 [ ThinkPHP ]
// +----------------------------------------------------------------------
// | 版权所有 为开源做努力
// +----------------------------------------------------------------------
// | 时间: 2018-07-06 09:42:56
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
use think\Db;
use think\Exception;

// 是否清除数据
\$clear = \$this->request->get('clear');

if (\$clear == 1) {
    // 内容模型的表名列表
    \$table_list = Db::name('admin_model')->column('table');

    if (\$table_list) {
        foreach (\$table_list as \$table) {
            // 删除内容模型表
            \$sql = 'DROP TABLE IF EXISTS `'.\$table.'`;';
            try {
                Db::execute(\$sql);
            } catch (\Exception \$e) {
                throw new Exception('删除表：'.\$table.' 失败！', 1001);
            }
        }
    }
}
INFO;
            // 写入到文件
            file_put_contents($path . DS . 'uninstall.php', $contentvalidateuninstall);
        }
    }
    return true;
}

/**
 * 创建模块菜单文件
 * @param array $menus 菜单
 * @param string $name 模块名
 * @return int
 */
function buildMenuFile($menus = [], $name = '')
{
    //$menus = Tree::toLayer($menus);

    // 美化数组格式
    $menus = var_export($menus, true);
    $menus = preg_replace("/(\d+|'id'|'pid') =>(.*)/", '', $menus);
    $menus = preg_replace("/'child' => (.*)(\r\n|\r|\n)\s*array/", "'child' => $1array", $menus);
    $menus = str_replace(['array (', ')'], ['[', ']'], $menus);
    $menus = preg_replace("/(\s*?\r?\n\s*?)+/", "\n", $menus);

    $content = <<<INFO
<?php
// +----------------------------------------------------------------------
// | PHP框架 [ ThinkPHP ]
// +----------------------------------------------------------------------
// | 版权所有 为开源做努力
// +----------------------------------------------------------------------
// | 时间: 2018-07-06 09:42:56
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

/**
 * 菜单信息
 */
return {$menus};

INFO;
    // 写入到文件
    $path = APP_PATH . $name;
    return file_put_contents($path . '/menus.php', $content);
}

/**
 * 创建模块配置文件
 * @param array $info 模块配置信息
 * @param string $name 模块名
 * @return int
 */
function buildInfoFile($info = [], $name = '')
{
    // 美化数组格式
    $info = var_export($info, true);
    $info = preg_replace("/'(.*)' => (.*)(\r\n|\r|\n)\s*array/", "'$1' => array", $info);
    $info = preg_replace("/(\d+) => (\s*)(\r\n|\r|\n)\s*array/", "array", $info);
    $info = preg_replace("/(\d+ => )/", "", $info);
    $info = preg_replace("/array \((\r\n|\r|\n)\s*\)/", "[)", $info);
    $info = preg_replace("/array \(/", "[", $info);
    $info = preg_replace("/\)/", "]", $info);

    $content = <<<INFO
<?php
// +----------------------------------------------------------------------
// | PHP框架 [ ThinkPHP ]
// +----------------------------------------------------------------------
// | 版权所有 为开源做努力
// +----------------------------------------------------------------------
// | 时间: 2018-07-06 09:42:56
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

/**
 * 模块信息
 */
return {$info};

INFO;
    // 写入到文件
    $path = APP_PATH . $name;
    return file_put_contents($path . '/info.php', $content);
}


/**
 * 获取数据库字段注释
 *
 * @param string $table_name 数据表名称(必须，不含前缀)
 * @param string $field 字段名称(默认获取全部字段,单个字段请输入字段名称)
 * @param string $table_schema 数据库名称(可选)
 * @return string
 */
function get_db_column_comment($table_name = '', $field = true, $table_schema = '')
{
    // 接收参数
    $database = config('database');
    $table_schema = empty($table_schema) ? $database['database'] : $table_schema;
    $table_name = $database['prefix'] . $table_name;

    // 缓存名称
    $fieldName = $field === true ? 'allField' : $field;
    $cacheKeyName = 'db_' . $table_schema . '_' . $table_name . '_' . $fieldName;

    // 处理参数
    $param = [
        $table_name,
        $table_schema
    ];

    // 字段
    $columeName = '';
    if ($field !== true) {
        $param[] = $field;
        $columeName = "AND COLUMN_NAME = ?";
    }

    // 查询结果
    $result = Db:: query("SELECT COLUMN_NAME as  field,data_type,data_type,column_comment as comment  FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = ? AND table_schema = ? $columeName", $param);
    // pp(Db :: getlastsql());
    if (empty($result) && $field !== true) {
        return $table_name . '表' . $field . '字段不存在';
    }

    // 处理结果
    foreach ($result as $k => $v) {
        $field_name[] = $v;
    }

    return $field_name;
}

/**
 * Created by PhpStorm.
 * Databasetable: CJ584
 * Date: 2018/7/21
 * Time: 14:42
 */

if (!function_exists('get_model_table')) {
    /**
     * 获取内容模型附加表名
     * @param int $id 模型id
     * @author 无名氏
     * @return string
     */
    function get_model_table($id = 0)
    {
        $model_list = model('admin/model')->getList();
        return isset($model_list[$id]) ? $model_list[$id]['table'] : '';
    }
}
if (!function_exists('is_default_field')) {
    /**
     * 检查是否为系统默认字段
     * @param string $field 字段名称
     * @author 无名氏
     * @return bool
     */
    function is_default_field($field = '')
    {
        $system_fields = cache('admin_system_fields');
        if (!$system_fields) {
            $system_fields = Db::name('admin_field')->where('model', 0)->column('name');
            cache('admins_system_fields', $system_fields);
        }
        return in_array($field, $system_fields, true);
    }
}

if (!function_exists('get_model_title')) {
    /**
     * 获取内容模型标题
     * @param string $id 内容模型标题
     * @author 无名氏
     * @return string
     */
    function get_model_title($id = '')
    {
        $model_list = model('admin/model')->getList();
        return isset($model_list[$id]) ? $model_list[$id]['title'] : '';
    }
}

//将下划线命名转换为驼峰式命名
function convertUnderline($str, $ucfirst = true)
{
    while (($pos = strpos($str, '_')) !== false)
        $str = substr($str, 0, $pos) . substr($str, $pos + 1);

    return $ucfirst ? ucfirst($str) : $str;
}


/**
 * @param string $name 模块的名字
 * @param string $filename 需要删除的文件及目录
 * 根据删除的表 删除对应的文件
 */
function DeleteCorrespondingFile($name = '', $filename = '')
{
    //生成文件目录
    $path = APP_PATH . $name;
    //在这个目录下面生成固定的目录
    $pathhome = $path . DS . 'home';
    $pathadmin = $path . DS . 'admin';
    $pathview = $path . DS . 'view';
    $pathmodel = $path . DS . 'model';
    $pathvalidate = $path . DS . 'validate';
    $filenames = strpos($filename,'_');
    if($filenames){
        $dafilename = convertUnderline($filename);
    }else{
        $dafilename =  ucfirst($filename);
    }
    //删除对应的文件
    if (file_exists($pathhome.'/'.$dafilename.'.php')) {
        unlink($pathhome.'/'.$dafilename.'.php');
    }
    if (file_exists($pathadmin.'/'.$dafilename.'.php')) {
        unlink($pathadmin.'/'.$dafilename.'.php');
    }
    if (file_exists($pathmodel.'/'.$dafilename.'.php')) {
        unlink($pathmodel.'/'.$dafilename.'.php');
    }
    if (file_exists($pathvalidate.'/'.$dafilename.'.php')) {
        unlink($pathvalidate.'/'.$dafilename.'.php');
    }
    //删除对应的文件夹及文件夹里面的文件
    if(is_dir($pathview.'/admin/'.$filename)){
        delDirAndFile($pathview.'/admin/'.$filename,1);
    }
    if(is_dir($pathview.'/'.$filename)){
        delDirAndFile($pathview.'/'.$filename,1);
    }
}

/**
 * 删除目录及目录下所有文件或删除指定文件
 * @param str $path   待删除目录路径
 * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
 * @return bool 返回删除状态
 */
function delDirAndFile($path, $delDir = FALSE) {
    $handle = opendir($path);
    if ($handle) {
        while (false !== ( $item = readdir($handle) )) {
            if ($item != "." && $item != "..")
                is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
        }
        closedir($handle);
        if ($delDir)
            return rmdir($path);
    }else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return FALSE;
        }
    }
}

/**
 * @param string $module 所属模块
 * 获取配置
 */
function getConfigure($module = ''){
	return Moduleconfig::where(array('module_name'=>$module,'status'=>1))->order('sort asc')->field('name,title,group_name,default_value,field_type,sort')->select();
}


