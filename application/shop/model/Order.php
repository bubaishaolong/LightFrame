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
    //自定义初始化
    protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        parent::initialize();
        //TODO:自定义的初始化
    }

    /**
     * 模型类支持before_delete、after_delete、before_write、after_write、before_update、after_update、before_insert、after_insert事件行为
     */

}