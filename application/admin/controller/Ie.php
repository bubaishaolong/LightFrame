<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017  [  ]
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\common\controller\Common;

/**
 * ie提示页面控制器
 * @package app\admin\home
 */
class Ie extends Common
{
    /**
     * 显示ie提示
     * @author 无名氏
     * @return mixed
     */
    public function index(){
        // ie浏览器判断
        if (get_browser_type() == 'ie') {
            return $this->fetch();
        } else {
            $this->redirect('admin/index/index');
        }
    }
}