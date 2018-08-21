<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 9:12
 */

namespace app\api\home\v2;

use app\api\home\Common;
use app\api\model\User as UserModel;

class Index extends Common
{
    /**
     * 请求的链接
     * public/index.php/api/v1/index/index
     * opssl_encrypt 对输出的数据进行加密
     * 这里需要验证token值是否正确
     */
    public function index(){
        $user = UserModel::get(1);
       return Api(200,opssl_encrypt($user),'获取成功');
    }
}