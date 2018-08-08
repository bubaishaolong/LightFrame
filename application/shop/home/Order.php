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

class  Order extends Common
{



    public function index()
    {
        header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求
        header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');
        ini_set('session.cookie_domain', '.a.com');
        header('Access-Control-Allow-Credentials: true');
        // 订阅信息,接收一个信息后退出
        $server = "mamios.com";     // 服务代理地址(mqtt服务端地址)
        $port = 1833;                     // 通信端口
//        $server = "127.0.0.1";     // 服务代理地址(mqtt服务端地址)
//        $port = 61613;
        $username = "";                   // 用户名(如果需要)
        $password = "";
//        $username = "admin";                   // 用户名(如果需要)
//        $password = "password";                   // 密码(如果需要
        $client_id = "mybroker"; // 设置你的连接客户端id
        $mqtt = new Mqtt($server, $port, $client_id);
        if (!$mqtt->connect(true, NULL, $username, $password)) { //链接不成功再重复执行监听连接
            exit(1);
        }
        $topics['MyUser'] = array("qos" => 0, "function" => "procmsg");
        // 订阅主题为 myhome qos为0
         $mqtt->subscribe($topics, 0);

//        while ($mqtt->proc()) {
//
//        }
        //死循环监听
        $mqtt->close();

    }

   function procmsg($topic, $msg){ //信息回调函数 打印信息
        echo "Msg Recieved: " . date("r") . "\n";
        echo "Topic: {$topic}\n\n";
        echo "\t$msg\n\n";
    }
}