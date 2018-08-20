<?php

namespace form\select2ajax;

class Builder
{
    /**
     * 取色器
     * @param string $name 表单项名
     * @param string $title 标题
     * @param string $tips 提示
     * @param string $default 默认值
     * @param string $mode 模式：默认为rgba(含透明度)，也可以是rgb
     * @param string $ajax_url ajax_url
     * @param string $param 额外参数
     * @author yangweijie <917647288@qq.com>
     * @return mixed
     */
    public function item($name = '', $title = '', $tips = '', $options = [], $default = '',$ajax_url, $param = '')
    {
        return [
            'name'     => $name,
            'title'    => $title,
            'tips'     => $tips,
            'value'    => $default,
            'options'  => $options,
            'ajax_url' => $ajax_url,
            'param'    => $param == '' ? $name: $param,
        ];
    }

    /**
     * @var array 需要加载的js
     */
    public $js = [
        '../../../public/static/libs/select2/select2.full.min.js',
        '../../../public/static/libs/select2/i18n/zh-CN.js',
        'init.js'
    ];

    /**
     * @var array 需要加载的css
     */
    public $css = [
        '../../../public/static/libs/select2/select2.min.css',
        '../../../public/static/libs/select2/select2-bootstrap.min.css',
    ];
}