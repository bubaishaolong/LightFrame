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
return [
  'name' => 'shop',
  'title' => '商城',
  'identifier' => 'shop.caijion.module',
  'icon' => '',
  'description' => '的萨达萨达sad',
  'author' => ' 的sad',
  'author_url' => '大的',
  'version' => '1.0.0.2',
  'need_module' => [
    [
      'admin',
      'admin.dolphinphp.module',
      '1.0.0',
    ],
  ],
  'tables' => [
    'cj_shop_goods',
  ],
  'database_prefix' => 'cj_',
];
