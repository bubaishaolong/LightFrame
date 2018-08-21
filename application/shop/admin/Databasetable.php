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
namespace app \shop\admin;

use app\admin\controller\Admin;
use app\admin\model\Moduleconfig as ModuleconfigModel;
use app\admin\model\Model as ModelModel;
use app\admin\model\Field as FieldModel;
use app\admin\model\Menu as MenuModel;
use app\common\builder\ZBuilder;
use think\Cache;
use think\Db;
use think\Request;

class  Databasetable extends Admin
{

    /**
     * 首页
     * @return mixed
     */
    public function index()
    {

        $request = Request::instance();
        $data = $request->dispatch();
        $mashu = $data['module'][0];

        // 查询
        //$map = $this->getMap();
        $map['name'] = $mashu;
        // 数据列表
        $data_list = ModelModel::where($map)->order('sort,id desc')->paginate();

        // 字段管理按钮
        $btnField = [
            'title' => '字段管理',
            'icon' => 'fa fa-fw fa-navicon',
            'href' => url('admin/field/index', ['id' => '__id__'])
        ];
        // 生成菜单节点
        $btnFieldNode = [
            'title' => '菜单列表',
            'icon' => 'glyphicon glyphicon-sort-by-attributes-alt',
            'href' => url('admin/fieldnode/index', ['id' => '__id__', 'group' => '__name__'])
        ];
        // 配置参数
        $btnFieldCof = [
            'title' => '配置管理',
            'icon' => 'glyphicon glyphicon-sort-by-attributes-alt',
            'href' => url('admin/moduleconfig/index', ['group' => $mashu])
        ];
        // 参数配置
        $btnFieldCofList = [
            'title' => '参数配置',
            'icon' => 'fa fa-fw fa-gears',
            'href' => url('shop/databasetable/getConfigureList', ['group' => $mashu])
        ];
        // 配置参数
        $btnButton = [
            'title' => '按钮配置',
            'icon' => 'fa fa-fw fa-address-card-o',
            'href' => url('admin/button/index', ['group' => $mashu, 'id' => '__id__'])
        ];
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['name' => '标识', 'title' => '标题'])// 设置搜索框
            ->setPageTips('目前只能添加系统自带: <br>顶部按钮包括 : add,enable,disable,custom,back <br>
右边按钮包括：edit,delete,disable,custom', 'danger')
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['icon', '图标', 'icon'],
                ['title', '表名', 'text'],
                ['name', '所属模块'],
                ['table', '数据表'],
                ['type', '模型', 'text', '', ['系统', '普通', '独立']],
                ['sort', '排序', 'text'],
                ['is_top_button', '顶部按钮', 'switch'],
                ['top_button_value', '顶部按钮值', 'textarea.edit'],
                ['is_right_button', '右侧按钮', 'switch'],
                ['right_button_value', '右侧按钮值', 'textarea.edit'],
                ['status', '状态', 'switch'],
                ['create_time', '创建时间', 'datetime'],
                ['right_button', '操作', 'btn']
            ])
            //->addValidate('ModelModel', 'title,sort') // 添加快捷编辑的验证器
            ->addFilter('type', ['系统', '普通', '独立'])
            ->addTopButtons(['back', 'add'])// 批量添加顶部按钮
            ->addTopButton('custom', $btnFieldCof, true)// 批量添加顶部按钮
            ->addRightButton('custombutton', $btnButton, true)
            ->addRightButton('customnode', $btnFieldNode, true)
            ->addTopButton('customConf', $btnFieldCofList, true)
            ->addRightButtons(['custom' => $btnField, 'edit', 'delete' => ['data-tips' => '删除模型将同时删除该模型下的所有字段，且无法恢复。']])// 批量添加右侧按钮,'custombutton'=>$btnButton,'customnode' => $btnFieldNode, 'custom' => $btnField,
            ->setRowList($data_list)// 设置表格数据
            ->fetch(); // 渲染模板
    }

    /**
     * 新增内容模型
     * @author 无名氏
     * @return mixed
     */
    public function add()
    {
        $request = Request::instance();
        $datas = $request->dispatch();
        $mashu = $datas['module'][0];
        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $table = $data['table'];
            GenerateFile($data['table'], $mashu);
            $datamingzi = $mashu . "/" . strtolower(convertUnderline($data['table'])) . "/index";
            if ($data['table'] == '') {
                $data['table'] = config('database.prefix') . $mashu . '_' . $data['table'];
            } else {
                $data['table'] = config('database.prefix') . $mashu . '_' . $data['table'];
            }
            // 验证
            $result = $this->validate($data, 'Databasetable');
            if (true !== $result) $this->error($result);
            // 严格验证附加表是否存在
            if (table_exist($data['table'])) {
                $this->error('附加表已存在');
            }
            $data['name'] = $mashu;
            $data['top_button_value'] = 'back,add';
            $data['right_button_value'] = 'edit,delete';
            if ($model = ModelModel::create($data)) {
                // 创建附加表
                if (false === ModelModel::createTable($model)) {
                    $this->error('创建附加表失败');
                }
                $menu_data = [
                    "module" => $mashu,
                    //"pid" => Db::name('admin_menu')->where($map)->value('id'),
                    "pid" => $data['pid'],
                    "title" => $data['title'],
                    "url_type" => "module_admin",
                    "url_value" => $datamingzi,
                    "url_target" => "_self",
                    "icon" => $data['icon'] ? $data['icon'] : "fa fa-fw fa-th-list",
                    "online_hide" => "0",
                    "sort" => "100",
                    "status"=>1,
                ];
                $menu = MenuModel::create($menu_data);
                $dataArrays = array('add','edit','delete');
                for ($i=0;$i<3;$i++){
                    $datamingzis[$i] = $mashu . "/" . strtolower(convertUnderline($table)) . "/".$dataArrays[$i];
                    if($dataArrays[$i] == 'add'){
						$data_title ='新增';
					}elseif ($dataArrays[$i] == 'edit'){
						$data_title ='编辑';
					}elseif ($dataArrays[$i] == 'delete'){
						$data_title ='删除';
					}
                    $menu_data_at[$i] = [
                        "module" => $mashu,
                        "pid" => $menu['id'],
                        "title" => $data_title,
                        "url_type" => "module_admin",
                        "url_value" => $datamingzis[$i],
                        "url_target" => "_self",
                        "icon" => $data['icon'] ? $data['icon'] : "fa fa-fw fa-th-list",
                        "online_hide" => "0",
                        "sort" => "100",
                        "status"=>0,
                    ];
                    MenuModel::create($menu_data_at[$i]);
                }
//				unset($data);
                // 记录行为
                Cache::clear();
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }

        $type_tips = '此选项添加后不可更改。如果为 <code>系统模型</code> 将禁止删除，对于 <code>独立模型</code>，将强制创建字段id,cid,uid,model,title,create_time,update_time,sort,status,trash,view';
        $datalists = Db::table('cj_admin_menu')->where(array('module' => $mashu, 'pid' => 0))->value('id');
        $dataarray = Db::table('cj_admin_menu')->where(array('pid' => $datalists))->column('id,title');
        $dataarray[$datalists] = '顶级菜单';
        // 显示添加页面
        return ZBuilder::make('form')
            ->setPageTips('系统会自动生成一些常规的节点,特殊节点需要自己去添加')
            ->addFormItems([
                ['static', 'name', '模型标识', '由小写字母、数字或下划线组成，不能以数字开头', 'shop'],
                ['text', 'title', '表名', '可填写中文'],
                ['text', 'table', '数据表', '创建后不可更改。由小写字母、数字或下划线组成，如果不填写默认为 <code>' . config('database.prefix') . $mashu . '_模型标识</code>，如果需要自定义，请务必填写系统表前缀，<code>#@__</code>表示当前系统表前缀'],
                ['radio', 'type', '模型类别', $type_tips, ['系统模型', '普通模型', '独立模型(不使用主表)'], 1],
                ['select', 'pid', '选择上级菜单', '', $dataarray],
                ['icon', 'icon', '图标'],
                ['radio', 'is_top_button', '顶部按钮', '', ['不显示', '显示'], 1],
                ['radio', 'is_right_button', '右侧按钮', '', ['不显示', '显示'], 1],
                ['radio', 'status', '立即启用', '', ['否', '是'], 1],
                ['text', 'sort', '排序', '', 100],
            ])
            ->fetch();
    }

    /**
     * 编辑内容模型
     * @param null $id 模型id
     * @author 无名氏
     * @return mixed
     */
    public function edit($id = null)
    {
		$menuinfo = ModelModel::get($id);
        if ($id === null) $this->error('参数错误');
        $request = Request::instance();
        $datas = $request->dispatch();
        $mashu = $datas['module'][0];
        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            $result = $this->validate($data, 'Databasetable.edit');
            if (true !== $result) $this->error($result);

            if (ModelModel::update($data)) {
				$request = Request::instance();
				$datas =$request->dispatch();
				$mashu =$datas['module'][0];
				$menutitle = $menuinfo['table'];
				$datamenu = explode(config('database.prefix').$mashu.'_',$menutitle);
				$datamenuname = strtolower(ucwordsUnderline($datamenu[1]));
				//拼接链接
				$lianjie = $mashu.'/'.$datamenuname.'/index';
				$update_menu['title']= $data['title'];
				$where_menu['url_value']= $lianjie;
				MenuModel::update($update_menu,$where_menu);
                cache('admin_model_list', null);
                cache('admin_model_title_list', null);
                // 记录行为
                //action_log('databasetable_edit', $mashu.'_edit', $id, UID, "ID({$id}),标题({$data['title']})");
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }

        $list_model_type = ['系统模型', '普通模型', '独立模型(不使用主表)'];

        // 模型信息
        $info = ModelModel::get($id);
        $info['type'] = $list_model_type[$info['type']];

        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden', 'id'],
                ['hidden', 'name'],
                ['static', 'name', '模型标识'],
                ['static', 'type', '模型类别'],
                ['static', 'table', '附加表'],
                ['text', 'title', '模型标题', '可填写中文'],
                ['icon', 'icon', '图标'],
                ['radio', 'is_top_button', '顶部按钮', '', ['不显示', '显示'], 1],
                ['radio', 'is_right_button', '右侧按钮', '', ['不显示', '显示'], 1],
                ['textarea', 'top_button_value', '顶部按钮值'],
                ['textarea', 'right_button_value', '右侧按钮值'],
                ['radio', 'status', '立即启用', '', ['否', '是']],
                ['text', 'sort', '排序'],
            ])
            ->setFormData($info)
            ->fetch();
    }

    /**
     * 删除内容模型
     * @param null $ids 内容模型id
     * @author 无名氏
     * @return mixed|void
     */
    public function delete($ids = null)
    {
        if ($ids === null) $this->error('参数错误');

        $model = ModelModel::where('id', $ids)->find();
        $datapp = explode(config('database.prefix') . $model['name'] . '_', $model['table']);
        if ($datapp[1]) {
            DeleteCorrespondingFile('shop', $datapp[1]);
        }
        if ($model['type'] == 0) {
            $this->error('禁止删除系统模型');
        }
        // 删除表和字段信息
        if (ModelModel::deleteTable($ids)) {
            // 删除主表中的文档
            if (false === Db::name('admin_model')->where('id', $ids)->delete()) {
                $this->error('删除主表文档失败');
            }
            // 删除字段数据
            if (false !== Db::name('admin_field')->where('model', $ids)->delete()) {
                cache(config('database.prefix') . 'model_list', null);
                cache(config('database.prefix') . 'model_title_list', null);
                $request = Request::instance();
                $data = $request->dispatch();
                $module = $data['module'][0];
                //删除菜单的列
                $datamingzi = $module . "/{$model['table']}/index";
                if (false !== Db::name('admin_menu')->where('url_value', $datamingzi)->delete()) {
                    //删除对用的文件及文件夹
                    if ($datapp[1]) {
                        DeleteCorrespondingFile('shop', $datapp[1]);
                    }
                    $this->success('删除成功', 'index');
                }

            } else {
                $this->error('删除内容模型字段失败');
            }
        } else {
            $this->error('删除内容模型表失败');
        }
    }


    /**
     * 快速编辑
     * @param array $record 行为日志
     * @author 无名氏
     * @return mixed
     */
    public function quickEdit($record = [])
    {
        $id = input('post.pk', '');
        $field = input('post.name', '');
        $value = input('post.value', '');
        $config = ModelModel::where('id', $id)->value($field);
        //$details = '字段(' . $field . ')，原值(' . $config . ')，新值：(' . $value . ')';
        $where = array('id' => $id, $field => $config);
        $update[$field] = $value;
        $updateInfo = ModelModel::update($update, $where);
        if ($updateInfo) {
            $this->success('快速编辑成功', 'index');
        }

        //return parent::quickEdit(['model_edit', 'admin_model', $id, UID, $details]);
    }

    /**
     * 添加子节点
     * @param array $data 节点数据
     * @param string $pid 父节点id
     * @author 无名氏
     */
    private function createChildNode($data = [], $pid = '')
    {
        $url_value = substr($data['url_value'], 0, strrpos($data['url_value'], '/')) . '/';
        $child_node = [];
        $data['pid'] = $pid;

        foreach ($data['child_node'] as $item) {
            switch ($item) {
                case 'add':
                    $data['title'] = '新增';
                    break;
                case 'edit':
                    $data['title'] = '编辑';
                    break;
                case 'delete':
                    $data['title'] = '删除';
                    break;
                case 'enable':
                    $data['title'] = '启用';
                    break;
                case 'disable':
                    $data['title'] = '禁用';
                    break;
                case 'quickedit':
                    $data['title'] = '快速编辑';
                    break;
            }
            $data['url_value'] = $url_value . $item;
            $data['create_time'] = $this->request->time();
            $data['update_time'] = $this->request->time();
            $child_node[] = $data;
        }

        if ($child_node) {
            $MenuModel = new MenuModel();
            $MenuModel->insertAll($child_node);
        }
    }

    /**
     * @param string $name 分组的名称
     * @param string $group 所在模块
     * @param string $tab 按钮列表
     * @return mixed
     * 配置参数
     */
    public function getConfigureList($name = '基本配置',$group = '', $tab = 'tab0')
    {

        if($this->request->isPost()){
            $data = $this->request->post();
            foreach ($data as $key=>$value){
                 $where = array('name'=>$key,'module_name'=>$group);
                 $updata['default_value'] =  $value;
                 ModuleconfigModel::update($updata,$where);
            }
            $this->success('编辑成功');
        }
        $group_name = Db::name('admin_module_config')->where(array('module_name' => $group, 'status' => 1))->distinct(true)->order('sort asc')->column('group_name');
        for ($i = 0; $i < count($group_name); $i++) {
            $list_tab['tab' . $i] = ['title' => $group_name[$i], 'url' => url('getConfigureList', ['name' => $group_name[$i], 'group' => $group, 'tab' => 'tab' . $i])];
            $dataLists = ModuleconfigModel::where(array('group_name' => ['like','%'.$group_name[$i].'%']))->select();
            foreach ($dataLists as $key => $value) {
                if($name ==$value['group_name'] ){
                    $datas[$key] = [$value['field_type'], $value['name'], $value['title']];
                    $info =  ModuleconfigModel::where(array('module_name' => $group, 'status' => 1,'group_name' => $value['group_name']))->column('name,default_value');
                }
            }
        }
        return ZBuilder::make('form')
            ->setTabNav($list_tab, $tab)
            ->addFormItems($datas)
            ->setFormData($info)
            ->fetch();

    }
}