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

use app\admin\model\Module as ModuleModel;
use app\admin\model\Plugin as PluginModel;
use app\admin\model\Menu as MenuModel;
use app\admin\model\Action as ActionModel;
use app\common\builder\ZBuilder;
use think\Cache;
use util\Database;
use util\Sql;
use util\File;
use util\PHPZip;
use util\Tree;
use think\Db;

/**
 * 模块管理控制器
 * @package app\admin\home
 */
class Module extends Admin
{
    /**
     * 模块首页
     * @param string $group 分组
     * @param string $type 显示类型
     * @author 无名氏
     * @return mixed, 'design' => '设计模块'
     */
    public function index($group = 'local', $type = '')
    {
        // 配置分组信息
        $list_group = ['local' => '本地模块'];
        foreach ($list_group as $key => $value) {
            $tab_list[$key]['title'] = $value;
            $tab_list[$key]['url'] = url('index', ['group' => $key]);
        }
        switch ($group) {
            case 'local':
                // 查询条件
                $keyword = $this->request->get('keyword', '');

                if (input('?param.status') && input('param.status') != '_all') {
                    $status = input('param.status');
                } else {
                    $status = '';
                }

                $ModuleModel = new ModuleModel();
                $result = $ModuleModel->getAll($keyword, $status);

                if ($result['modules'] === false) {
                    $this->error($ModuleModel->getError());
                }

                $type_show = Cache::get('module_type_show');
                $type_show = $type != '' ? $type : ($type_show == false ? 'block' : $type_show);
                Cache::set('module_type_show', $type_show);
                $type = $type_show == 'block' ? 'list' : 'block';

                $this->assign('page_title', '模块管理');
                $this->assign('modules', $result['modules']);
                $this->assign('total', $result['total']);
                $this->assign('tab_nav', ['tab_list' => $tab_list, 'curr_tab' => $group]);
                $this->assign('type', $type);
                return $this->fetch();
                break;
            case 'design':
                if ($this->request->isPost()) {
                    $data = $this->request->post();
                    //先生成文件目录
                    $name = $data['name'];
                    //判断模块是否存在
                    $dataINfo = Db::table('cj_admin_module')->where('name','=',$name)->value('name');
                    if($dataINfo){
                        $this->error('模块已存在');
                    }
                    $fileTrue = AutomaticGeneration($name);
                    if ($fileTrue === false) {
                        $this->error('生成文件目录失败');
                    }
                    $table = $data['tags'];
                    $datas = explode(',', $table);
                    $data_count = count($datas);
                    for ($i = 0; $i < $data_count; $i++) {
                        $infoname =config('database.prefix').$name.'_'.$datas[$i];
                        $dataq[$i] = $infoname;
                    }
                    //生成info和menus文件
                    $info = [
                        // 模块名[必填]
                        'name' => $name,
                        // 模块标题[必填]
                        'title' => $data['title'],
                        // 模块唯一标识[必填]，格式：模块名.开发者标识.module
                        'identifier' => $data['identifier'],
                        // 模块图标[选填]
                        'icon' => $data['icon'],
                        // 模块描述[选填]
                        'description' => $data['description'],
                        // 开发者[必填]
                        'author' => $data['author'],
                        // 开发者网址[选填]
                        'author_url' => $data['author_url'],
                        // 版本[必填],格式采用三段式：主版本号.次版本号.修订版本号
                        'version' => $data['version'],
                        // 模块依赖[可选]，格式[[模块名, 模块唯一标识, 依赖版本, 对比方式]]
                        'need_module' => [
                            ['admin', 'admin.dolphinphp.module', '1.0.0']
                        ],
                        // 数据表[有数据库表时必填]

                        'tables' =>$dataq,
                    ];
                    //生成info文件内容
                    buildInfoFile($info,$name);
                    //生成menus文件内容
                    $menus = [[
                        'title' => $data['title'],
                        'icon' => 'fa fa-fw fa-newspaper-o',
                        'url_type' => 'module_admin',
                        'url_value' => $name.'/index/index',
                        'url_target' => '_self',
                        'online_hide' => 0,
                        'sort' => 100,
                        'child' => [],]];
                    buildMenuFile($menus,$name);
                    //生成数据表固定字段
                    AutomaticGenerationOfDataTables($table,$name);
                    //根据数据表名生成文件
                    GenerateFile($table,$name);
                    //插入module表中
//                    $dataadd = ['name'=>$data['name'],'title'=>$data['title'],'icon'=>$data['icon'],'description'=>$data['description'],'author'=>$data['author'],'author_url'=>$data['author_url'],'version'=>$data['version'],'identifier'=>$data['identifier'],'system_module'=>$data['system_module']];
//                    $dataAddinfo = Db::table('cj_admin_module')->insert($dataadd);
//                    if($dataAddinfo){
//                        $this->success('添加成功');
//                        //生成菜单链接
//
//                    }else{
//                        $this->error('添加失败');
//                    }
                }
                $dataList = Db::table('cj_admin_module')->column('title');
                // 使用ZBuilder构建表单页面，并将页面标题设置为“添加”
                return ZBuilder::make('form')->setPageTitle('添加')->setPageTips('添加需要的模块', 'danger')
                    ->addFormItems([
                        ['text', 'name', '模块名称（标识）','全部小写，不能有其他特殊字符'],
                        ['text', 'title', '模块标题','有中文组成'],
                        ['icon', 'icon', '选择图标'],
                        ['text', 'description', '描述'],
                        ['text', 'author', '作者','例如 : 小马哥'],
                        ['text', 'author_url', '作者主页','例如 : www.baidu.com'],
                        //['text', 'config', '配置信息'],
                        //['text', 'access', '授权配置'],
                        ['text', 'version', '版本号','例如 : 1.0.0'],
                        ['text', 'identifier', '模块唯一标识符','模块.标识.module'],
                        ['radio', 'system_module', '是否为系统模块', '', $dataList, 0],
                        ['tags', 'tags', '数据库表'],
                    ])->setBtnTitle(['submit' => '确定', 'back' => '返回前一页'])
                    ->setBtnTitle()->fetch();
                break;
            case 'online':
                return '<h2>正在建设中...</h2>';
                break;
            default:
                $this->error('非法操作');
        }
    }

    /**
     * 安装模块
     * @param string $name 模块标识
     * @param int $confirm 是否确认
     * @author 无名氏
     * @return mixed
     */
    public function install($name = '', $confirm = 0)
    {
        // 设置最大执行时间和内存大小
        ini_set('max_execution_time', '0');
        ini_set('memory_limit', '1024M');

        if ($name == '') $this->error('模块不存在！');
        if ($name == 'admin' || $name == 'user') $this->error('禁止操作系统核心模块！');

        // 模块配置信息
        $module_info = ModuleModel::getInfoFromFile($name);

        if ($confirm == 0) {
            $need_module = [];
            $need_plugin = [];
            $table_check = [];
            // 检查模块依赖
            if (isset($module_info['need_module']) && !empty($module_info['need_module'])) {
                $need_module = $this->checkDependence('module', $module_info['need_module']);
            }

            // 检查插件依赖
            if (isset($module_info['need_plugin']) && !empty($module_info['need_plugin'])) {
                $need_plugin = $this->checkDependence('plugin', $module_info['need_plugin']);
            }

            // 检查数据表
            if (isset($module_info['tables']) && !empty($module_info['tables'])) {
                foreach ($module_info['tables'] as $table) {
                    if (Db::query("SHOW TABLES LIKE '"  . "{$table}'")) {
                        $table_check[] = [
                            'table' =>  "{$table}",
                            'result' => '<span class="text-danger">存在同名</span>'
                        ];
                    } else {
                        $table_check[] = [
                            'table' => "{$table}",
                            'result' => '<i class="fa fa-check text-success"></i>'
                        ];
                    }
                }
            }

            $this->assign('need_module', $need_module);
            $this->assign('need_plugin', $need_plugin);
            $this->assign('table_check', $table_check);
            $this->assign('name', $name);
            $this->assign('page_title', '安装模块：' . $name);
            return $this->fetch();
        }

        // 执行安装文件
        $install_file = realpath(APP_PATH . $name . '/install.php');
        if (file_exists($install_file)) {
            @include($install_file);
        }

        // 执行安装模块sql文件
        $sql_file = realpath(APP_PATH . $name . '/sql/install.sql');
        if (file_exists($sql_file)) {
            if (isset($module_info['database_prefix']) && !empty($module_info['database_prefix'])) {
                $sql_statement = Sql::getSqlFromFile($sql_file, false, [$module_info['database_prefix'] => config('database.prefix')]);
            } else {
                $sql_statement = Sql::getSqlFromFile($sql_file);
            }
            if (!empty($sql_statement)) {
                foreach ($sql_statement as $value) {
                    try {
                        Db::execute($value);
                    } catch (\Exception $e) {
                        $this->error('导入SQL失败，请检查install.sql的语句是否正确');
                    }
                }
            }
        }

        // 添加菜单
        $menus = ModuleModel::getMenusFromFile($name);
        if (is_array($menus) && !empty($menus)) {
            if (false === $this->addMenus($menus, $name)) {
                $this->error('菜单添加失败，请重新安装');
            }
        }
        // 检查是否有模块设置信息
        if (isset($module_info['config']) && !empty($module_info['config'])) {
            $module_info['config'] = json_encode(parse_config($module_info['config']));
        }

        // 检查是否有模块授权配置
        if (isset($module_info['access']) && !empty($module_info['access'])) {
            $module_info['access'] = json_encode($module_info['access']);
        }

        // 检查是否有行为规则
        if (isset($module_info['action']) && !empty($module_info['action'])) {
            $ActionModel = new ActionModel;
            if (!$ActionModel->saveAll($module_info['action'])) {
                MenuModel::where('module', $name)->delete();
                $this->error('行为添加失败，请重新安装');
            }
        }

        // 将模块信息写入数据库
        $ModuleModel = new ModuleModel($module_info);
        $allowField = ['name', 'title', 'icon', 'description', 'author', 'author_url', 'config', 'access', 'version', 'identifier', 'status'];

        if ($ModuleModel->allowField($allowField)->save()) {
            // 复制静态资源目录
            File::copy_dir(APP_PATH . $name . '/public', ROOT_PATH . 'public');
            // 删除静态资源目录
            File::del_dir(APP_PATH . $name . '/public');
            cache('modules', null);
            cache('module_all', null);
            // 记录行为
            action_log('module_install', 'admin_module', 0, UID, $module_info['title']);
            $this->success('模块安装成功', 'index');
        } else {
            MenuModel::where('module', $name)->delete();
            $this->error('模块安装失败');
        }
    }

    /**
     * 卸载模块
     * @param string $name 模块名
     * @param int $confirm 是否确认
     * @author 无名氏
     * @return mixed
     */
    public function uninstall($name = '', $confirm = 0)
    {
        if ($name == '') $this->error('模块不存在！');
        if ($name == 'admin') $this->error('禁止操作系统模块！');

        // 模块配置信息
        $module_info = ModuleModel::getInfoFromFile($name);

        if ($confirm == 0) {
            $this->assign('name', $name);
            $this->assign('page_title', '卸载模块：' . $name);
            return $this->fetch();
        }

        // 执行卸载文件
        $uninstall_file = realpath(APP_PATH . $name . '/uninstall.php');
        if (file_exists($uninstall_file)) {
            @include($uninstall_file);
        }

        // 执行卸载模块sql文件
        $clear = $this->request->get('clear');
        if ($clear == 1) {
            $sql_file = realpath(APP_PATH . $name . '/sql/uninstall.sql');
            if (file_exists($sql_file)) {
                if (isset($module_info['database_prefix']) && !empty($module_info['database_prefix'])) {
                    $sql_statement = Sql::getSqlFromFile($sql_file, false, [$module_info['database_prefix'] => config('database.prefix')]);
                } else {
                    $sql_statement = Sql::getSqlFromFile($sql_file);
                }

                if (!empty($sql_statement)) {
                    foreach ($sql_statement as $sql) {
                        try {
                            Db::execute($sql);
                        } catch (\Exception $e) {
                            $this->error('卸载失败，请检查uninstall.sql的语句是否正确');
                        }
                    }
                }
            }
        }

        // 删除菜单
        if (false === MenuModel::where('module', $name)->delete()) {
            $this->error('菜单删除失败，请重新卸载');
        }

        // 删除授权信息
        if (false === Db::name('admin_access')->where('module', $name)->delete()) {
            $this->error('删除授权信息失败，请重新卸载');
        }

        // 删除行为规则
        if (false === Db::name('admin_action')->where('module', $name)->delete()) {
            $this->error('删除行为信息失败，请重新卸载');
        }

        // 删除模块信息
        if (ModuleModel::where('name', $name)->delete()) {
            // 复制静态资源目录
            File::copy_dir(ROOT_PATH . 'public/static/' . $name, APP_PATH . $name . '/public/static/' . $name);
            // 删除静态资源目录
            File::del_dir(ROOT_PATH . 'public/static/' . $name);
            cache('modules', null);
            cache('module_all', null);
            // 记录行为
            action_log('module_uninstall', 'admin_module', 0, UID, $module_info['title']);
            $this->success('模块卸载成功', 'index');
        } else {
            $this->error('模块卸载失败');
        }
    }

    /**
     * 更新模块配置
     * @param string $name 模块名
     * @author 无名氏
     */
    public function update($name = '')
    {
        $name == '' && $this->error('缺少模块名！');

        $Module = ModuleModel::get(['name' => $name]);
        !$Module && $this->error('模块不存在，或未安装');

        // 模块配置信息
        $module_info = ModuleModel::getInfoFromFile($name);
        unset($module_info['name']);

        // 检查是否有模块设置信息
        if (isset($module_info['config']) && !empty($module_info['config'])) {
            $module_info['config'] = json_encode(parse_config($module_info['config']));
        } else {
            $module_info['config'] = '';
        }

        // 检查是否有模块授权配置
        if (isset($module_info['access']) && !empty($module_info['access'])) {
            $module_info['access'] = json_encode($module_info['access']);
        } else {
            $module_info['access'] = '';
        }

        // 更新模块信息
        if (false !== $Module->save($module_info)) {
            $this->success('模块配置更新成功');
        } else {
            $this->error('模块配置更新失败，请重试');
        }
    }

    /**
     * 导出模块
     * @param string $name 模块名
     * @author 无名氏
     * @return mixed
     */
    public function export($name = '')
    {
        if ($name == '') $this->error('缺少模块名');

        $export_data = $this->request->get('export_data', '');
        if ($export_data == '') {
            $this->assign('page_title', '导出模块：' . $name);
            return $this->fetch();
        }

        // 模块导出目录
        $module_dir = ROOT_PATH . 'export/module/' . $name;

        // 删除旧的导出数据
        if (is_dir($module_dir)) {
            File::del_dir($module_dir);
        }

        // 复制模块目录到导出目录
        File::copy_dir(APP_PATH . $name, $module_dir);
        // 复制静态资源目录
        File::copy_dir(ROOT_PATH . 'public/static/' . $name, $module_dir . '/public/static/' . $name);

        // 模块本地配置信息
        $module_info = ModuleModel::getInfoFromFile($name);

        // 检查是否有模块设置信息
        if (isset($module_info['config'])) {
            $db_config = ModuleModel::where('name', $name)->value('config');
            $db_config = json_decode($db_config, true);
            // 获取最新的模块设置信息
            $module_info['config'] = set_config_value($module_info['config'], $db_config);
        }

        // 检查是否有模块行为信息
        $action = Db::name('admin_action')->where('module', $name)->field('module,name,title,remark,rule,log,status')->select();
        if ($action) {
            $module_info['action'] = $action;
        }

        // 表前缀
        $module_info['database_prefix'] = config('database.prefix');

        // 生成配置文件
        if (false === $this->buildInfoFile($module_info, $name)) {
            $this->error('模块配置文件创建失败，请重新导出');
        }

        // 获取模型菜单并导出
        $fields = 'id,pid,title,icon,url_type,url_value,url_target,online_hide,sort,status';
        $menus = MenuModel::getMenusByGroup($name, $fields);
        if (false === $this->buildMenuFile($menus, $name)) {
            $this->error('模型菜单文件创建失败，请重新导出');
        }

        // 导出数据库表
        if (isset($module_info['tables']) && !empty($module_info['tables'])) {
            if (!is_dir($module_dir . '/sql')) {
                mkdir($module_dir . '/sql', 644, true);
            }
            if (!Database::export($module_info['tables'], $module_dir . '/sql/install.sql', config('database.prefix'), $export_data)) {
                $this->error('数据库文件创建失败，请重新导出');
            }
            if (!Database::exportUninstall($module_info['tables'], $module_dir . '/sql/uninstall.sql', config('database.prefix'))) {
                $this->error('数据库文件创建失败，请重新导出');
            }
        }

        // 记录行为
        action_log('module_export', 'admin_module', 0, UID, $module_info['title']);

        // 打包下载
        $archive = new PHPZip;
        return $archive->ZipAndDownload($module_dir, $name);
    }

    /**
     * 创建模块菜单文件
     * @param array $menus 菜单
     * @param string $name 模块名
     * @author 无名氏
     * @return int
     */
    private function buildMenuFile($menus = [], $name = '')
    {
        $menus = Tree::toLayer($menus);

        // 美化数组格式
        $menus = var_export($menus, true);
        $menus = preg_replace("/(\d+|'id'|'pid') =>(.*)/", '', $menus);
        $menus = preg_replace("/'child' => (.*)(\r\n|\r|\n)\s*array/", "'child' => $1array", $menus);
        $menus = str_replace(['array (', ')'], ['[', ']'], $menus);
        $menus = preg_replace("/(\s*?\r?\n\s*?)+/", "\n", $menus);

        $content = <<<INFO
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

/**
 * 菜单信息
 */
return {$menus};

INFO;
        // 写入到文件
        return file_put_contents(ROOT_PATH . 'export/module/' . $name . '/menus.php', $content);
    }

    /**
     * 创建模块配置文件
     * @param array $info 模块配置信息
     * @param string $name 模块名
     * @author 无名氏
     * @return int
     */
    private function buildInfoFile($info = [], $name = '')
    {
        // 美化数组格式
        $info = var_export($info, true);
        $info = preg_replace("/'(.*)' => (.*)(\r\n|\r|\n)\s*array/", "'$1' => array", $info);
        $info = preg_replace("/(\d+) => (\s*)(\r\n|\r|\n)\s*array/", "array", $info);
        $info = preg_replace("/(\d+ => )/", "", $info);
        $info = preg_replace("/array \((\r\n|\r|\n)\s*\)/", "[)", $info);
        $info = preg_replace("/array \(/", "[", $info);
        $info = preg_replace("/\)/", "]", $info);

        $content = <<<INFO
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

/**
 * 模块信息
 */
return {$info};

INFO;
        // 写入到文件
        return file_put_contents(ROOT_PATH . 'export/module/' . $name . '/info.php', $content);
    }

    /**
     * 设置状态
     * @param string $type 类型：disable/enable
     * @param array $record 行为日志内容
     * @author 无名氏
     * @return void
     */
    public function setStatus($type = '', $record = [])
    {
        $ids = input('param.ids');
        empty($ids) && $this->error('缺少主键');

        $module = ModuleModel::where('id', $ids)->find();
        $module['system_module'] == 1 && $this->error('禁止操作系统内置模块');

        $status = $type == 'enable' ? 1 : 0;

        // 将模块对应的菜单禁用或启用
        $map = [
            'pid' => 0,
            'module' => $module['name']
        ];
        MenuModel::where($map)->setField('status', $status);

        if (false !== ModuleModel::where('id', $ids)->setField('status', $status)) {
            // 记录日志
            call_user_func_array('action_log', ['module_' . $type, 'admin_module', 0, UID, $module['title']]);
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    /**
     * 禁用模块
     * @param array $record 行为日志内容
     * @author 无名氏
     * @return void
     */
    public function disable($record = [])
    {
        $this->setStatus('disable');
    }

    /**
     * 启用模块
     * @param array $record 行为日志内容
     * @author 无名氏
     * @return void
     */
    public function enable($record = [])
    {
        $this->setStatus('enable');
    }

    /**
     * 添加模型菜单
     * @param array $menus 菜单
     * @param string $module 模型名称
     * @param int $pid 父级ID
     * @author 无名氏
     * @return bool
     */
    private function addMenus($menus = [], $module = '', $pid = 0)
    {
        foreach ($menus as $menu) {
            $data = [
                'pid' => $pid,
                'module' => $module,
                'title' => $menu['title'],
                'icon' => isset($menu['icon']) ? $menu['icon'] : 'fa fa-fw fa-puzzle-piece',
                'url_type' => isset($menu['url_type']) ? $menu['url_type'] : 'module_admin',
                'url_value' => isset($menu['url_value']) ? $menu['url_value'] : '',
                'url_target' => isset($menu['url_target']) ? $menu['url_target'] : '_self',
                'online_hide' => isset($menu['online_hide']) ? $menu['online_hide'] : 0,
                'status' => isset($menu['status']) ? $menu['status'] : 1
            ];

            $result = MenuModel::create($data);

            if (!$result) return false;

            if (isset($menu['child'])) {
                $this->addMenus($menu['child'], $module, $result['id']);
            }
        }

        return true;
    }

    /**
     * 检查依赖
     * @param string $type 类型：module/plugin
     * @param array $data 检查数据
     * @author 无名氏
     * @return array
     */
    private function checkDependence($type = '', $data = [])
    {
        $need = [];
        foreach ($data as $key => $value) {
            if (!isset($value[3])) {
                $value[3] = '=';
            }
            // 当前版本
            if ($type == 'module') {
                $curr_version = ModuleModel::where('identifier', $value[1])->value('version');
            } else {
                $curr_version = PluginModel::where('identifier', $value[1])->value('version');
            }

            // 比对版本
            $result = version_compare($curr_version, $value[2], $value[3]);
            $need[$key] = [
                $type => $value[0],
                'identifier' => $value[1],
                'version' => $curr_version ? $curr_version : '未安装',
                'version_need' => $value[3] . $value[2],
                'result' => $result ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>'
            ];
        }

        return $need;
    }


    public function add(){
        if ($this->request->isPost()) {
            $data = $this->request->post();
            //先生成文件目录
            $name = $data['name'];
            //判断模块是否存在
            $dataINfo = Db::name('admin_module')->where('name','=',$name)->value('name');
            if($dataINfo){
                $this->error('模块已存在');
            }
            $fileTrue = AutomaticGeneration($name);
            if ($fileTrue === false) {
                $this->error('生成文件目录失败');
            }
            $table = $data['tags'];
            $datas = explode(',', $table);
            $data_count = count($datas);
            for ($i = 0; $i < $data_count; $i++) {
                $infoname =config('database.prefix').$name.'_'.$datas[$i];
                $dataq[$i] = $infoname;
                //生成数据表固定字段
                AutomaticGenerationOfDataTables($datas[$i],$name);
                $strtolower[$i] = strtolower(convertUnderline($datas[$i]));
                $strtolowerArray[$i] = [
                    'title' => $strtolower[$i],
                    'icon' => '',
                    'url_type' => 'module_admin',
                    'url_value' => $name.'/'.$strtolower[$i].'/index',
                    'url_target' => '_self',
                    'online_hide' => 0,
                    'sort' => 100,
                    'status' => 1,
                    'child' => [
                        [
                            'title' => '新增',
                            'icon' => '',
                            'url_type' => 'module_admin',
                            'url_value' => $name.'/'.$strtolower[$i].'/add',
                            'url_target' => '_self',
                            'online_hide' => 0,
                            'sort' => 100,
                            'status' => 0,
                        ],
                        [
                            'title' => '编辑',
                            'icon' => '',
                            'url_type' => 'module_admin',
                            'url_value' => $name.'/'.$strtolower[$i].'/edit',
                            'url_target' => '_self',
                            'online_hide' => 0,
                            'sort' => 100,
                            'status' => 0,
                        ],
                        [
                            'title' => '删除',
                            'icon' => '',
                            'url_type' => 'module_admin',
                            'url_value' => $name.'/'.$strtolower[$i].'/delete',
                            'url_target' => '_self',
                            'online_hide' => 0,
                            'sort' => 100,
                            'status' => 0,
                        ],
                    ],
                ];
            }
            //dump('2222');die;
            //生成info和menus文件
            $info = [
                // 模块名[必填]
                'name' => $name,
                // 模块标题[必填]
                'title' => $data['title'],
                // 模块唯一标识[必填]，格式：模块名.开发者标识.module
                'identifier' => $data['identifier'],
                // 模块图标[选填]
                'icon' => $data['icon'],
                // 模块描述[选填]
                'description' => $data['description'],
                // 开发者[必填]
                'author' => $data['author'],
                // 开发者网址[选填]
                'author_url' => $data['author_url'],
                // 版本[必填],格式采用三段式：主版本号.次版本号.修订版本号
                'version' => $data['version'],
                // 模块依赖[可选]，格式[[模块名, 模块唯一标识, 依赖版本, 对比方式]]
                'need_module' => [
                    ['admin', 'admin.dolphinphp.module', '1.0.0'],
                    //['admin', $data['identifier'], $data['version']]
                ],
                //// 数据表[有数据库表时必填]

                'tables' =>$dataq,
            ];
            //生成info文件内容
            buildInfoFile($info,$name);
            //生成menus文件内容
            $menu2 =[
                [
                    'title' => '新增',
                    'icon' => '',
                    'url_type' => 'module_admin',
                    'url_value' => $name.'/index/add',
                    'url_target' => '_self',
                    'online_hide' => 0,
                    'sort' => 100,
                    'status' => 0,
                ],
                [
                    'title' => '编辑',
                    'icon' => '',
                    'url_type' => 'module_admin',
                    'url_value' => $name.'/index/edit',
                    'url_target' => '_self',
                    'online_hide' => 0,
                    'sort' => 100,
                    'status' => 0,
                ],
                [
                    'title' => '删除',
                    'icon' => '',
                    'url_type' => 'module_admin',
                    'url_value' => $name.'/index/delete',
                    'url_target' => '_self',
                    'online_hide' => 0,
                    'sort' => 100,
                    'status' => 0,
                ],
                [
                    'title' => '参数配置',
                    'icon' => '',
                    'url_type' => 'module_admin',
                    'url_value' => $name.'/index/getConfigureList',
                    'url_target' => '_self',
                    'online_hide' => 0,
                    'sort' => 100,
                    'status' => 0,
                ],
            ];
			$menu1 = array_merge($menu2,$strtolowerArray);

            $menus = [[
                'title' => $data['title'],
                'icon' => 'fa fa-fw fa-newspaper-o',
                'url_type' => 'module_admin',
                'url_value' => $name.'/index/index',
                'url_target' => '_self',
                'online_hide' => 0,
                'sort' => 100,
                'child' => [
					[
						'title' => '模型管理',
						'icon' => '',
						'url_type' => 'module_admin',
						'url_value' => $name.'/index/index',
						'url_target' => '_self',
						'online_hide' => 0,
						'sort' => 100,
						'status' => 1,
						'child' => $menu1,
                ]],]];

            buildMenuFile($menus,$name);

            //根据数据表名生成文件
            GenerateFile($table,$name);
			$this->success('生成成功,请去安装','index');
            //插入module表中
//            $dataadd = ['name'=>$data['name'],'title'=>$data['title'],'icon'=>$data['icon'],'description'=>$data['description'],'author'=>$data['author'],'author_url'=>$data['author_url'],'version'=>$data['version'],'identifier'=>$data['identifier'],'system_module'=>$data['system_module']];
//            $dataAddinfo = Db::table('cj_admin_module')->insert($dataadd);
//            if($dataAddinf
//o){
//                $this->success('添加成功','index');
//                //生成菜单链接
//
//            }else{
//                $this->error('添加失败');
//            }
        }
        $dataList = Db::table('cj_admin_module')->column('title');
		$type_tips = '此选项添加后不可更改。如果为 <code>系统模型</code> 将禁止删除，对于 <code>独立模型</code>，将强制创建字段id,create_time,update_time';

		// 使用ZBuilder构建表单页面，并将页面标题设置为“添加”
        return ZBuilder::make('form')->setPageTitle('添加')->setPageTips($type_tips.'添加需要的模块', 'danger')
            ->addFormItems([
                ['text', 'name', '模块名称（标识）','由小写字母、数字或下划线组成，不能以数字开头'],
                ['text', 'title', '模块标题','有中文组成'],
                ['icon', 'icon', '选择图标'],
                ['text', 'description', '描述'],
                ['text', 'author', '作者','例如 : 小马哥'],
                ['text', 'author_url', '作者主页','例如 : www.baidu.com'],
                //['text', 'config', '配置信息'],
                //['text', 'access', '授权配置'],
                ['text', 'version', '版本号','例如 : 1.0.0'],
                ['text', 'identifier', '模块唯一标识符','模块.标识.module'],
                ['radio', 'system_module', '是否为系统模块', '', $dataList, 0],
                ['tags', 'tags', '数据库表','创建后不可更改。由小写字母、数字或下划线组成，如果不填写默认为 <code>'. config('database.prefix') . '_模型标识_表名</code>，如果需要自定义，请务必填写系统表前缀，<code>#@__</code>表示当前系统表前缀'],
            ])->setBtnTitle(['submit' => '确定', 'back' => '返回前一页'])
            ->setBtnTitle()->fetch();
    }
}