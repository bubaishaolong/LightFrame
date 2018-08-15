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

use app\index\controller\Home;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Keychain;
use lmxdawn\jwt\JWT;
use think\Request;

class  Common extends Home
{
    private $token;    //客户端传递过来的 验证密码

    /**
     * @return string
     * iss (issuer)    issuer 请求实体，可以是发起请求的用户的信息，也可是jwt的签发者
     * sub (Subject)    设置主题，类似于发邮件时的主题
     * aud (audience)    接收jwt的一方
     * exp (expire)    token过期时间
     * nbf (not before)    当前时间在nbf设定时间之前，该token无法使用
     * iat (issued at)    token创建时间
     * jti (JWT ID)    对当前token设置唯一标示
     */
    public function _initialize()
    {
        $this->token = input('get.token');
        $mytoken = $this->get_token();
        if(!$this->token){
            echo '验证失败,token值不存在!';
        }
        if ($mytoken != $this->token) {
            return '验证失败，token值不匹配!' . $mytoken;
        }

        if ($this->token) {
            $parse = (new Parser())->parse($this->token);
            $signer = new Sha256();
            echo $parse->verify($signer, '签名key');// 验证成功返回true 失败false
        }
    }

    private function get_token()
    {
        $builder = new Builder();
        $signer = new Sha256();
        $key = '签名key';
        // 设置发行人
        $builder->setIssuer('http://example.com');
        // 设置接收人
        $builder->setAudience('http://example.org');
        // 设置id
        $builder->setId('4f1g23a12aa', true);
        // 设置生成token的时间
        $builder->setIssuedAt(time());
        // 设置在60秒内该token无法使用
        $builder->setNotBefore(time() + 60);
        // 设置过期时间
        $builder->setExpiration(time() + 60);
        // 给token设置一个id
        $builder->set('uid', 1);
        // 对上面的信息使用sha256算法签名
        $builder->sign($signer, $key);
        // 获取生成的token
        $get_token = $builder->getToken();
        return (string)$get_token;

        //echo (string)$get_token;
    }


}