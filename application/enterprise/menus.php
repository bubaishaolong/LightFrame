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
    'title' => '企业站点',
    'icon' => 'fa fa-fw fa-newspaper-o',
    'url_type' => 'module_admin',
    'url_value' => 'enterprise/index/index',
    'url_target' => '_self',
    'online_hide' => 0,
    'sort' => 100,
    'child' => [
      [
        'title' => '模型管理',
        'icon' => '',
        'url_type' => 'module_admin',
        'url_value' => 'enterprise/index/index',
        'url_target' => '_self',
        'online_hide' => 0,
        'sort' => 100,
        'status' => 1,
        'child' => [
          [
            'title' => '新增',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'enterprise/index/add',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
          [
            'title' => '编辑',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'enterprise/index/edit',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
          [
            'title' => '删除',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'enterprise/index/delete',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
          [
            'title' => '参数配置',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'enterprise/index/getConfigureList',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 0,
          ],
          [
            'title' => 'setting',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'enterprise/setting/index',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 1,
            'child' => [
              [
                'title' => '新增',
                'icon' => '',
                'url_type' => 'module_admin',
                'url_value' => 'enterprise/setting/add',
                'url_target' => '_self',
                'online_hide' => 0,
                'sort' => 100,
                'status' => 0,
              ],
              [
                'title' => '编辑',
                'icon' => '',
                'url_type' => 'module_admin',
                'url_value' => 'enterprise/setting/edit',
                'url_target' => '_self',
                'online_hide' => 0,
                'sort' => 100,
                'status' => 0,
              ],
              [
                'title' => '删除',
                'icon' => '',
                'url_type' => 'module_admin',
                'url_value' => 'enterprise/setting/delete',
                'url_target' => '_self',
                'online_hide' => 0,
                'sort' => 100,
                'status' => 0,
              ],
            ],
          ],
          [
            'title' => 'adv',
            'icon' => '',
            'url_type' => 'module_admin',
            'url_value' => 'enterprise/adv/index',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'status' => 1,
            'child' => [
              [
                'title' => '新增',
                'icon' => '',
                'url_type' => 'module_admin',
                'url_value' => 'enterprise/adv/add',
                'url_target' => '_self',
                'online_hide' => 0,
                'sort' => 100,
                'status' => 0,
              ],
              [
                'title' => '编辑',
                'icon' => '',
                'url_type' => 'module_admin',
                'url_value' => 'enterprise/adv/edit',
                'url_target' => '_self',
                'online_hide' => 0,
                'sort' => 100,
                'status' => 0,
              ],
              [
                'title' => '删除',
                'icon' => '',
                'url_type' => 'module_admin',
                'url_value' => 'enterprise/adv/delete',
                'url_target' => '_self',
                'online_hide' => 0,
                'sort' => 100,
                'status' => 0,
              ],
            ],
          ],
        ],
      ],
    ],
  ],
];
