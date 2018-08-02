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
use plugins\PHPMailer\PHPMailer;

class  Menber extends Common
{
    public function index()
    {
        // $res = plugin_action('Markdown','Markdown','output',['c:\\test.md']); //markdown插件应用测试
        $res = plugin_action('Markdown', 'Markdown', 'output'); //默认解释显示parsedown库的使用readme.md文件

        //return $res;
        //换新支付配置
        $payment_data = [
            'GoodsName'         => '充值',
            'MerBillNo'         => '订单号',
            'Amount'            => '金额',
            'Attach'            => '备注',
            'Merchanturl'       => '',
            'ServerUrl'         => '',
            'UserRealName'      => '',//自动注册
            'UserId'            => '',//自动注册
        ];
        plugin_action('Ipspay/Ipspay/payment', [$payment_data, 'h5']);
        //邮件测试
        $res = PHPMailer::send_email('测试宝宝','测试内容','to_user_emial','alias');
        //支付宝调用
        $data = [
            'out_trade_no'=>time(),
            'price'=>1,
            'subject'=>'测试',
            'show_url'=>'不能发连接',
            'notify_url'=>'不能发连接',
            'return_url'=>'不能发连接',
        ];
        plugin_action('Alipay/Alipay/alipay', $data);

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
        if ($this->request->isPost()) {
            // 接收附件 ID
            $excel_file = $this->request->post('excel');
            // 获取附件 ID 完整路径
            $full_path = getcwd() . get_file_path($excel_file);
            // 只导入的字段列表
            $fields = [
                'name' => '姓名',
                'last_login_time' => '最后登录时间',
                'last_login_ip' => '最后登陆IP'
            ];
            // 调用插件('插件',[路径,导入表名,字段限制,类型,条件,重复数据检测字段])
            $import = plugin_action('Excel/Excel/import', [$full_path, 'vip_test', $fields, $type = 0, $where = null, $main_field = 'name']);

            // 失败或无数据导入
            if ($import['error']){
                $this->error($import['message']);
            }

            // 导入成功
            $this->success($import['message']);
        }

        // 创建演示用表单
        return ZBuilder::make('form')
            ->setPageTitle('导入Excel')
            ->addFormItems([ // 添加上传 Excel
                ['file', 'excel', '上传文件'],
            ])
            ->fetch();
        dump($res);
        return $this->fetch(); // 渲染模板
    }
}