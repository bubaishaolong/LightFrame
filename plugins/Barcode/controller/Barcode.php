<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace plugins\Barcode\controller;

use app\common\controller\Common;
require_once(dirname(dirname(__FILE__))."/sdk/class/BCGColor.php");
require_once(dirname(dirname(__FILE__))."/sdk/class/BCGDrawing.php");
require_once(dirname(dirname(__FILE__))."/sdk/class/BCGFontFile.php");
require_once(dirname(dirname(__FILE__))."/sdk/class/BCGBarcode.php");
require_once(dirname(dirname(__FILE__))."/sdk/class/BCGcode128.barcode.php");

/**
 * 条形码控制器
 * @package plugins\Sms\controller
 */
class Barcode extends Common
{
    /**
     * 生成条形码
     * @param string $text 要生成的内容，只能为A-Za-z0-9
     * @param array $config 参数，与插件设置中的参数一致，可选。
     *  file_type - 图片类型
     *  dpi - dpi
     *  thickness - 厚度
     *  scale - 比例
     *  rotation - 旋转角度
     *  font_size - 字体大小
     * @author 蔡伟明 <314013107@qq.com>
     *
     * 示例：
     * plugin_action('Barcode/Barcode/generate', ['123', ['font_size' => 12,....]])
     */
    public function generate($text = '', $config = [])
    {
        // 插件配置参数
        $plugin_config = plugin_config('barcode');
        $plugin_config = array_merge($plugin_config, $config);

        $font        = new \BCGFontFile(dirname(dirname(__FILE__)).'/sdk/font/Arial.ttf', $plugin_config['font_size']);
        $color_black = new \BCGColor(0, 0, 0);
        $color_white = new \BCGColor(255, 255, 255);

        $drawException = null;
        $code = '';
        try {
            $code = new \BCGcode128();//实例化对应的编码格式
            $code->setScale($plugin_config['scale']); // Resolution
            $code->setThickness($plugin_config['thickness']); // Thickness
            $code->setForegroundColor($color_black); // Color of bars
            $code->setBackgroundColor($color_white); // Color of spaces
            $code->setFont($font); // Font (or 0)
            $code->parse($text);

        } catch(\Exception $exception) {
            $drawException = $exception;
        }

        $drawing = new \BCGDrawing('', $color_white);
        if($drawException) {
            $drawing->drawException($drawException);
        } else {
            $drawing->setBarcode($code);
            $drawing->setRotationAngle($plugin_config['rotation']);
            $drawing->setDPI($plugin_config['dpi'] === 'NULL' ? null : max(72, min(300, intval($plugin_config['dpi']))));
            $drawing->draw();
        }

        switch ($plugin_config['file_type']) {
            case 'PNG':
                header('Content-Type: image/png');
                break;
            case 'JPEG':
                header('Content-Type: image/jpeg');
                break;
            case 'GIF':
                header('Content-Type: image/gif');
                break;
        }

        $filetypes = [
            'PNG'  => \BCGDrawing::IMG_FORMAT_PNG,
            'JPEG' => \BCGDrawing::IMG_FORMAT_JPEG,
            'GIF'  => \BCGDrawing::IMG_FORMAT_GIF
        ];

        $drawing->finish($filetypes[$plugin_config['file_type']]);
    }

    /**
     * 显示错误图片
     * @author 蔡伟明 <314013107@qq.com>
     */
    private function showError() {
        header('Content-Type: image/png');
        readfile(dirname(dirname(__FILE__)).'/sdk/error.png');
        exit;
    }
}