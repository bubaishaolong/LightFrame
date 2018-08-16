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
use lmxdawn\jwt\BeforeValidException;
use lmxdawn\jwt\ExpiredException;
use lmxdawn\jwt\JWT;
use lmxdawn\jwt\SignatureInvalidException;
use think\Exception;
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
     * 校验token值是否过期或者失败
     */
    public function _initialize()
    {
//        $this->get_token();
//        exit();
        $key = '签名key';
        $this->token = input('get.token');
        if (!isset($this->token) || empty($this->token)) {
            echo 'token值不存在,请检验链接';
            exit();
        }
        try {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($this->token, $key, ['HS256']); //HS256方式，这里要和签发的时候对应
            //验证成功
            if ((array)$decoded) {
                return true;
            };
        } catch (SignatureInvalidException $e) {  //签名不正确
            echo $e->getMessage();
            exit();
        } catch (BeforeValidException $e) {  // 签名在某个时间点之后才能用
            echo $e->getMessage();
            exit();
        } catch (ExpiredException $e) {  // token过期
            echo $e->getMessage();
            exit();
        } catch (Exception $e) {  //其他错误
            echo $e->getMessage();
            exit();
        }
    }

    /**
     * 生成token
     */
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
        $builder->setExpiration(time() + 7200);
        // 给token设置一个id
        $builder->set('uid', 1);
        // 对上面的信息使用sha256算法签名
        $builder->sign($signer, $key);
        // 获取生成的token
        $get_token = $builder->getToken();
        //return (string)$get_token;

        echo (string)$get_token;
    }

    /**
     * 生成token的另一种方法
     */
    public function usertoken()
    {
        $key = 'ffdsfsd@4_45'; //key
        $time = time(); //当前时间
        //公用信息
        $token = [
            'iss' => 'http://www.helloweba.net', //签发者 可选
            'iat' => $time, //签发时间
            'data' => [ //自定义信息，不要定义敏感信息
                'userid' => 1,
            ]
        ];
        $access_token = $token;
        $access_token['scopes'] = 'role_access'; //token标识，请求接口的token
        $access_token['exp'] = $time + 7200; //access_token过期时间,这里设置2个小时

        $refresh_token = $token;
        $refresh_token['scopes'] = 'role_refresh'; //token标识，刷新access_token
        $refresh_token['exp'] = $time + (86400 * 30); //access_token过期时间,这里设置30天

        $jsonList = [
            'access_token' => JWT::encode($access_token, $key),
            'refresh_token' => JWT::encode($refresh_token, $key),
            'token_type' => 'bearer' //token_type：表示令牌类型，该值大小写不敏感，这里用bearer
        ];
        Header("HTTP/1.1 201 Created");
        echo json_encode($jsonList); //返回给客户端token信息
    }

    public function Api($code = '', $data = '', $massage = '')
    {
        $json = [
            'code' => $code,
            'data' => $data,
            'massage' => $massage
        ];
        return json_encode($json,JSON_UNESCAPED_UNICODE);

    }
}