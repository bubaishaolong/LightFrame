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

//引用GatewayClient类聊天服务器  用作推送很方便
use GatewayClient\Gateway;
//调用kafka
use Kafka\Consumer;
use Kafka\ConsumerConfig;
use Kafka\Producer;
use Kafka\ProducerConfig;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use think\Db;
date_default_timezone_set('PRC');
class  Userlist extends Common
{

    public function index(){
        /**
         * client_id 是绑定聊天服务器返回的  文件夹gatewayworker是长链接服务器,里面需要配置服务器的IP和端口这些
         * 使用方要去获取到client_id 参考手册的函数操作
         * WorkerMan支持TCP和UDP两种传输层协议
         */
//        $user_token = 1;//绑定当前用户的标识
//        $ClientIds = Gateway::getClientIdByUid($user_token);//绑定的$user_token在线的client_id
//        foreach ($ClientIds as $ClientId) {
//            Gateway::sendToClient($ClientId,'我是发送的测试内容');
//            return false;
//        }
        /**
         * 在写接口的时候可以用下面的实例去封装自己需要传递的参数进行加密,解密
         */
        //$data = $this->request->post();
        $data = [
            'a'=>'disjid',
            'b'=>'颠三倒四',
            'c'=>'sdsd',
        ];

        //开启事务
        //MYSQL中只有INNODB和BDB类型的数据表才能支持事务处理！其他的类型是不支持的
        Db::startTrans();
        try{
            //业务逻辑处理

            // 提交事务
            Db::commit();
        } catch (\think\Exception $ex) {
            Db::rollback(); //回滚事务
        }

        $dd = opssl_encrypt(json_encode($data,JSON_UNESCAPED_UNICODE));//参数加密
        $cc = opssl_decrypt($dd);//参数解密
        return $this->Api(200,$dd,'成功');

    }
    public function kafka_consumer(){
        $logger = new Logger('my_logger');
        $logger->pushHandler(new StreamHandler('php://stdout', Logger::WARNING));

        $kafka = ConsumerConfig::getInstance();
        $kafka->setMetadataRefreshIntervalMs('1000');
        $kafka->setMetadataBrokerList('127.0.0.1:9092');
        $kafka->setBrokerVersion('1.1.0');
        $kafka->setGroupId('test');
        $kafka->setTopics(['test']);
        $consumer = new Consumer();
        $consumer->setLogger($logger);
        $consumer->start(function($topic, $part, $message) {
            var_dump($message);
        });
    }

    public function kafka_producer()
    {
        $logger = new Logger('my_logger');
        $logger->pushHandler(new StreamHandler('php://stdout', Logger::WARNING));
        $config = ProducerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList('127.0.0.1:9092');
        $config->setBrokerVersion('1.1.0');
        $config->setRequiredAck(1);
        $config->setIsAsyn(false);
        $config->setProduceInterval(500);
        $producer = new Producer();
        $producer->setLogger($logger);
        for ($i = 0; $i < 10; $i++) {
            $producer->send([
                [
                    'topic' => 'test',
                    'value' => 'test....message' . $i,
                    'key' => 'testkey',
                ],
            ]);
        }
    }

}