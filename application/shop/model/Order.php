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
namespace app\shop\model;

use think\Model as ThinkModel;
use traits\model\SoftDelete;
class  Order extends ThinkModel
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__SHOP_ORDER__';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    //软删
	//use SoftDelete;
     //设置主键，如果不同请修改
    protected $pk = 'id';
    //系统支持auto、insert和update三个属性，可以分别在写入、新增和更新的时候进行字段的自动完成机制，auto属性自动完成包含新增和更新操作
    protected $auto = [];
    protected $insert = ['status' => 1];//新增数据的时候，会对status 字段自动完成或者处理
    protected $update = [];
    //自定义初始化
    protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        parent::initialize();
        //TODO:自定义的初始化
    }
    //模型查询数据
//    protected function scopeAge($query)
//    {
//        $query->where('age','>',20)->limit(10);
//    }
    // 设置当前模型的数据库连接
    protected $connection = [
        // 数据库类型
        //'type'        => 'mysql',
        // 服务器地址
        //'hostname'    => '127.0.0.1',
        // 数据库名
        //'database'    => 'thinkphp',
        // 数据库用户名
        //'username'    => 'root',
        // 数据库密码
        //'password'    => '',
        // 数据库编码默认采用utf8
        //'charset'     => 'utf8',
        // 数据库表前缀
        //'prefix'      => 'think_',
        // 数据库调试模式
        //'debug'       => false,
    ];
    //设置状态的字体和颜色
    public function getStatusAttr($value)
    {
        $status = [-1=>'删除',0=>'<span style="color: darkgrey">禁用</span>',1=>'<span style="color: red">正常</span>',2=>'待审核'];
        return $status[$value];
    }
    //数据库中的时候会转为小写(只有在save的情况才生效)
    public function setNameAttr($value)
    {
        return strtolower($value);
    }
    protected function setIpAttr()
    {
        return request()->ip();
    }

    //数据层：app\index\model\User 用于定义数据相关的自动验证和自动完成和数据存取接口 实例化方法：\think\Loader::model('User')
    //逻辑层：app\index\logic\User 用于定义用户相关的业务逻辑 实例化方法：\think\Loader::model('User','logic');
    //服务层：app\index\service\User 用于定义用户相关的服务接口等 实例化方法：\think\Loader::model('User','service');
    /**
     * 模型类支持before_delete、after_delete、before_write、after_write、before_update、after_update、before_insert、after_insert事件行为
     */
    protected static function init()
    {
        Order::beforeInsert(function ($user) {
            if ($user->status != 1) {
                return false;
            }
        });
    }
    //一对一
    public function profile()
    {
        return $this->hasOne('Profile')->field('id,name,email');//Profile需要关联的模型
    }
    //一对多
    public function comments()
    {
        return $this->hasMany('Comment')->field('id,author,content');//Comment需要关联的模型
    }
    //多对多
    public function roles()
    {
        return $this->belongsToMany('Role','\app\index\model\Access');
    }

}