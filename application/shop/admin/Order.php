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
namespace app\shop\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
class  Order extends Admin
{

    /**
     * 首页
     * @return mixed
     */
    public function index()
    {

        return $this->fetch(); // 渲染模板
    }
    
    /**
     *新增
     */
     public function add(){
       // 显示添加页面
        return ZBuilder::make('form')
               ->addFormItems([['text','ID','标题','说明']])
               ->fetch();
     }
    

}