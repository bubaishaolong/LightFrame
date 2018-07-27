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

use app\admin\model\Model as ModelModel;
use app\shop\model\Userlist as UserlistModel;
use app\admin\model\Field as FieldModel;

class  Userlist extends Admin
{

    /**
     * 首页
     * @return mixed
     */
    public function index()
    {
        //获取数据
        $dataList = UserlistModel::all();
        //获取当前所在
        $datamodelID = ModelModel::where(array('table' => 'cj_shop_user_list','status'=>1))->value('id');
        $datafile = FieldModel::where(array('model' => $datamodelID,'status'=>1,'show'=>1))->field('id,name,title,is_search')->select();

        foreach ($datafile as $key => $value) {
            $names = $value['name'];
            $title = $value['title'];
            $data[] = [$names, $title];

        }
        //搜索查询可以搜索的字段
        $datafilesea = FieldModel::where(array('model' => $datamodelID,'status'=>1,'show'=>1,'is_search'=>1))->field('id,name,title,is_search')->select();
        if($datafilesea){
            foreach ($datafilesea as $key => $value) {
                $names = $value['name'];
                $title = $value['title'];
                $data_search[$names] = $title;

            }
        }else{
            $data_search = '';
        }
        //dump($data_search);die;
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch($data_search)
            ->addColumn('__INDEX__', '#')
            ->addColumns($data)
            ->addColumn('right_button', '操作', 'btn')
            ->addTopButtons('back,add,delete')
            ->addRightButtons('edit,delete')
            ->setRowList($dataList)
            ->fetch();
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