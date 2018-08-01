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
return [
  [
    'title' => '商城',
    'icon' => 'fa fa-fw fa-newspaper-o',
    'url_type' => 'module_admin',
    'url_value' => 'shop/index/index',
    'url_target' => '_self',
    'online_hide' => 0,
    'sort' => 100,
    'status' => 1,
    'child' => [
      [
        'title' => '模型管理',
        'icon' => 'fa fa-fw fa-th-list',
        'url_type' => 'module_admin',
        'url_value' => 'shop/databasetable/index',
        'url_target' => '_self',
        'online_hide' => 0,
        'sort' => 100,
        'status' => 1,
        'child' => [
          [
            'title' => '新增',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'shop/databasetable/add',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
          [
            'title' => '编辑',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'shop/databasetable/edit',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
          [
            'title' => '删除',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'shop/databasetable/delete',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
          [
            'title' => '参数配置',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'shop/databasetable/getconfigurelist',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
        ],
      ],
      [
        'title' => '会员列表',
        'icon' => 'fa fa-fw fa-film',
        'url_type' => 'module_admin',
        'url_value' => 'shop/userlist/index',
        'url_target' => '_self',
        'online_hide' => 0,
        'sort' => 100,
        'status' => 1,
      ],
      [
        'title' => '会员管理',
        'icon' => 'fa fa-fw fa-repeat',
        'url_type' => 'module_admin',
        'url_value' => 'shop/menber/index',
        'url_target' => '_self',
        'online_hide' => 0,
        'sort' => 100,
        'status' => 1,
        'child' => [
          [
            'title' => '新增',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'shop/menber/add',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
          [
            'title' => '编辑',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'shop/userlist/edit',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 1,
          ],
        ],
      ],
      [
        'title' => '订单管理',
        'icon' => 'fa fa-fw fa-calendar',
        'url_type' => 'module_admin',
        'url_value' => 'shop/order/index',
        'url_target' => '_self',
        'online_hide' => 0,
        'sort' => 100,
        'status' => 1,
        'child' => [
          [
            'title' => '新增',
            'icon' => 'fa fa-fw fa-calendar',
            'url_type' => 'module_admin',
            'url_value' => 'shop/order/add',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
          [
            'title' => '编辑',
            'icon' => 'fa fa-fw fa-calendar',
            'url_type' => 'module_admin',
            'url_value' => 'shop/order/edit',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
          [
            'title' => '删除',
            'icon' => 'fa fa-fw fa-calendar',
            'url_type' => 'module_admin',
            'url_value' => 'shop/order/delete',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
        ],
      ],
    ],
  ],
];
