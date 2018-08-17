<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/27
 * Time: 9:44
 */

namespace app\lp_worker_im\gatewayworker\sdk;


use think\facade\Cache;

class RedisCache
{
    /**
     * @return mixed
     * 封装cache 缓存
     */
    public function CaCheType()
    {
        $data_string = Cache::store('redis');
        return $data_string;
    }

    /**
     * 缓存的通用方法
     * @param $name 缓存的key值
     * @param string $data
     */
    public function cache($name,$data=""){
    	if($data == null){
    	    $this->CaCheType()->rm($name);
    		//删除缓存
    	}else if($data == ""){
    	    $this->CaCheType()->get($name);
    		//获取缓存
    	}else{
    	    $this->CaCheType()->set($name,$data);
    		//设置缓存
    	}
        return true;
    }

    /**
     * @param $name
     * @return mixed
     * 自增
     */
    public function cacheinc($name){
        return $this->CaCheType()->inc($name);
    }
}
