<?php
namespace plugins\AliDayu\controller;
use app\common\controller\Common;
use think\Validate;
require_once(dirname(dirname(__FILE__))."/sdk/TopClient.php");
require_once(dirname(dirname(__FILE__))."/sdk/AlibabaAliqinFcSmsNumSendRequest.php");
require_once(dirname(dirname(__FILE__))."/sdk/RequestCheckUtil.php");
require_once(dirname(dirname(__FILE__))."/sdk/ResultSet.php");
require_once(dirname(dirname(__FILE__))."/sdk/TopLogger.php");
/**
 * Created by PhpStorm.
 * User: wem
 * Date: 2017/1/17
 * Time: 17:15
 */
class AliDayu extends Common
{
    public function send($data=[])
    {
        $plugin_config = plugin_config('alidayu');
        $data['template'] = $plugin_config['template'];
        $validate = new Validate([
            ['param','require|array','参数必填|参数必须为数组'],
            ['mobile','require|/1[34578]{1}\d{9}$/','手机号错误|手机号错误'],
            ['template','require','模板id错误'],
        ]);
        if (!$validate->check($data)) {
            return $validate->getError();
        }

        define('TOP_SDK_WORK_DIR', CACHE_PATH.'sms_tmp/');
        define('TOP_SDK_DEV_MODE', false);
        $c = new \TopClient();
        $c->appkey = $plugin_config['appkey'];
        $c->secretKey = $plugin_config['secretKey'];
        $req = new \AlibabaAliqinFcSmsNumSendRequest();
        $req->setExtend('');
        $req->setSmsType('normal');
        $req->setSmsFreeSignName($plugin_config['FreeSignName']);
        $req->setSmsParam(json_encode($data['param']));
        $req->setRecNum($data['mobile']);
        $req->setSmsTemplateCode($plugin_config['template']);
        $result = $c->execute($req);
        $result = $this->_simplexml_to_array($result);
        if(isset($result['code'])){
            return $result['sub_code'];
        }

        return true;
    }

    private function _simplexml_to_array($obj)
    {
        if(count($obj) >= 1){
            $result = $keys = [];
            foreach($obj as $key=>$value){
                isset($keys[$key]) ? ($keys[$key] += 1) : ($keys[$key] = 1);
                if( $keys[$key] == 1 ){
                    $result[$key] = $this->_simplexml_to_array($value);
                }elseif( $keys[$key] == 2 ){
                    $result[$key] = [$result[$key], $this->_simplexml_to_array($value)];
                }else if( $keys[$key] > 2 ){
                    $result[$key][] = $this->_simplexml_to_array($value);
                }
            }
            return $result;
        }else if(count($obj) == 0){
            return (string)$obj;
        }
    }
}