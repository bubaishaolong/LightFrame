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
namespace app\shop\home;

use app\admin\model\Hook;
use app\common\builder\ZBuilder;
use plugins\PHPMailer\PHPMailer;

use Overtrue\Pinyin\Pinyin;

class  Menber extends Common
{
    public function index()
    {

        //$getIp=$_SERVER["REMOTE_ADDR"];
        $getIp=get_client_ip();
        echo 'IP:',$getIp;
        echo '<br/>';
        $content = file_get_contents("http://api.map.baidu.com/location/ip?ak=7IZ6fgGEGohCrRKUE9Rj4TSQ&ip={$getIp}&coor=bd09ll");
        $json = json_decode($content);

        echo 'log:',$json->{'content'}->{'point'}->{'x'};//按层级关系提取经度数据
        echo '<br/>';
        echo 'lat:',$json->{'content'}->{'point'}->{'y'};//按层级关系提取纬度数据
        echo '<br/>';
        print $json->{'content'}->{'address'};//按层级关系提取address数据

        $Mqtt = 'Mqtt';
        include_once dirname(__FILE__).'/api/'.$Mqtt.'.php';
        $data = new $Mqtt();
        $data->index();

        header("Content-type: text/html; charset=GBK");
        // 发送给订阅号信息,创建socket,无sam队列
        $server = "mamios.com";     // 服务代理地址(mqtt服务端地址)
        $port = 1833;                     // 通信端口
//        $server = "127.0.0.1";     // 服务代理地址(mqtt服务端地址)
//        $port = 61613;
        $username = "";                   // 用户名(如果需要)
        $password = "";
//        $username = "admin";                   // 用户名(如果需要)
//        $password = "password";                   // 密码(如果需要
        $client_id = "mybroker"; // 设置你的连接客户端id
        $mqtt = new Mqtt($server, $port, $client_id); //实例化MQTT类
        if ($mqtt->connect(true, NULL, $username, $password)) {
            //如果创建链接成功
            $mqtt->publish("mqtt", "mysql", 0);
            //$command = 'mosquitto_sub -h mamios.com -t "mqtt" -v -p 1833';
//            $command = "mosquitto_pub -h mamios.com -t 'mqtt' -m 'Hello Stonegeek' -p 1833";
//            $a = exec($command,$out,$status);
//            print_r($a);
//            print_r($out);
//            print_r($status);
            //dump($mqtt->connect_auto());die;
            // 发送到 xxx3809293670ctr 的主题 一个信息 内容为 setr=3xxxxxxxxx Qos 为 0
            $mqtt->close();    //发送后关闭链接
        } else {
            echo "Time out!\n";
        }

//
//        //把汉字转换为拼音
//        $pinyin = new Pinyin();
//        $data_pinyin =  $pinyin->convert('带着希望去旅行，比到达终点更美好');
//        $data = 'shop/menber_list/index';
//        $key = generate_rand_str(32);
//        $datal =  think_encrypt($data,$key);
//        dump($datal);die;
//        return think_decrypt($datal,$key);


        // $res = plugin_action('Markdown','Markdown','output',['c:\\test.md']); //markdown插件应用测试
        //$res = plugin_action('Markdown', 'Markdown', 'output'); //默认解释显示parsedown库的使用readme.md文件

        //return $res;
        //环信支付配置
//        $payment_data = [
//            'GoodsName'         => '充值',
//            'MerBillNo'         => '订单号',
//            'Amount'            => '金额',
//            'Attach'            => '备注',
//            'Merchanturl'       => '',
//            'ServerUrl'         => '',
//            'UserRealName'      => '',//自动注册
//            'UserId'            => '',//自动注册
//        ];
//        plugin_action('Ipspay/Ipspay/payment', [$payment_data, 'h5']);
        //邮件测试
        //$res = PHPMailer::send_email('测试宝宝','测试内容','to_user_emial','alias');
        //支付宝调用
//        $data = [
//            'out_trade_no'=>time(),
//            'price'=>1,
//            'subject'=>'测试',
//            'show_url'=>'不能发连接',
//            'notify_url'=>'不能发连接',
//            'return_url'=>'不能发连接',
//        ];
        // plugin_action('Alipay/Alipay/alipay', $data);

        // 引入插件包类库
        //use plugins\WeChatSDK\controller\WeChat;

        // 发起微信授权
        // WeChat::instance()->Oauth_Redirect('yourCallbackUrl',true);

        // 在Callback内获取用户信息
        // WeChat::instance()->Oauth_UserInfo();
        // 以单例模式取得了WechatUser类的实例化对象
        //$UserObj = WeChat::instance()->load_wechat('User');

        // 批量获取关注公众号的粉丝列表
        //$UserList = $UserObj->getUserList();


        // 提交数据【Excel 插件】 导入 Excel 教程
//        if ($this->request->isPost()) {
//            // 接收附件 ID
//            $excel_file = $this->request->post('excel');
//            // 获取附件 ID 完整路径
//            $full_path = getcwd() . get_file_path($excel_file);
//            // 只导入的字段列表
//            $fields = [
//                'name' => '姓名',
//                'last_login_time' => '最后登录时间',
//                'last_login_ip' => '最后登陆IP'
//            ];
//            // 调用插件('插件',[路径,导入表名,字段限制,类型,条件,重复数据检测字段])
//            $import = plugin_action('Excel/Excel/import', [$full_path, 'vip_test', $fields, $type = 0, $where = null, $main_field = 'name']);
//
//            // 失败或无数据导入
//            if ($import['error']){
//                $this->error($import['message']);
//            }
//
//            // 导入成功
//            $this->success($import['message']);
//        }
//
//        // 创建演示用表单
//        return ZBuilder::make('form')
//            ->setPageTitle('导入Excel')
//            ->addFormItems([ // 添加上传 Excel
//                ['file', 'excel', '上传文件'],
//            ])
//            ->fetch();
//        dump($res);

        //plugin_url('链接', '参数', '模块名')
        //plugin_action('插件名', '控制器', '动作', '参数')
        //plugin_action_exists('插件名', '控制器', '动作')
        //plugin_config('插件名', '配置值')
        return $this->fetch(); // 渲染模板
    }


    public function procmsg($topic, $msg){ //信息回调函数 打印信息
        echo "Msg Recieved: " . date("r") . "\n";
        echo "Topic: {$topic}\n\n";
        echo "\t$msg\n\n";
        $xxx = json_decode($msg);
        var_dump($xxx->aa);
        die;
    }
}