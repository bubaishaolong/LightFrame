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

use app\common\builder\ZBuilder;
use app\admin\model\Model as ModelModel;
use app\admin\model\Field as FieldModel;
use think\Db;
use think\Request;

/**
 * 字段管理控制器
 * @package
 */
class Field extends Admin
{
    /**
     * 字段列表
     * @param null $id 文档模型id
     * @author 无名氏
     * 校验   排序  过滤  搜索  合计
     *校验类型配置示例：（多个组合之间可用 | 分隔）
     * 必填：require
     * 只能英文字符：regex:^[a-zA-Z]\w{0,39}$
     * 是否为字母：alpha
     * 是否为字母和数字：alphaNum
     * 是否为字母和数字，下划线_及破折号-：alphaDash
     * 是否为有效的域名或者IP：activeUrl
     * 是否为有效IP(支持验证ipv4和ipv6)：ip
     * 是否为指定格式的日期：dateFormat:y-m-d
     * 是否在某个日期之后：after:2016-3-18
     * 是否在某个日期之前：before:2016-10-01
     * 是否在某个有效日期之内：expire:2016-2-1,2016-10-01
     * 是否在这些数据中：in:1,2,3
     * 是否不在这些数据中：notIn:1,2,3
     * 只能是数字：number
     * 只能是数字：integer
     * 浮点数字：float
     * 布尔值：boolean
     * 是否为数组：array
     * 是否为为 yes, on, 或是 1：accepted
     * 是否为有效的日期：date
     * url：url
     * Email：email
     * 最大字符长度限制：max:20
     * 最小字符长度限制：min:5
     * 长度限制：length:1,80
     * 必须输入4个字：length:4
     * 数字在这个区间：between:1,120
     * 数字不在这个区间：notBetween:1,120
     * 固定值：unique:jzt
     * 是否和另外一个字段的值一致：confirm:password
     * 是否和另外一个字段的值不一致：different:account
     * 大于等于：>=:100 或者 egt:100
     * 小于等于：<=:100 或者 elt:100
     * 小于：<:100 或者 lt:100
     * 大于：>:100 或者 gt:100
     * 等于：=:100 或者 eq:100 或者 same:100
     * 正则验证：regex:\d{6}
     * 关联字段必须：requireIf:field,value
     * 比如 //当account的值等于1的时候 password必须 "password"=>"requireIf:account,1"
     * 关联字段必须：requireWith:field
     * 比如 //当account有值的时候password字段必须 "password"=>"requireWith:account"
     */
    public function index($id = null)
    {
        $id === null && $this->error('参数错误');
        cookie('__forward__', $_SERVER['REQUEST_URI']);

        // 查询
        $map = $this->getMap();
        $map['model'] = $id;
        // 数据列表
        $data_list = FieldModel::where($map)->order('id desc')->paginate();
        $modeldata = ModelModel::where(array('id' => $id))->column('name');
        $modeltable = ModelModel::where(array('id' => $id))->column('table');
        // 授权按钮
        $btn_access = [
            'title' => '生成校验规则',
            'icon' => 'fa fa-fw fa-key',
            'href' => url('admin/field/field_checkout', ['model' =>$id])
        ];
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['name' => '名称', 'title' => '标题'])// 设置搜索框
            ->setPageTips('【显示】表示新增或编辑文档时是否显示该字段<br>【启用】表示前台是否显示<br>注意 : ID是主键不能删除,不然数据表在查询的时候会报错<br><button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#collapse_zz" aria-expanded="false" aria-controls="collapse_zz">查看验证规则</button><div class="collapse" id="collapse_zz" aria-expanded="false" style="height: 0px;">     校验类型配置示例：（多个组合之间可用 | 分隔）<br>
            &nbsp;&nbsp;必填：<span style="color:red;">require</span><br>
            &nbsp;&nbsp;只能英文字符：<span style="color:red;">regex:^[a-zA-Z]\w{0,39}$</span><br>
            &nbsp;&nbsp;是否为字母：<span style="color:red;">alpha</span><br>
            &nbsp;&nbsp;是否为字母和数字：<span style="color:red;">alphaNum</span><br>
            &nbsp;&nbsp;是否为字母和数字，下划线_及破折号-：<span style="color:red;">alphaDash</span><br>
            &nbsp;&nbsp;是否为有效的域名或者IP：<span style="color:red;">activeUrl</span><br>
            &nbsp;&nbsp;是否为有效IP(支持验证ipv4和ipv6)：<span style="color:red;">ip</span><br>
            &nbsp;&nbsp;是否为指定格式的日期：<span style="color:red;">dateFormat:y-m-d</span><br>
            &nbsp;&nbsp;是否在某个日期之后：<span style="color:red;">after:2016-3-18</span><br>
            &nbsp;&nbsp;是否在某个日期之前：<span style="color:red;">before:2016-10-01</span><br>
            &nbsp;&nbsp;是否在某个有效日期之内：<span style="color:red;">expire:2016-2-1,2016-10-01</span><br>
            &nbsp;&nbsp;是否在这些数据中：<span style="color:red;">in:1,2,3</span><br>
            &nbsp;&nbsp;是否不在这些数据中：<span style="color:red;">notIn:1,2,3</span><br>
            &nbsp;&nbsp;只能是数字：<span style="color:red;">number</span><br>
            &nbsp;&nbsp;只能是数字：<span style="color:red;">integer</span><br>
            &nbsp;&nbsp;浮点数字：<span style="color:red;">float</span><br>
            &nbsp;&nbsp;布尔值：<span style="color:red;">boolean</span><br>
            &nbsp;&nbsp;是否为数组：<span style="color:red;">array</span><br>
            &nbsp;&nbsp;是否为为 yes, on, 或是 1：<span style="color:red;">accepted</span><br>
            &nbsp;&nbsp;是否为有效的日期：<span style="color:red;">date</span><br>
            &nbsp;&nbsp;url：<span style="color:red;">url</span><br>
            &nbsp;&nbsp;Email：<span style="color:red;">email</span><br>
            &nbsp;&nbsp;最大字符长度限制：<span style="color:red;">max:20</span><br>
            &nbsp;&nbsp;最小字符长度限制：<span style="color:red;">min:5</span><br>
            &nbsp;&nbsp;长度限制：<span style="color:red;">length:1,80</span><br>
            &nbsp;&nbsp;必须输入4个字：<span style="color:red;">length:4</span><br>
            &nbsp;&nbsp;数字在这个区间：<span style="color:red;">between:1,120</span><br>
            &nbsp;&nbsp;数字不在这个区间：<span style="color:red;">notBetween:1,120</span><br>
            &nbsp;&nbsp;固定值：<span style="color:red;">unique:jzt</span><br>
            &nbsp;&nbsp;是否和另外一个字段的值一致：<span style="color:red;">confirm:password</span><br>
            &nbsp;&nbsp;是否和另外一个字段的值不一致：<span style="color:red;">different:account</span><br>
            &nbsp;&nbsp;大于等于：<span style="color:red;">&gt;=:100 或者 egt:100</span><br>
            &nbsp;&nbsp;小于等于：<span style="color:red;">&lt;=:100 或者 elt:100</span><br>
            &nbsp;&nbsp;小于：<span style="color:red;">&lt;:100 或者 lt:100</span><br>
            &nbsp;&nbsp;大于：<span style="color:red;">&gt;:100 或者 gt:100</span><br>
            &nbsp;&nbsp;等于：<span style="color:red;">=:100 或者 eq:100 或者 same:100</span><br>
            &nbsp;&nbsp;正则验证：<span style="color:red;">regex:\d{6}</span><br>
            &nbsp;&nbsp;关联字段必须：<span style="color:red;">requireIf:field,value</span><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;比如  //当account的值等于1的时候 password必须 "password"=&gt;"requireIf:account,1"<br>
            &nbsp;&nbsp;关联字段必须：<span style="color:red;">requireWith:field</span><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;比如  //当account有值的时候password字段必须 "password"=&gt;"requireWith:account"<br>
    </div>')
            ->setPageTitle($modeltable[0] . '表字段添加')
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['name', '名称'],
                ['title', '标题'],
                ['type', '类型', 'text', '', config('form_item_type')],
                ['create_time', '创建时间', 'datetime'],
                ['sort', '排序', 'text.edit'],
                ['data_type', '数据类型', 'select', config('database_data_type')],
                ['length', '数据长度', 'text.edit'],
                ['value', '默认值', 'text.edit'],
                ['is_null', '是否为空', 'switch'],
                ['new_type', '新增类型', 'select', config('form_item_type')],
                ['edit_type', '编辑类型', 'select', config('form_item_type')],
                ['list_type', '列表类型', 'select', config('form_item_type')],
                ['field_check', '校验', 'textarea.edit'],
                ['show', '显示', 'switch'],
                ['is_search', '搜索', 'switch'],
                ['status', '启用', 'switch'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButton('back', ['href' => url($modeldata[0] . '/databasetable/index')])// 批量添加顶部按钮
            ->addTopButton('add', ['href' => url('add', ['model' => $id])])// 添加顶部按钮
            ->addTopButton('custom', $btn_access)
            // ->addTopButtons('enable,disable') // 批量添加顶部按钮
            ->addRightButton('delete', ['href' => url('delete', ['model' => $id, 'ids' => '__id__'])])// 批量添加右侧按钮
            ->addRightButton('edit', ['href' => url('edit', ['id' => '__id__', 'model' => $id])])// 批量添加右侧按钮
            ->replaceRightButton(['fixed' => 1], '<button class="btn btn-danger btn-xs" type="button" disabled>固定字段禁止操作</button>')
            ->setRowList($data_list)// 设置表格数据
            ->fetch(); // 渲染模板


    }


    /**
     * 新增字段
     * @param string $model 文档模型id
     * @author 无名氏
     * @return mixed
     */
    public function add($model = '')
    {
        // 内容模型类别[0-系统，1-普通，2-独立]
        $model_type = ($model);

        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            // 非独立模型需验证字段名称是否为aid
            if ($model_type != 2) {
                // 非独立模型需验证新增的字段是否被系统占用
                if ($data['name'] == 'id' || is_default_field($data['name'])) {
                    $this->error('字段名称已存在');
                }
            }

            $result = $this->validate($data, 'Field');
            if (true !== $result) $this->error($result);
            // 如果是快速联动
            switch ($data['type']) {
                case 'linkages':
                    $data['key'] = $data['key'] == '' ? 'id' : $data['key'];
                    $data['pid'] = $data['pid'] == '' ? 'pid' : $data['pid'];
                    $data['level'] = $data['level'] == '' ? '2' : $data['level'];
                    $data['option'] = $data['option'] == '' ? 'name' : $data['option'];
                    break;
                case 'number':
                    $data['type'] = 'text';
                    break;
                case 'bmap':
                    $data['level'] = !$data['level'] ? 12 : $data['level'];
                    break;
            }
            if ($data['is_null'] == 0) {
                $datas = 'NOT NULL';
            } elseif ($data['is_null'] == 1) {
                $datas = 'NULL';
            }
            $data['define'] = $data['data_type'] . '(' . $data['length'] . ')  ' . $datas;
            if ($data['is_require'] == 0) {
                $data['field_check'] = 'max:' . $data['length'];
            } elseif ($data['is_require'] == 1) {
                $data['field_check'] = 'require|max:' . $data['length'];
            }
            //完成验证消掉这个值
            unset($data['is_require']);
            //把验证规则写入相对应的文件验证器


            if ($field = FieldModel::create($data)) {
                $FieldModel = new FieldModel();
                // 添加字段
                if ($FieldModel->newField($data)) {
                    //记录行为
                    $details = '详情：文档模型(' . $data['model'] . ')、字段名称(' . $data['name'] . ')、字段标题(' . $data['title'] . ')、字段类型(' . $data['type'] . ')';
                    //action_log('field_add', 'admin_field', $field['id'], UID, $details);
                    // 清除缓存
                    cache('admin_system_fields', null);
                    $this->success('新增成功', 'index?id=' . $model);
                } else {
                    // 添加失败，删除新增的数据
                    FieldModel::destroy($field['id']);
                    $this->error($FieldModel->getError());
                }
            } else {
                $this->error('新增失败');
            }
        }

        if ($model_type != 2) {
            $field_exist = Db::name('admin_field')->where('model', 'in', [0, $model])->column('name');
        } else {
            $field_exist = ['id', 'create_time', 'update_time', 'delete_time', 'status'];
        }
        // 显示添加页面
        return ZBuilder::make('form')
            ->setPageTips('以下字段名称已存在，请不要建立同名的字段：<br>' . implode('、', $field_exist))
            ->addFormItems([
                ['hidden', 'model', $model],
                ['text', 'name', '字段名称', '由小写英文字母和下划线组成'],
                ['text', 'title', '字段标题', '可填写中文'],
                ['select', 'type', '字段类型', '', config('form_item_type')],
                ['select', 'data_type', '数据类型', '', config('database_data_type')],
                ['text', 'length', '字段长度', '', '11'],
                ['radio', 'is_null', '是否为空', '新增或编辑时是否显示该字段', ['不为空', '为空'], 0],
                //['text', 'define', '字段定义', '可根据实际需求自行填写或修改，但必须是正确的sql语法'],
                ['text', 'value', '字段默认值'],
                ['textarea', 'options', '额外选项', '用于单选、多选、下拉、联动等类型'],
                ['text', 'ajax_url', '异步请求地址', "如请求的地址是 <code>url('ajax/getCity')</code>，那么只需填写 <code>ajax/getCity</code>，或者直接填写以 <code>http</code>开头的url地址"],
                ['text', 'next_items', '下一级联动下拉框的表单名', "与当前有关联的下级联动下拉框名，多个用逗号隔开，如：area,other"],
                ['text', 'param', '请求参数名', "联动下拉框请求参数名，默认为配置名称"],
                ['text', 'level', '级别', '如果类型为【快速联动下拉框】则表示需要显示的级别数量，默认为2。如果类型为【百度地图】，则表示地图默认缩放级别，建议设置为12', 2],
                ['text', 'table', '表名', '要查询的表，里面必须含有id、name、pid三个字段，其中id和name字段可在下面重新定义'],
                ['text', 'pid', '父级id字段名', '即表中的父级ID字段名，如果表中的主键字段名为pid则可不填写'],
                ['text', 'key', '键字段名', '即表中的主键字段名，如果表中的主键字段名为id则可不填写'],
                ['text', 'option', '值字段名', '下拉菜单显示的字段名，如果表中的该字段名为name则可不填写'],
                ['text', 'ak', 'APPKEY', '百度编辑器APPKEY'],
                ['text', 'format', '格式'],
                ['textarea', 'tips', '字段说明', '字段补充说明'],
                ['radio', 'fixed', '是否为固定字段', '如果为 <code>固定字段</code> 则添加后不可修改', ['否', '是'], 0],
                ['radio', 'show', '是否显示', '新增或编辑时是否显示该字段', ['否', '是'], 1],
                ['radio', 'status', '立即启用', '', ['否', '是'], 1],
                ['radio', 'is_require', '是否必填', '', ['否', '是'], 0],
                ['text', 'sort', '排序', '', 100],
            ])
            ->setTrigger('type', 'linkage', 'ajax_url,next_items,param')
            ->setTrigger('type', 'linkages', 'table,pid,key,option')
            ->setTrigger('type', 'bmap', 'ak')
            ->setTrigger('type', 'linkages,bmap', 'level')
            ->setTrigger('type', 'masked,date,time,datetime', 'format')
            ->setTrigger('type', 'checkbox,radio,array,select,linkage,linkages', 'options')
            ->js('field')
            ->fetch();
    }

    /**
     * 编辑字段
     * @param null $id 字段id
     * @author 无名氏
     * @return mixed
     */
    public function edit($id = null, $model = '')
    {
        if ($id === null) $this->error('参数错误');

        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();

            // 验证
            $result = $this->validate($data, 'Field');
            if (true !== $result) $this->error($result);

            // 如果是快速联动
            if ($data['type'] == 'linkages') {
                $data['key'] = $data['key'] == '' ? 'id' : $data['key'];
                $data['pid'] = $data['pid'] == '' ? 'pid' : $data['pid'];
                $data['level'] = $data['level'] == '' ? '2' : $data['level'];
                $data['option'] = $data['option'] == '' ? 'name' : $data['option'];
            }
            // 如果是百度地图
            if ($data['type'] == 'bmap') {
                $data['level'] = !$data['level'] ? 12 : $data['level'];
            }
            if ($data['is_null'] == 0) {
                $data['is_null'] = 'not null';
            } elseif ($data['is_null'] == 1) {
                $data['is_null'] = 'null';
            }
            $data['define'] = $data['data_type'] . '(' . $data['length'] . ')  ' . $data['is_null'];
            // 更新字段信息
            $FieldModel = new FieldModel();
            if ($FieldModel->updateField($data)) {
                if ($FieldModel->isUpdate(true)->save($data)) {
                    // 记录行为
                    //action_log('field_edit', 'admin_field', $id, UID, $data['name']);
                    $this->success('字段更新成功', 'index?id=' . $model);
                }
            }
            $this->error('字段更新失败');
        }

        // 获取数据
        $info = FieldModel::get($id);

        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden', 'id'],
                ['hidden', 'model'],
                ['text', 'name', '字段名称', '由小写英文字母和下划线组成'],
                ['text', 'title', '字段标题', '可填写中文'],
                ['select', 'type', '字段类型', '', config('form_item_type')],
                ['select', 'data_type', '数据类型', '', config('database_data_type')],
                ['text', 'length', '字段长度', '', '11'],
                ['radio', 'is_null', '是否为空', '新增或编辑时是否显示该字段', ['不为空', '为空'], 0],
                // ['text', 'define', '字段定义', '可根据实际需求自行填写或修改，但必须是正确的sql语法'],
                ['text', 'value', '字段默认值'],
                ['textarea', 'options', '额外选项', '用于单选、多选、下拉、联动等类型'],
                ['text', 'ajax_url', '异步请求地址', "如请求的地址是 <code>url('ajax/getCity')</code>，那么只需填写 <code>ajax/getCity</code>，或者直接填写以 <code>http</code>开头的url地址"],
                ['text', 'next_items', '下一级联动下拉框的表单名', "与当前有关联的下级联动下拉框名，多个用逗号隔开，如：area,other"],
                ['text', 'param', '请求参数名', "联动下拉框请求参数名，默认为配置名称"],
                ['text', 'level', '级别', '如果类型为【快速联动下拉框】则表示需要显示的级别数量，默认为2。如果类型为【百度地图】，则表示地图默认缩放级别，建议设置为12'],
                ['text', 'table', '表名', '要查询的表，里面必须含有id、name、pid三个字段，其中id和name字段可在下面重新定义'],
                ['text', 'pid', '父级id字段名', '即表中的父级ID字段名，如果表中的主键字段名为pid则可不填写'],
                ['text', 'key', '键字段名', '即表中的主键字段名，如果表中的主键字段名为id则可不填写'],
                ['text', 'option', '值字段名', '下拉菜单显示的字段名，如果表中的该字段名为name则可不填写'],
                ['text', 'ak', 'APPKEY', '百度编辑器APPKEY'],
                ['text', 'format', '格式'],
                ['textarea', 'tips', '字段说明', '字段补充说明'],
                ['radio', 'show', '是否显示', '新增或编辑时是否显示该字段', ['否', '是']],
                ['radio', 'status', '立即启用', '', ['否', '是']],
                ['text', 'sort', '排序'],
            ])
            ->setTrigger('type', 'linkage', 'ajax_url,next_items,param')
            ->setTrigger('type', 'linkages', 'table,pid,key,option')
            ->setTrigger('type', 'bmap', 'ak')
            ->setTrigger('type', 'linkages,bmap', 'level')
            ->setTrigger('type', 'masked,date,time,datetime', 'format')
            ->setTrigger('type', 'checkbox,radio,array,select,linkage,linkages', 'options')
            ->js('field')
            ->setFormData($info)
            ->fetch();
    }

    /**
     * 删除字段
     * @param null $ids 字段id
     * @author 无名氏
     * @return mixed
     */
    public function delete($ids = null, $model = '')
    {
        if ($ids === null) $this->error('参数错误');
        $FieldModel = new FieldModel();
        $field = $FieldModel->where('id', $ids)->find();
        if ($FieldModel->deleteField($field)) {
            if ($FieldModel->where('id', $ids)->delete()) {
                // 记录行为
                //$details = '详情：文档模型('.get_model_title($field['model']).')、字段名称('.$field['name'].')、字段标题('.$field['title'].')、字段类型('.$field['type'].')';
                //action_log('field_delete', 'admin_field', $ids, UID, $details);
                $this->success('删除成功', 'index?id=' . $model);
            }
        }
        return $this->error('删除失败');
    }

    /**
     * 启用字段
     * @param array $record 行为日志
     * @author 无名氏
     * @return mixed
     */
    public function enable($record = [])
    {
        return $this->setStatus('enable');
    }

    /**
     * 禁用字段
     * @param array $record 行为日志
     * @author 无名氏
     * @return mixed
     */
    public function disable($record = [])
    {
        return $this->setStatus('disable');
    }

    /**
     * 设置字段状态：删除、禁用、启用
     * @param string $type 类型：enable/disable
     * @param array $record
     * @author 无名氏
     * @return mixed
     */
    public function setStatus($type = '', $record = [])
    {
        $request = Request::instance();
        $datas = $request->dispatch();
        $mashu = $datas['module'][0];
        $ids = $this->request->isPost() ? input('post.id/a') : input('param.id');
        $field_delete = is_array($ids) ? '' : $ids;
        $field_names = FieldModel::where('id', 'in', $ids)->column('name');
        return parent::setStatus($type, ['field_' . $type, $mashu . '_field', $field_delete, UID, implode('、', $field_names)]);
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
        $config = FieldModel::where('id', $id)->value($field);
        $details = '字段(' . $field . ')，原值(' . $config . ')，新值：(' . $value . ')';
        return parent::quickEdit(['field_edit', 'admin_field', $id, UID, $details]);
    }

    /**
     * @param string $model
     * 校验规则生成
     */
    public function field_checkout($model = '')
    {
        header("content-type:text/html;charset=utf-8");  //设置编码
        $dataModel = ModelModel::get($model);
        $modelname = $dataModel['name'];
        $modeltable = $dataModel['table'];
        //获取表的前缀
        $dataconf = config('database.prefix') . $modelname . '_';
        $datas = explode($dataconf, $modeltable);
        //获取到改模块的数据表的验证器文件名称
        $datahomevalidate = convertUnderline($datas[1]);
        //验证器的文件夹路径
        $datahomepathvalidate = APP_PATH . $modelname . '/validate/' . $datahomevalidate . '.php';
        $dataFiled = FieldModel::where(array('model'=>$model))->field('name,title,field_check')->select();
        if(!$dataFiled){
            $this->error('表不存在');
        }
        foreach ($dataFiled as $key=>$value){
            $dataArray[$value['name'].'|'.$value['title']] = $value['field_check'];

        }
        // 美化数组格式
        $dataArray = var_export($dataArray, true);
        $dataArray = preg_replace("/'(.*)' => (.*)(\r\n|\r|\n)\s*array/", "'$1' => array", $dataArray);
        $dataArray = preg_replace("/(\d+) => (\s*)(\r\n|\r|\n)\s*array/", "array", $dataArray);
        $dataArray = preg_replace("/(\d+ => )/", "", $dataArray);
        $dataArray = preg_replace("/array \((\r\n|\r|\n)\s*\)/", "[)", $dataArray);
        $dataArray = preg_replace("/array \(/", "[", $dataArray);
        $dataArray = preg_replace("/\)/", "]", $dataArray);
        //写入对应php文件
        $contentvalidate = <<<INFO
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
namespace app\\{$modelname}\\validate;

use think\Validate;

class  {$datahomevalidate} extends Validate
{
    //定义验证规则
    // 定义验证规则
    
   protected \$rule = {$dataArray};
    //定义验证提示
    protected \$message = [
        'name.regex' => '模型标识由小写字母、数字或下划线组成，不能以数字开头',
        'table.regex' => '附加表由小写字母、数字或下划线组成，不能以数字开头',
    ];

}
INFO;
        $file_put_contents = file_put_contents($datahomepathvalidate, $contentvalidate);
        if($file_put_contents){
            $this->success('规则生成成功');
        }

    }
}
