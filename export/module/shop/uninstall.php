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
use think\Db;
use think\Exception;

// 是否清除数据
$clear = $this->request->get('clear');

if ($clear == 1) {
    // 内容模型的表名列表
    $table_list = Db::name('shop_model')->value('table');

    if ($table_list) {
        foreach ($table_list as $table) {
            // 删除内容模型表
            $sql = 'DROP TABLE IF EXISTS `'.$table.'`;';
            try {
                Db::execute($sql);
            } catch (\Exception $e) {
                throw new Exception('删除表：'.$table.' 失败！', 1001);
            }
        }
    }
}