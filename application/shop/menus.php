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

/**
 * 菜单信息
 */
return [
  [
    'title' => '商城',
    'icon' => 'fa fa-fw fa-newspaper-o',
    'url_type' => 'module_admin',
    'url_value' => 'shop/index/index',
    'url_target' => '_self',
    'online_hide' => 0,
    'sort' => 100,
    'child' => [
      [
        'title' => '模型管理',
        'icon' => '',
        'url_type' => 'module_admin',
        'url_value' => 'shop/Databasetable/index',
        'url_target' => '_self',
        'online_hide' => 0,
        'sort' => 100,
        'status' => 1,
        'child' => [
          [
            'title' => '新增',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'shop/Databasetable/add',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
          [
            'title' => '编辑',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'shop/Databasetable/edit',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
          [
            'title' => '删除',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'shop/Databasetable/delete',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
          [
            'title' => '字段管理',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'admin/field/index',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
            'child' => [
              [
                'title' => '新增',
                'icon' => '',
                'url_type' => 'module_admin',
                'url_value' => 'admin/field/add',
                'url_target' => '_self',
                'online_hide' => 0,
                'sort' => 100,
                'status' => 1,
              ],
              [
                'title' => '编辑',
                'icon' => '',
                'url_type' => 'module_admin',
                'url_value' => 'admin/field/edit',
                'url_target' => '_self',
                'online_hide' => 0,
                'sort' => 100,
                'status' => 1,
              ],
              [
                'title' => '删除',
                'icon' => '',
                'url_type' => 'module_admin',
                'url_value' => 'admin/field/delete',
                'url_target' => '_self',
                'online_hide' => 0,
                'sort' => 100,
                'status' => 1,
              ],
            ],
          ],
        ],
      ],
    ],
  ],
];
