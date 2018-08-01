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

namespace app\index\controller;

use think\Db;

/**
 * 前台首页控制器
 * @package app\index\controller
 */
class Index extends Home
{
    public function index()
    {
        return plugin_action('HelloWorld', 'Admin', 'add');
        $img = '15313067689b0dad1fd59e_0.jpeg';
        $img_id = 5;
        $where = array('img'=>['like','%'.$img.'%'],'img_id'=>$img_id);
        $data = Db::name('user_img')->where($where)->value('img');
        if($data){
            //判断字符串的里面的照片的个数
            $explode = explode(';',$data);
            //去掉数组中的空值
            $array_filter = array_filter($explode);
            //判断字符串里面照片的个数
            $count = count($array_filter);
            if($count <= 1 ){
               //直接删除照片
                $dataupdate = Db::name('user_img')->where($where)->delete();
            }elseif($count > 1){
                //排除要删除的照片
                $str_replace = str_replace($img.';','',$data);
                $dataupdate =  Db::name('user_img')->where($where)->update(array('img'=>$str_replace));
            }
            if($dataupdate){
                unset($img);
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('数据表没有数据');
        }

        return $this->fetch();
    }
}
