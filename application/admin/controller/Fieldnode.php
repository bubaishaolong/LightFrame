<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/23
 * Time: 13:26
 */

namespace app\admin\controller;


use app\admin\model\Model;
use app\common\builder\ZBuilder;
use app\admin\model\Module as ModuleModel;
use app\admin\model\Menu as MenuModel;
use app\user\model\Role as RoleModel;
use think\Cache;
use think\Request;

/**
 * Class Fieldnode
 * @package app\admin\controller
 * 生成菜单节点
 */
class Fieldnode extends Admin
{

    public function index($group = '',$id ='')
    {
        // 生成对应的类文件
        $btnFieldClass = [
            'title' => '新增',
            'icon' => 'glyphicon glyphicon-book',
            'href' => url('admin/fieldnode/add', ['module' => $group])
        ];
        $btnFieldedit = [
            'title' => '编辑',
            'icon' => 'glyphicon glyphicon-book',
            'href' => url('admin/fieldnode/edit', ['id' => '__id__', 'module' => $group])
        ];
        $request = Request::instance();
        $data = $request->dispatch();
        $mashu = $data['module'][0];
        //$data_list = MenuModel::getMenusByGroup($group);
        $map['module'] = $group;
        $tables = Model::where(array('id'=>$id,'name'=>$group,'status'=>1))->value('table');
        if($tables){
            $ex = explode('cj_'.$group.'_',$tables);
            $map['url_value'] = ['like','%'.lcfirst(convertUnderline($ex[1])).'%'];
        }
        $data_list = MenuModel::where($map)->order('sort,id')->select();
        //dump($data_list);die;
        return ZBuilder::make('table')
            //->setPageTitle(lcfirst(convertUnderline($ex[1])).'节点列表')
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['pid', 'PID'],
                ['module', '模块', 'text'],
                ['title', '菜单', 'text'],
                ['url_value', '链接'],
                ['status', '是否启用', 'switch'],
                ['right_button', '操作', 'btn']
            ])
            ->addRightButtons(['delete'])// 批量添加右侧按钮
            ->addRightButton('custom', $btnFieldedit,true)// 批量添加右侧按钮
            //->addTopButtons(['back']) // 批量添加右侧按钮
            ->addTopButton('customs', $btnFieldClass,true)// 批量添加顶部按钮
            ->setRowList($data_list)
            ->fetch();
    }

    /**
     * @param string $module
     * @return mixed
     * 新增节点
     */

    public function add($module = '')
    {

        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post('', null, 'trim');

            // 验证
            $result = $this->validate($data, 'Menu');
            // 验证失败 输出错误信息
            if (true !== $result) $this->error($result);

            // 顶部节点url检查
            if ($data['pid'] == 0 && $data['url_value'] == '' && ($data['url_type'] == 'module_admin' || $data['url_type'] == 'module_home')) {
                $this->error('顶级节点的节点链接不能为空');
            }

            if ($menu = MenuModel::create($data)) {
                // 自动创建子节点
                if ($data['auto_create'] == 1 && !empty($data['child_node'])) {
                    unset($data['icon']);
                    unset($data['params']);
                    $this->createChildNode($data, $menu['id']);
                }
                // 添加角色权限
                if (isset($data['role'])) {
                    $this->setRoleMenu($menu['id'], $data['role']);
                }
                Cache::clear();
                // 记录行为
                $details = '所属模块(' . $data['module'] . '),所属节点ID(' . $data['pid'] . '),节点标题(' . $data['title'] . '),节点链接(' . $data['url_value'] . ')';
                action_log('menu_add', 'admin_menu', $menu['id'], UID, $details);
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }
        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
            ->setPageTitle('新增菜单节点')
            ->addLinkage('module', '所属模块', '', ModuleModel::getModule(), $module, url('ajax/getModuleMenus'), 'pid')
            ->addFormItems([
                ['select', 'pid', '所属节点', '所属上级节点', MenuModel::getMenuTree(0, '', $module)],
                ['text', 'title', '节点标题'],
                ['radio', 'url_type', '链接类型', '', ['module_admin' => '模块链接(后台)', 'module_home' => '模块链接(前台)', 'link' => '普通链接'], 'module_admin']
            ])
            ->addFormItem(
                'text',
                'url_value',
                '节点链接',
                "可留空，如果是模块链接，请填写<code>模块/控制器/操作</code>，如：<code>$module/menu/add</code>。如果是普通链接，则直接填写url地址，如：<code>http://www.xxxxx.com</code>"
            )
            ->addText('params', '参数', '如：a=1&b=2')
            ->addSelect('role', '角色', '除超级管理员外，拥有该节点权限的角色', RoleModel::where('id', 'neq', 1)->column('id,name'), '', 'multiple')
            ->addRadio('auto_create', '自动添加子节点', '选择【是】则自动添加指定的子节点', ['否', '是'], 0)
            ->addCheckbox('child_node', '子节点', '仅上面选项为【是】时起作用', ['add' => '新增', 'edit' => '编辑', 'delete' => '删除', 'enable' => '启用', 'disable' => '禁用', 'quickedit' => '快速编辑'], 'add,edit,delete,enable,disable,quickedit')
            ->addRadio('url_target', '打开方式', '', ['_self' => '当前窗口', '_blank' => '新窗口'], '_self')
            ->addIcon('icon', '图标', '导航图标')
            ->addRadio('online_hide', '网站上线后隐藏', '关闭开发模式后，则隐藏该菜单节点', ['否', '是'], 0)
            ->addText('sort', '排序', '', 100)
            ->setTrigger('auto_create', '1', 'child_node', false)
            ->fetch();
    }


    /**
     * 编辑节点
     * @param int $id 节点ID
     * @return mixed
     */
    public function edit($id = 0, $module = '')
    {
        if ($id === 0) $this->error('缺少参数');

        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post('', null, 'trim');

            // 验证
            $result = $this->validate($data, 'Menu');
            // 验证失败 输出错误信息
            if (true !== $result) $this->error($result);

            // 顶部节点url检查
            if ($data['pid'] == 0 && $data['url_value'] == '' && ($data['url_type'] == 'module_admin' || $data['url_type'] == 'module_home')) {
                $this->error('顶级节点的节点链接不能为空');
            }

            // 设置角色权限
            $this->setRoleMenu($data['id'], isset($data['role']) ? $data['role'] : []);

            // 验证是否更改所属模块，如果是，则该节点的所有子孙节点的模块都要修改
            $map['id'] = $data['id'];
            $map['module'] = $data['module'];
            if (!MenuModel::where($map)->find()) {
                MenuModel::changeModule($data['id'], $data['module']);
            }

            if (MenuModel::update($data)) {
                Cache::clear();
                // 记录行为
                $details = '节点ID(' . $id . ')';
                action_log('menu_edit', 'admin_menu', $id, UID, $details);
                $this->success('编辑成功', null, '_parent_reload');
            } else {
                $this->error('编辑失败');
            }
        }

        // 获取数据
        $info = MenuModel::get($id);
        // 拥有该节点权限的角色
        $info['role'] = RoleModel::getRoleWithMenu($id);

        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
            ->setPageTitle('编辑节点')
            ->addFormItem('hidden', 'id')
            ->addLinkage('module', '所属模块', '', ModuleModel::getModule(), '', url('ajax/getModuleMenus'), 'pid')
            ->addFormItem('select', 'pid', '所属节点', '所属上级节点', MenuModel::getMenuTree(0, '', $info['module']))
            ->addFormItem('text', 'title', '节点标题')
            ->addFormItem('radio', 'url_type', '链接类型', '', ['module_admin' => '模块链接(后台)', 'module_home' => '模块链接(前台)', 'link' => '普通链接'], 'module_admin')
            ->addFormItem(
                'text',
                'url_value',
                '节点链接',
                "可留空，如果是模块链接，请填写<code>模块/控制器/操作</code>，如：<code>admin/menu/add</code>。如果是普通链接，则直接填写url地址，如：<code>http://www.dolphinphp.com</code>"
            )
            ->addText('params', '参数', '如：a=1&b=2')
            ->addSelect('role', '角色', '除超级管理员外，拥有该节点权限的角色', RoleModel::where('id', 'neq', 1)->column('id,name'), '', 'multiple')
            ->addRadio('url_target', '打开方式', '', ['_self' => '当前窗口', '_blank' => '新窗口'], '_self')
            ->addIcon('icon', '图标', '导航图标')
            ->addRadio('online_hide', '网站上线后隐藏', '关闭开发模式后，则隐藏该菜单节点', ['否', '是'])
            ->addText('sort', '排序', '', 100)
            ->setFormData($info)
            ->fetch();
    }

    /**
     * 删除节点
     * @param array $record 行为日志内容
     * @author 无名氏
     * @return mixed
     */
    public function delete($record = [])
    {
        $id = $this->request->param('ids');
        $menu = MenuModel::where('id', $id)->find();
        if ($menu['system_menu'] == '1') $this->error('系统节点，禁止删除');

        // 获取该节点的所有后辈节点id
        $menu_childs = MenuModel::getChildsId($id);

        // 要删除的所有节点id
        $all_ids = array_merge([(int)$id], $menu_childs);

        // 删除节点
        if (MenuModel::destroy($all_ids)) {
            Cache::clear();
            // 记录行为
            $details = '节点ID(' . $id . '),节点标题(' . $menu['title'] . '),节点链接(' . $menu['url_value'] . ')';
            action_log('menu_delete', 'admin_menu', $id, UID, $details);
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
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
     * 设置角色权限
     * @param string $role_id 角色id
     * @param array $roles 角色id
     * @author 无名氏
     */
    private function setRoleMenu($role_id = '', $roles = [])
    {
        $RoleModel = new RoleModel();

        // 该节点的所有子节点，包括本身节点
        $menu_child = MenuModel::getChildsId($role_id);
        $menu_child[] = (int)$role_id;
        // 该节点的所有上下级节点
        $menu_all = MenuModel::getLinkIds($role_id);
        $menu_all = array_map('strval', $menu_all);

        if (!empty($roles)) {
            // 拥有该节点的所有角色id及节点权限
            $role_menu_auth = RoleModel::getRoleWithMenu($role_id, true);
            // 已有该节点权限的角色id
            $role_exists = array_keys($role_menu_auth);
            // 新节点权限的角色
            $role_new = $roles;
            // 原有权限角色差集
            $role_diff = array_diff($role_exists, $role_new);
            // 新权限角色差集
            $role_diff_new = array_diff($role_new, $role_exists);
            // 新节点角色权限
            $role_new_auth = RoleModel::getAuthWithRole($roles);

            // 删除原先角色的该节点权限
            if ($role_diff) {
                $role_del_auth = [];
                foreach ($role_diff as $role) {
                    $auth = json_decode($role_menu_auth[$role], true);
                    $auth_new = array_diff($auth, $menu_child);
                    $role_del_auth[] = [
                        'id' => $role,
                        'menu_auth' => array_values($auth_new)
                    ];
                }
                if ($role_del_auth) {
                    $RoleModel->saveAll($role_del_auth);
                }
            }

            // 新增权限角色
            if ($role_diff_new) {
                $role_update_auth = [];
                foreach ($role_new_auth as $role => $auth) {
                    $auth = json_decode($auth, true);
                    if (in_array($role, $role_diff_new)) {
                        $auth = array_unique(array_merge($auth, $menu_all));
                    }
                    $role_update_auth[] = [
                        'id' => $role,
                        'menu_auth' => array_values($auth)
                    ];
                }
                if ($role_update_auth) {
                    $RoleModel->saveAll($role_update_auth);
                }
            }
        } else {
            $role_menu_auth = RoleModel::getRoleWithMenu($role_id, true);
            $role_del_auth = [];
            foreach ($role_menu_auth as $role => $auth) {
                $auth = json_decode($auth, true);
                $auth_new = array_diff($auth, $menu_child);
                $role_del_auth[] = [
                    'id' => $role,
                    'menu_auth' => array_values($auth_new)
                ];
            }
            if ($role_del_auth) {
                $RoleModel->saveAll($role_del_auth);
            }
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
		$id      = input('post.pk', '');
		$field   = input('post.name', '');
		$value   = input('post.value', '');
		$config  = MenuModel::where('id', $id)->value($field);
		//$details = '字段(' . $field . ')，原值(' . $config . ')，新值：(' . $value . ')';
		$where = array('id'=>$id,$field=>$config);
		$update[$field] = $value;
		$updateInfo = MenuModel::update($update,$where);
		if($updateInfo){
			$this->success('快速编辑成功','index');
		}

//		return parent::quickEdit(['model_edit', 'admin_model', $id, UID, $details]);
	}
}