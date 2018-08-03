<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/26
 * Time: 13:08
 */

namespace app\admin\controller;

use app\admin\model\Model as ModelModel;
use app\common\builder\ZBuilder;
use app\admin\model\Button as ButtonModel;
use think\Cache;

use think\Hook;

class Button extends Admin
{

    /**
     * 按钮配置
     */
    public function index($group = '', $tab = 'tab1', $id = '')
    {

        // 监听tab钩子
        Hook::listen('module_index_tab_list');
        $map = $this->getMap();
        $dataList = ButtonModel::where(array('module_id' => $id, 'button_type' => $tab))->whereOr($map)->order('sort,id desc')->paginate();
        $list_tab = [
            'tab1' => ['title' => '顶部按钮', 'url' => url('index', ['module' => $group, 'id' => $id, 'tab' => 'tab1'])],
            'tab2' => ['title' => '右侧按钮', 'url' => url('index', ['module' => $group, 'id' => $id, 'tab' => 'tab2'])],
        ];
        // 生成对应的类文件
        $btnFieldClass = [
            'title' => '添加',
            'icon' => 'glyphicon glyphicon-book',
            'href' => url('admin/button/add', ['module' => $group, 'id' => $id, 'tab' => $tab])
        ];
        $btnFieldedit = [
            'title' => '编辑',
            'icon' => 'glyphicon glyphicon-book',
            'href' => url('admin/button/edit', ['id' => '__id__', 'module' => $group, 'tab' => $tab, 'group' => $id])
        ];

        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['name' => '标识', 'title' => '标题'])// 设置搜索框
            ->setPageTitle($group . '按钮配置列表')
            ->setPageTips('顶部按钮包括 : add,delete,enable,disable,custom,excel_export,back <br> 右边按钮包括：edit,delete,enable,disable,custom<br> 注意:系统的按钮不要重复添加与之冲突', 'danger')
            ->setTabNav($list_tab, $tab)
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '按钮标题', 'text'],
                ['name', '按钮名称', 'text'],
                ['icon', '图标', 'icon'],
                ['url', 'url链接', 'text'],
                ['open_type', '打开显示类型', 'radio', '', ['0' => '默认(info)', '1' => '警告(danger)', '3' => '危险(danger)', '4' => '成功(除此之外还有success)'], 0],
                ['param', '携带参数', 'text'],
                ['sort', '排序', 'text'],
                ['status', '状态', 'switch'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('disable')
            ->addTopButton('add', $btnFieldClass, true)// 批量添加顶部按钮
            ->addRightButton('edit', $btnFieldedit, true)// 批量添加顶部按钮
            ->addRightButton('delete')
            ->setRowList($dataList)// 设置表格数据
            ->fetch(); // 渲染模板
    }

    public function add($tab = '', $id = '')
    {

        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['module_id'] = $id;
            $data['button_type'] = $tab;
            $param = $data['param'];
            if ($param) {
                $param_list = 'url(' . $data['url'] . ',' . $param . ')';
            } else {
                $param_list = 'url(' . $data['url'] . ')';
            }

//            $top_button_value = [
//                'title' => $data['title'],
//                'name' => $data['name'],
//                'icon' => $data['icon'],
//                'href' => $param_list,
//            ];
//            //查询model之前的数据
//            $top_button = ModelModel::where(array('id' => $id))->value('top_button_value');
//            //拼接成自己需要的数据
//            $datavalue = $top_button . ',' . serialize($top_button_value);
//
//            if ($tab == 'tab1') {
//                $update['top_button_value'] = $datavalue;
//            } elseif ($tab == 'tab2') {
//                $update['right_button_value'] = $datavalue;
//            }
//            if ($update) {
//                ModelModel::update($update, ['id' => $id]);
//            }
            $datacreate = ButtonModel::create($data);
            if ($datacreate) {
                $this->success('添加成功','index');
            }
        }
        return ZBuilder::make('form')
            ->addFormItems([
                ['text', 'title', '按钮标题', '只能是中文的汉字(添加)'],
                ['text', 'name', '按钮名称', '请填写字母的名称,例如: add delete'],
                ['icon', 'icon', '图标'],
                ['text', 'css_style', '按钮css样式'],
                ['text', 'url', 'url链接', '例如 : admin/menu/add'],
                ['radio', 'open_type', '打开显示类型', ' 默认|主要|警告|危险|成功', ['0' => '默认(info)', '1' => '警告(danger)', '3' => '危险(danger)', '4' => '成功(除此之外还有success)'], 0],
                ['text', 'param', '携带参数', "请输入携带参数 php代码格式['model_id'=>'__id__']"],
                ['text', 'sort', '排序', '数字越小越在前面', 100],
                ['text', 'confirm', '成功和错误的跳转页面'],
                ['switch', 'status', '状态', '', 1],
            ])
            ->fetch();
    }

    /**
     * @param string $id
     * @param string $tab
     * @return mixed
     * 编辑
     */
    public function edit($id = '', $tab = '', $group = '')
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['module_id'] = $group;
            $data['button_type'] = $tab;
            $param = $data['param'];
            if ($param) {
                $param_list = 'url(' . $data['url'] . ',' . $param . ')';
            } else {
                $param_list = 'url(' . $data['url'] . ')';
            }

//            $top_button_value = [
//                'title' => $data['title'],
//                'name' => $data['name'],
//                'icon' => $data['icon'],
//                'href' => $param_list,
//            ];
//            //查询model之前的数据
//            $top_button = ModelModel::where(array('id' => $group))->value('top_button_value');
//            //拼接成自己需要的数据
//            $datavalue = $top_button . ',' . serialize($top_button_value);
//            if ($tab == 'tab1') {
//                $update['top_button_value'] = $datavalue;
//            } elseif ($tab == 'tab2') {
//                $update['right_button_value'] = $datavalue;
//            }
//            if ($update) {
//                ModelModel::update($update, ['id' => $group]);
//            }
            $where['id'] = $id;
            $where['button_type'] = $tab;
            $data['status'] = 1;
            $datacreate = ButtonModel::update($data, $where);
            if ($datacreate) {
                $this->success('修改成功','index');
            }
        }


        $info = ButtonModel::get($id);
        return ZBuilder::make('form')
            ->addFormItems([
                ['text', 'title', '按钮标题', '只能是中文的汉字(添加)'],
                ['text', 'name', '按钮名称', '请填写字母的名称,例如: add delete'],
                ['icon', 'icon', '图标'],
                ['text', 'css_style', '按钮css样式'],
                ['text', 'url', 'url链接', '例如 : admin/menu/add'],
                ['radio', 'open_type', '打开显示类型', ' 默认|主要|警告|危险|成功', ['0' => '默认(info)', '1' => '警告(danger)', '3' => '危险(danger)', '4' => '成功(除此之外还有success)'], 0],
                ['text', 'param', '携带参数', "请输入携带参数 php代码格式['model_id'=>'__id__']"],
                ['text', 'sort', '排序', '数字越小越在前面', 100],
                ['text', 'confirm', '成功和错误的跳转页面'],
                ['switch', 'status', '状态', '', 1],
            ])
            ->setFormData($info)
            ->fetch();
    }


}