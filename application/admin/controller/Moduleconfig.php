<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/24
 * Time: 13:58
 */

namespace app\admin\controller;


use app\common\builder\ZBuilder;
use app\admin\model\Moduleconfig as ModuleconfigModel;

class Moduleconfig extends Admin
{
    /**
     * 配置首页
     * @param string $group 分组
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     *
     */
    public function index($group = '')
    {

        // 配置分组信息
//        $list_group = config('config_group');
//        $tab_list   = [];
//        foreach ($list_group as $key => $value) {
//            $tab_list[$key]['title'] = $value;
//            $tab_list[$key]['url']   = url('index', ['group' => $key]);
//        }

        // 查询
        $map = $this->getMap();
        $map['module_name'] = $group;
        $map['status'] = ['egt', 0];

        // 排序
        $order = $this->getOrder('sort asc,id asc');
        // 数据列表
        $data_list = ModuleconfigModel::where($map)->order($order)->paginate();

        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setPageTitle('配置管理')// 设置页面标题
//            ->setTabNav($tab_list, $group) // 设置tab分页
            ->setSearch(['name' => '名称', 'title' => '标题'])// 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', '编号', 'text.edit'],
                ['name', '字段名称', 'text.edit'],
                ['title', '字段标题', 'text.edit'],
                ['group_name', '分组名称', 'text.edit'],
                ['default_value', '默认值', 'text.edit'],
                ['module_name', '模块标识', 'text.edit'],
                ['field_type', '字段类型', 'text.edit'],
                ['field_hints', '字段提示', 'text.edit'],
                ['is_required', '是否必填'],
                ['status', '状态', 'switch'],
                ['sort', '排序', 'text.edit'],
                ['right_button', '操作', 'btn']
            ])
            ->addValidate('Config', 'name,title')// 添加快捷编辑的验证器
            ->addOrder('name,title,status')// 添加标题字段排序
            ->addFilter('name,title')// 添加标题字段筛选
            ->addFilter('type', config('form_item_type'))// 添加标题字段筛选
            ->addFilterMap('name,title', ['module_name' => $group])// 添加标题字段筛选条件
            ->addTopButton('add', ['href' => url('add', ['group' => $group])], true)// 添加单个顶部按钮
            ->addTopButtons('enable,disable,delete')// 批量添加顶部按钮
            ->addRightButton('edit', [], true)
            ->addRightButton('delete')// 批量添加右侧按钮
            ->setRowList($data_list)// 设置表格数据
            ->fetch(); // 渲染模板
    }

    /**
     * 新增配置项
     * @param string $group 分组
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function add($group = '')
    {
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $data['module_name'] = $group;
            // 验证
            $result = $this->validate($data, 'Moduleconfig');
            if (true !== $result) $this->error($result);
            if ($config = ModuleconfigModel::create($data)) {
                cache('system_config', null);
                $forward = $this->request->param('_pop') == 1 ? null : cookie('__forward__');
                // 记录行为
                $details = '详情：分组(' . $data['group_name'] . ')、类型(' . $data['field_type'] . ')、标题(' . $data['title'] . ')、名称(' . $data['name'] . ')';
                action_log('moduleconfig_add', 'admin_moduleconfig', $config['id'], UID, $details);
                $this->success('新增成功', $forward);
            } else {
                $this->error('新增失败');
            }
        }

        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
            ->setPageTitle('新增')
            //->addSelect('selection', '配置分组', '', config('config_group'), $group)
            ->addText('title', '字段标题', '一般由中文组成，仅用于显示')
            ->addText('name', '字段名称')
            ->addText('group_name','分组名称')
            ->addStatic('module_name','模块标识','',$group)
            ->addSelect('field_type', '字段类型', '', config('database_data_type'))
            ->addText('default_value','默认值','',0)
            ->addText('field_hints','字段提示')
            ->addRadio('is_required','是否必填','',['必填','不必填'],0)
            ->addRadio('status','是否启用','',['禁用','启用'],1)
            ->addText('sort', '排序', '', 100)
            ->fetch();
    }

}