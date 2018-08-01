/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1_3306
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : dolphin

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-08-01 17:39:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cj_admin_access
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_access`;
CREATE TABLE `cj_admin_access` (
  `module` varchar(16) NOT NULL DEFAULT '' COMMENT '模型名称',
  `group` varchar(16) NOT NULL DEFAULT '' COMMENT '权限分组标识',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `nid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '授权节点id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='统一授权表';

-- ----------------------------
-- Records of cj_admin_access
-- ----------------------------

-- ----------------------------
-- Table structure for cj_admin_action
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_action`;
CREATE TABLE `cj_admin_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(16) NOT NULL DEFAULT '' COMMENT '所属模块名',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '行为标题',
  `remark` varchar(128) NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` text NOT NULL COMMENT '行为规则',
  `log` text NOT NULL COMMENT '日志规则',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=214 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统行为表';

-- ----------------------------
-- Records of cj_admin_action
-- ----------------------------
INSERT INTO `cj_admin_action` VALUES ('1', 'user', 'user_add', '添加用户', '添加用户', '', '[user|get_nickname] 添加了用户：[record|get_nickname]', '1', '1480156399', '1480163853');
INSERT INTO `cj_admin_action` VALUES ('2', 'user', 'user_edit', '编辑用户', '编辑用户', '', '[user|get_nickname] 编辑了用户：[details]', '1', '1480164578', '1480297748');
INSERT INTO `cj_admin_action` VALUES ('3', 'user', 'user_delete', '删除用户', '删除用户', '', '[user|get_nickname] 删除了用户：[details]', '1', '1480168582', '1480168616');
INSERT INTO `cj_admin_action` VALUES ('4', 'user', 'user_enable', '启用用户', '启用用户', '', '[user|get_nickname] 启用了用户：[details]', '1', '1480169185', '1480169185');
INSERT INTO `cj_admin_action` VALUES ('5', 'user', 'user_disable', '禁用用户', '禁用用户', '', '[user|get_nickname] 禁用了用户：[details]', '1', '1480169214', '1480170581');
INSERT INTO `cj_admin_action` VALUES ('6', 'user', 'user_access', '用户授权', '用户授权', '', '[user|get_nickname] 对用户：[record|get_nickname] 进行了授权操作。详情：[details]', '1', '1480221441', '1480221563');
INSERT INTO `cj_admin_action` VALUES ('7', 'user', 'role_add', '添加角色', '添加角色', '', '[user|get_nickname] 添加了角色：[details]', '1', '1480251473', '1480251473');
INSERT INTO `cj_admin_action` VALUES ('8', 'user', 'role_edit', '编辑角色', '编辑角色', '', '[user|get_nickname] 编辑了角色：[details]', '1', '1480252369', '1480252369');
INSERT INTO `cj_admin_action` VALUES ('9', 'user', 'role_delete', '删除角色', '删除角色', '', '[user|get_nickname] 删除了角色：[details]', '1', '1480252580', '1480252580');
INSERT INTO `cj_admin_action` VALUES ('10', 'user', 'role_enable', '启用角色', '启用角色', '', '[user|get_nickname] 启用了角色：[details]', '1', '1480252620', '1480252620');
INSERT INTO `cj_admin_action` VALUES ('11', 'user', 'role_disable', '禁用角色', '禁用角色', '', '[user|get_nickname] 禁用了角色：[details]', '1', '1480252651', '1480252651');
INSERT INTO `cj_admin_action` VALUES ('12', 'user', 'attachment_enable', '启用附件', '启用附件', '', '[user|get_nickname] 启用了附件：附件ID([details])', '1', '1480253226', '1480253332');
INSERT INTO `cj_admin_action` VALUES ('13', 'user', 'attachment_disable', '禁用附件', '禁用附件', '', '[user|get_nickname] 禁用了附件：附件ID([details])', '1', '1480253267', '1480253340');
INSERT INTO `cj_admin_action` VALUES ('14', 'user', 'attachment_delete', '删除附件', '删除附件', '', '[user|get_nickname] 删除了附件：附件ID([details])', '1', '1480253323', '1480253323');
INSERT INTO `cj_admin_action` VALUES ('15', 'admin', 'config_add', '添加配置', '添加配置', '', '[user|get_nickname] 添加了配置，[details]', '1', '1480296196', '1480296196');
INSERT INTO `cj_admin_action` VALUES ('16', 'admin', 'config_edit', '编辑配置', '编辑配置', '', '[user|get_nickname] 编辑了配置：[details]', '1', '1480296960', '1480296960');
INSERT INTO `cj_admin_action` VALUES ('17', 'admin', 'config_enable', '启用配置', '启用配置', '', '[user|get_nickname] 启用了配置：[details]', '1', '1480298479', '1480298479');
INSERT INTO `cj_admin_action` VALUES ('18', 'admin', 'config_disable', '禁用配置', '禁用配置', '', '[user|get_nickname] 禁用了配置：[details]', '1', '1480298506', '1480298506');
INSERT INTO `cj_admin_action` VALUES ('19', 'admin', 'config_delete', '删除配置', '删除配置', '', '[user|get_nickname] 删除了配置：[details]', '1', '1480298532', '1480298532');
INSERT INTO `cj_admin_action` VALUES ('20', 'admin', 'database_export', '备份数据库', '备份数据库', '', '[user|get_nickname] 备份了数据库：[details]', '1', '1480298946', '1480298946');
INSERT INTO `cj_admin_action` VALUES ('21', 'admin', 'database_import', '还原数据库', '还原数据库', '', '[user|get_nickname] 还原了数据库：[details]', '1', '1480301990', '1480302022');
INSERT INTO `cj_admin_action` VALUES ('22', 'admin', 'database_optimize', '优化数据表', '优化数据表', '', '[user|get_nickname] 优化了数据表：[details]', '1', '1480302616', '1480302616');
INSERT INTO `cj_admin_action` VALUES ('23', 'admin', 'database_repair', '修复数据表', '修复数据表', '', '[user|get_nickname] 修复了数据表：[details]', '1', '1480302798', '1480302798');
INSERT INTO `cj_admin_action` VALUES ('24', 'admin', 'database_backup_delete', '删除数据库备份', '删除数据库备份', '', '[user|get_nickname] 删除了数据库备份：[details]', '1', '1480302870', '1480302870');
INSERT INTO `cj_admin_action` VALUES ('25', 'admin', 'hook_add', '添加钩子', '添加钩子', '', '[user|get_nickname] 添加了钩子：[details]', '1', '1480303198', '1480303198');
INSERT INTO `cj_admin_action` VALUES ('26', 'admin', 'hook_edit', '编辑钩子', '编辑钩子', '', '[user|get_nickname] 编辑了钩子：[details]', '1', '1480303229', '1480303229');
INSERT INTO `cj_admin_action` VALUES ('27', 'admin', 'hook_delete', '删除钩子', '删除钩子', '', '[user|get_nickname] 删除了钩子：[details]', '1', '1480303264', '1480303264');
INSERT INTO `cj_admin_action` VALUES ('28', 'admin', 'hook_enable', '启用钩子', '启用钩子', '', '[user|get_nickname] 启用了钩子：[details]', '1', '1480303294', '1480303294');
INSERT INTO `cj_admin_action` VALUES ('29', 'admin', 'hook_disable', '禁用钩子', '禁用钩子', '', '[user|get_nickname] 禁用了钩子：[details]', '1', '1480303409', '1480303409');
INSERT INTO `cj_admin_action` VALUES ('30', 'admin', 'menu_add', '添加节点', '添加节点', '', '[user|get_nickname] 添加了节点：[details]', '1', '1480305468', '1480305468');
INSERT INTO `cj_admin_action` VALUES ('31', 'admin', 'menu_edit', '编辑节点', '编辑节点', '', '[user|get_nickname] 编辑了节点：[details]', '1', '1480305513', '1480305513');
INSERT INTO `cj_admin_action` VALUES ('32', 'admin', 'menu_delete', '删除节点', '删除节点', '', '[user|get_nickname] 删除了节点：[details]', '1', '1480305562', '1480305562');
INSERT INTO `cj_admin_action` VALUES ('33', 'admin', 'menu_enable', '启用节点', '启用节点', '', '[user|get_nickname] 启用了节点：[details]', '1', '1480305630', '1480305630');
INSERT INTO `cj_admin_action` VALUES ('34', 'admin', 'menu_disable', '禁用节点', '禁用节点', '', '[user|get_nickname] 禁用了节点：[details]', '1', '1480305659', '1480305659');
INSERT INTO `cj_admin_action` VALUES ('35', 'admin', 'module_install', '安装模块', '安装模块', '', '[user|get_nickname] 安装了模块：[details]', '1', '1480307558', '1480307558');
INSERT INTO `cj_admin_action` VALUES ('36', 'admin', 'module_uninstall', '卸载模块', '卸载模块', '', '[user|get_nickname] 卸载了模块：[details]', '1', '1480307588', '1480307588');
INSERT INTO `cj_admin_action` VALUES ('37', 'admin', 'module_enable', '启用模块', '启用模块', '', '[user|get_nickname] 启用了模块：[details]', '1', '1480307618', '1480307618');
INSERT INTO `cj_admin_action` VALUES ('38', 'admin', 'module_disable', '禁用模块', '禁用模块', '', '[user|get_nickname] 禁用了模块：[details]', '1', '1480307653', '1480307653');
INSERT INTO `cj_admin_action` VALUES ('39', 'admin', 'module_export', '导出模块', '导出模块', '', '[user|get_nickname] 导出了模块：[details]', '1', '1480307682', '1480307682');
INSERT INTO `cj_admin_action` VALUES ('40', 'admin', 'packet_install', '安装数据包', '安装数据包', '', '[user|get_nickname] 安装了数据包：[details]', '1', '1480308342', '1480308342');
INSERT INTO `cj_admin_action` VALUES ('41', 'admin', 'packet_uninstall', '卸载数据包', '卸载数据包', '', '[user|get_nickname] 卸载了数据包：[details]', '1', '1480308372', '1480308372');
INSERT INTO `cj_admin_action` VALUES ('42', 'admin', 'system_config_update', '更新系统设置', '更新系统设置', '', '[user|get_nickname] 更新了系统设置：[details]', '1', '1480309555', '1480309642');

-- ----------------------------
-- Table structure for cj_admin_attachment
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_attachment`;
CREATE TABLE `cj_admin_attachment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名',
  `module` varchar(32) NOT NULL DEFAULT '' COMMENT '模块名，由哪个模块上传的',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '文件链接',
  `mime` varchar(128) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `ext` char(8) NOT NULL DEFAULT '' COMMENT '文件类型',
  `size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT 'sha1 散列值',
  `driver` varchar(16) NOT NULL DEFAULT 'local' COMMENT '上传驱动',
  `download` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `width` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '图片宽度',
  `height` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '图片高度',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='附件表';

-- ----------------------------
-- Records of cj_admin_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for cj_admin_button
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_button`;
CREATE TABLE `cj_admin_button` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '按钮名称',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
  `module_id` int(11) NOT NULL COMMENT '所属表的ID',
  `css_style` varchar(255) DEFAULT '' COMMENT 'css样式',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接的url(模块/模型/方法)',
  `is_independent` tinyint(1) DEFAULT '1' COMMENT '是否独立  0 不独立 1  独立',
  `open_type` tinyint(1) NOT NULL DEFAULT '2' COMMENT '打开显示类型 0右平滑  1弹窗 2 视图',
  `show_style` tinyint(1) NOT NULL DEFAULT '0' COMMENT '显示样式  0是默认 1.主要  2.警告  3.危险',
  `button_operation_type` tinyint(1) DEFAULT '0' COMMENT '按钮操作类型 0无操作  1 打开视图  2.打开url 3.ajax_post',
  `view_width` varchar(255) DEFAULT '' COMMENT '视图宽高',
  `param` varchar(255) DEFAULT '' COMMENT '携带参数php代码格式',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `confirm` varchar(255) DEFAULT '' COMMENT '确认信息',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(11) unsigned DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned DEFAULT '0' COMMENT '更新时间',
  `button_type` varchar(255) NOT NULL DEFAULT 'tab1' COMMENT '按钮的类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of cj_admin_button
-- ----------------------------
INSERT INTO `cj_admin_button` VALUES ('3', '新增', 'add', 'fa fa-fw fa-search', '75', '', 'admin/menu/add', '1', '0', '0', '0', '', '[\'model_id\'=>\'__id__\']', '100', '', '1', '1532586274', '1532586274', 'tab1');
INSERT INTO `cj_admin_button` VALUES ('4', '编辑', 'edit', 'fa fa-fw fa-home', '75', '', '', '1', '0', '0', '0', '', '[\'model_id\'=>\'__id__\']', '100', '', '1', '1532586465', '1532586465', 'tab2');
INSERT INTO `cj_admin_button` VALUES ('6', '编辑', 'add', 'fa fa-fw fa-star', '75', '', 'admin/menu/add', '1', '0', '0', '0', '', '[\'model_id\'=>\'__id__\']', '100', '', '1', '1532596267', '1532596267', 'tab1');

-- ----------------------------
-- Table structure for cj_admin_config
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_config`;
CREATE TABLE `cj_admin_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '标题',
  `group` varchar(32) NOT NULL DEFAULT '' COMMENT '配置分组',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT '类型',
  `value` text NOT NULL COMMENT '配置值',
  `options` text NOT NULL COMMENT '配置项',
  `tips` varchar(256) NOT NULL DEFAULT '' COMMENT '配置提示',
  `ajax_url` varchar(256) NOT NULL DEFAULT '' COMMENT '联动下拉框ajax地址',
  `next_items` varchar(256) NOT NULL DEFAULT '' COMMENT '联动下拉框的下级下拉框名，多个以逗号隔开',
  `param` varchar(32) NOT NULL DEFAULT '' COMMENT '联动下拉框请求参数名',
  `format` varchar(32) NOT NULL DEFAULT '' COMMENT '格式，用于格式文本',
  `table` varchar(32) NOT NULL DEFAULT '' COMMENT '表名，只用于快速联动类型',
  `level` tinyint(2) unsigned NOT NULL DEFAULT '2' COMMENT '联动级别，只用于快速联动类型',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT '键字段，只用于快速联动类型',
  `option` varchar(32) NOT NULL DEFAULT '' COMMENT '值字段，只用于快速联动类型',
  `pid` varchar(32) NOT NULL DEFAULT '' COMMENT '父级id字段，只用于快速联动类型',
  `ak` varchar(32) NOT NULL DEFAULT '' COMMENT '百度地图appkey',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0禁用，1启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统配置表';

-- ----------------------------
-- Records of cj_admin_config
-- ----------------------------
INSERT INTO `cj_admin_config` VALUES ('1', 'web_site_status', '站点开关', 'base', 'switch', '1', '', '站点关闭后将不能访问，后台可正常登录', '', '', '', '', '', '2', '', '', '', '', '1475240395', '1477403914', '1', '1');
INSERT INTO `cj_admin_config` VALUES ('2', 'web_site_title', '站点标题', 'base', 'text', '简单框架', '', '调用方式：<code>config(\'web_site_title\')</code>', '', '', '', '', '', '2', '', '', '', '', '1475240646', '1477710341', '2', '1');
INSERT INTO `cj_admin_config` VALUES ('3', 'web_site_slogan', '站点标语', 'base', 'text', '极简、极速、极致', '', '站点口号，调用方式：<code>config(\'web_site_slogan\')</code>', '', '', '', '', '', '2', '', '', '', '', '1475240994', '1477710357', '3', '1');
INSERT INTO `cj_admin_config` VALUES ('4', 'web_site_logo', '站点LOGO', 'base', 'image', '', '', '', '', '', '', '', '', '2', '', '', '', '', '1475241067', '1475241067', '4', '1');
INSERT INTO `cj_admin_config` VALUES ('5', 'web_site_description', '站点描述', 'base', 'textarea', '', '', '网站描述，有利于搜索引擎抓取相关信息', '', '', '', '', '', '2', '', '', '', '', '1475241186', '1475241186', '6', '1');
INSERT INTO `cj_admin_config` VALUES ('6', 'web_site_keywords', '站点关键词', 'base', 'text', 'PHP开发框架、后台框架', '', '网站搜索引擎关键字', '', '', '', '', '', '2', '', '', '', '', '1475241328', '1475241328', '7', '1');
INSERT INTO `cj_admin_config` VALUES ('7', 'web_site_copyright', '版权信息', 'base', 'text', 'Copyright © 2015-2017 All rights reserved.', '', '调用方式：<code>config(\'web_site_copyright\')</code>', '', '', '', '', '', '2', '', '', '', '', '1475241416', '1477710383', '8', '1');
INSERT INTO `cj_admin_config` VALUES ('8', 'web_site_icp', '备案信息', 'base', 'text', '', '', '调用方式：<code>config(\'web_site_icp\')</code>', '', '', '', '', '', '2', '', '', '', '', '1475241441', '1477710441', '9', '1');
INSERT INTO `cj_admin_config` VALUES ('9', 'web_site_statistics', '站点统计', 'base', 'textarea', '', '', '网站统计代码，支持百度、Google、cnzz等，调用方式：<code>config(\'web_site_statistics\')</code>', '', '', '', '', '', '2', '', '', '', '', '1475241498', '1477710455', '10', '1');
INSERT INTO `cj_admin_config` VALUES ('10', 'config_group', '配置分组', 'system', 'array', 'base:基本\r\nsystem:系统\r\nupload:上传\r\ndevelop:开发\r\ndatabase:数据库', '', '', '', '', '', '', '', '2', '', '', '', '', '1475241716', '1477649446', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('11', 'form_item_type', '配置类型', 'system', 'array', 'text:单行文本 text\r\ntextarea:多行文本 textarea\r\nstatic:静态文本 static\r\npassword:密码 password\r\ncheckbox:复选框 checkbox\r\nradio:单选按钮 radio\r\ndate:日期 date\r\ndatetime:日期时间 datetime\r\nhidden:隐藏 hidden\r\nswitch:开关 switch\r\narray:数组 array\r\nselect:下拉框 select\r\nlinkage:普通联动下拉框 linkage\r\nlinkages:快速联动下拉框 linkages\r\nimage:单张图片 image\r\nimages:多张图片 images\r\nfile:单个文件 file\r\nfiles:多个文件 files\r\nueditor:UEditor 编辑器 ueditor\r\nwangeditor:wangEditor 编辑器 wangeditor\r\neditormd:markdown 编辑器 editormd\r\nckeditor:ckeditor 编辑器 ckeditor\r\nicon:字体图标 icon\r\ntags:标签 tags\r\nnumber:数字 number\r\nbmap:百度地图 bmap\r\ncolorpicker:取色器 colorpicker\r\njcrop:图片裁剪 jcrop\r\nmasked:格式文本 masked\r\nrange:范围 range\r\ntime:时间 time', '', '', '', '', '', '', '', '2', '', '', '', '', '1475241835', '1532501082', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('12', 'upload_file_size', '文件上传大小限制', 'upload', 'text', '0', '', '0为不限制大小，单位：kb', '', '', '', '', '', '2', '', '', '', '', '1475241897', '1477663520', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('13', 'upload_file_ext', '允许上传的文件后缀', 'upload', 'tags', 'doc,docx,xls,xlsx,ppt,pptx,pdf,wps,txt,rar,zip,gz,bz2,7z', '', '多个后缀用逗号隔开，不填写则不限制类型', '', '', '', '', '', '2', '', '', '', '', '1475241975', '1477649489', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('14', 'upload_image_size', '图片上传大小限制', 'upload', 'text', '0', '', '0为不限制大小，单位：kb', '', '', '', '', '', '2', '', '', '', '', '1475242015', '1477663529', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('15', 'upload_image_ext', '允许上传的图片后缀', 'upload', 'tags', 'gif,jpg,jpeg,bmp,png', '', '多个后缀用逗号隔开，不填写则不限制类型', '', '', '', '', '', '2', '', '', '', '', '1475242056', '1477649506', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('16', 'list_rows', '分页数量', 'system', 'number', '20', '', '每页的记录数', '', '', '', '', '', '2', '', '', '', '', '1475242066', '1476074507', '101', '1');
INSERT INTO `cj_admin_config` VALUES ('17', 'system_color', '后台配色方案', 'system', 'radio', 'default', 'default:Default\r\namethyst:Amethyst\r\ncity:City\r\nflat:Flat\r\nmodern:Modern\r\nsmooth:Smooth', '', '', '', '', '', '', '2', '', '', '', '', '1475250066', '1477316689', '102', '1');
INSERT INTO `cj_admin_config` VALUES ('18', 'develop_mode', '开发模式', 'develop', 'radio', '1', '0:关闭\r\n1:开启', '', '', '', '', '', '', '2', '', '', '', '', '1476864205', '1476864231', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('19', 'app_trace', '显示页面Trace', 'develop', 'radio', '0', '0:否\r\n1:是', '', '', '', '', '', '', '2', '', '', '', '', '1476866355', '1476866355', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('21', 'data_backup_path', '数据库备份根路径', 'database', 'text', '../data/', '', '路径必须以 / 结尾', '', '', '', '', '', '2', '', '', '', '', '1477017745', '1477018467', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('22', 'data_backup_part_size', '数据库备份卷大小', 'database', 'text', '20971520', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '', '', '', '', '', '2', '', '', '', '', '1477017886', '1477017886', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('23', 'data_backup_compress', '数据库备份文件是否启用压缩', 'database', 'radio', '1', '0:否\r\n1:是', '压缩备份文件需要PHP环境支持 <code>gzopen</code>, <code>gzwrite</code>函数', '', '', '', '', '', '2', '', '', '', '', '1477017978', '1477018172', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('24', 'data_backup_compress_level', '数据库备份文件压缩级别', 'database', 'radio', '9', '1:最低\r\n4:一般\r\n9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '', '', '', '', '', '2', '', '', '', '', '1477018083', '1477018083', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('25', 'top_menu_max', '顶部导航模块数量', 'system', 'text', '10', '', '设置顶部导航默认显示的模块数量', '', '', '', '', '', '2', '', '', '', '', '1477579289', '1477579289', '103', '1');
INSERT INTO `cj_admin_config` VALUES ('26', 'web_site_logo_text', '站点LOGO文字', 'base', 'image', '', '', '', '', '', '', '', '', '2', '', '', '', '', '1477620643', '1477620643', '5', '1');
INSERT INTO `cj_admin_config` VALUES ('27', 'upload_image_thumb', '缩略图尺寸', 'upload', 'text', '', '', '不填写则不生成缩略图，如需生成 <code>300x300</code> 的缩略图，则填写 <code>300,300</code> ，请注意，逗号必须是英文逗号', '', '', '', '', '', '2', '', '', '', '', '1477644150', '1477649513', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('28', 'upload_image_thumb_type', '缩略图裁剪类型', 'upload', 'radio', '1', '1:等比例缩放\r\n2:缩放后填充\r\n3:居中裁剪\r\n4:左上角裁剪\r\n5:右下角裁剪\r\n6:固定尺寸缩放', '该项配置只有在启用生成缩略图时才生效', '', '', '', '', '', '2', '', '', '', '', '1477646271', '1477649521', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('29', 'upload_thumb_water', '添加水印', 'upload', 'switch', '0', '', '', '', '', '', '', '', '2', '', '', '', '', '1477649648', '1477649648', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('30', 'upload_thumb_water_pic', '水印图片', 'upload', 'image', '', '', '只有开启水印功能才生效', '', '', '', '', '', '2', '', '', '', '', '1477656390', '1477656390', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('31', 'upload_thumb_water_position', '水印位置', 'upload', 'radio', '9', '1:左上角\r\n2:上居中\r\n3:右上角\r\n4:左居中\r\n5:居中\r\n6:右居中\r\n7:左下角\r\n8:下居中\r\n9:右下角', '只有开启水印功能才生效', '', '', '', '', '', '2', '', '', '', '', '1477656528', '1477656528', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('32', 'upload_thumb_water_alpha', '水印透明度', 'upload', 'text', '50', '', '请输入0~100之间的数字，数字越小，透明度越高', '', '', '', '', '', '2', '', '', '', '', '1477656714', '1477661309', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('33', 'wipe_cache_type', '清除缓存类型', 'system', 'checkbox', 'TEMP_PATH', 'TEMP_PATH:应用缓存\r\nLOG_PATH:应用日志\r\nCACHE_PATH:项目模板缓存', '清除缓存时，要删除的缓存类型', '', '', '', '', '', '2', '', '', '', '', '1477727305', '1477727305', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('34', 'captcha_signin', '后台验证码开关', 'system', 'switch', '0', '', '后台登录时是否需要验证码', '', '', '', '', '', '2', '', '', '', '', '1478771958', '1478771958', '99', '1');
INSERT INTO `cj_admin_config` VALUES ('35', 'home_default_module', '前台默认模块', 'system', 'select', 'index', '', '前台默认访问的模块，该模块必须有Index控制器和index方法', '', '', '', '', '', '0', '', '', '', '', '1486714723', '1486715620', '104', '1');
INSERT INTO `cj_admin_config` VALUES ('36', 'minify_status', '开启minify', 'system', 'switch', '0', '', '开启minify会压缩合并js、css文件，可以减少资源请求次数，如果不支持minify，可关闭', '', '', '', '', '', '0', '', '', '', '', '1487035843', '1487035843', '99', '1');
INSERT INTO `cj_admin_config` VALUES ('37', 'upload_driver', '上传驱动', 'upload', 'radio', 'local', 'local:本地', '图片或文件上传驱动', '', '', '', '', '', '0', '', '', '', '', '1501488567', '1501490821', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('38', 'system_log', '系统日志', 'system', 'switch', '1', '', '是否开启系统日志功能', '', '', '', '', '', '0', '', '', '', '', '1512635391', '1512635391', '99', '1');
INSERT INTO `cj_admin_config` VALUES ('39', 'asset_version', '资源版本号', 'develop', 'text', '20180327', '', '可通过修改版号强制用户更新静态文件', '', '', '', '', '', '0', '', '', '', '', '1522143239', '1522143239', '100', '1');
INSERT INTO `cj_admin_config` VALUES ('40', 'database_data_type', '数据库数据类型', 'system', 'array', 'int:int\r\nvarchar:varchar\r\ntinyint:tinyint \r\nfloat:float\r\ndouble:double\r\nchar:char\r\ntext:text\r\ndate:date\r\ndecimal:decimal\r\n\r\n\r\n', 'int:11\r\nvarchar:255', '', '', '', '', '', '', '0', '', '', '', '', '1532168361', '1532169020', '100', '1');

-- ----------------------------
-- Table structure for cj_admin_field
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_field`;
CREATE TABLE `cj_admin_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '字段名称',
  `name` varchar(32) NOT NULL,
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '字段标题',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT '字段类型',
  `define` varchar(128) NOT NULL DEFAULT '' COMMENT '字段定义',
  `value` text COMMENT '默认值',
  `options` text COMMENT '额外选项',
  `tips` varchar(256) NOT NULL DEFAULT '' COMMENT '提示说明',
  `fixed` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否为固定字段',
  `show` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示',
  `model` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属文档模型id',
  `ajax_url` varchar(256) NOT NULL DEFAULT '' COMMENT '联动下拉框ajax地址',
  `next_items` varchar(256) NOT NULL DEFAULT '' COMMENT '联动下拉框的下级下拉框名，多个以逗号隔开',
  `param` varchar(32) NOT NULL DEFAULT '' COMMENT '联动下拉框请求参数名',
  `format` varchar(32) NOT NULL DEFAULT '' COMMENT '格式，用于格式文本',
  `table` varchar(32) NOT NULL DEFAULT '' COMMENT '表名，只用于快速联动类型',
  `level` tinyint(2) unsigned NOT NULL DEFAULT '2' COMMENT '联动级别，只用于快速联动类型',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT '键字段，只用于快速联动类型',
  `option` varchar(32) NOT NULL DEFAULT '' COMMENT '值字段，只用于快速联动类型',
  `pid` varchar(32) NOT NULL DEFAULT '' COMMENT '父级id字段，只用于快速联动类型',
  `ak` varchar(32) NOT NULL DEFAULT '' COMMENT '百度地图appkey',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `data_type` varchar(255) NOT NULL DEFAULT '' COMMENT '数据类型',
  `length` varchar(50) NOT NULL DEFAULT '' COMMENT '长度',
  `is_null` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否为空',
  `new_type` varchar(255) DEFAULT '' COMMENT '新增类型',
  `edit_type` varchar(255) DEFAULT '' COMMENT '编辑类型',
  `list_type` varchar(255) DEFAULT '' COMMENT '列表类型',
  `field_check` varchar(255) DEFAULT '' COMMENT '字段校验',
  `is_search` tinyint(1) DEFAULT '0' COMMENT '是否显示搜索 0不显示  1 是显示',
  `is_filter` tinyint(1) DEFAULT '0' COMMENT '是否显示过滤 0不显示  1 是显示',
  `is_total` tinyint(1) DEFAULT '0' COMMENT '是否显示合计 0不显示  1 是显示',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=506 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文档字段表';

-- ----------------------------
-- Records of cj_admin_field
-- ----------------------------
INSERT INTO `cj_admin_field` VALUES ('370', 'status', '状态', 'radio', 'tinyint(2) NOT NULL', '1', '0:禁用\n1:启用', '', '0', '1', '75', '', '', '', '', '', '2', '', '', '', '', '1532490563', '1532490563', '100', '1', 'tinyint', '1', '0', 'switch', 'switch', 'switch', '', '0', '0', '0');
INSERT INTO `cj_admin_field` VALUES ('369', 'delete_time', '删除时间', 'datetime', 'int(11) UNSIGNED NOT NULL', '0', null, '', '0', '1', '75', '', '', '', '', '', '2', '', '', '', '', '1532490563', '1532490563', '100', '1', '', '', '0', 'hidden', 'hidden', 'hidden', '', '0', '0', '0');
INSERT INTO `cj_admin_field` VALUES ('368', 'update_time', '更新时间', 'datetime', 'int(11) UNSIGNED NOT NULL', '0', null, '', '0', '1', '75', '', '', '', '', '', '2', '', '', '', '', '1532490563', '1532490563', '100', '1', '', '', '0', 'hidden', 'hidden', 'text', '', '0', '0', '0');
INSERT INTO `cj_admin_field` VALUES ('367', 'create_time', '创建时间', 'datetime', 'int(11) UNSIGNED NOT NULL', '0', null, '', '0', '1', '75', '', '', '', '', '', '2', '', '', '', '', '1532490563', '1532490563', '100', '1', '', '', '0', 'hidden', 'hidden', '', '', '0', '0', '0');
INSERT INTO `cj_admin_field` VALUES ('366', 'id', 'id', 'text', 'int(11) UNSIGNED NOT NULL', null, null, '', '0', '1', '75', '', '', '', '', '', '2', '', '', '', '', '1532490563', '1532490563', '1', '1', '', '', '0', 'hidden', null, 'text', '', '0', '0', '0');
INSERT INTO `cj_admin_field` VALUES ('356', 'id', 'id', 'text', 'int(11) UNSIGNED NOT NULL', null, null, '', '0', '1', '73', '', '', '', '', '', '2', '', '', '', '', '1532490029', '1532490029', '100', '1', 'int', '11', '0', '1', null, '', '', '0', '0', '0');
INSERT INTO `cj_admin_field` VALUES ('357', 'create_time', '创建时间', 'datetime', 'int(11) UNSIGNED NOT NULL', '0', null, '', '0', '1', '73', '', '', '', '', '', '2', '', '', '', '', '1532490029', '1532490029', '100', '1', 'int', '11', '0', '0', null, '', '', '0', '0', '0');
INSERT INTO `cj_admin_field` VALUES ('358', 'update_time', '更新时间', 'datetime', 'int(11) UNSIGNED NOT NULL', '0', null, '', '0', '1', '73', '', '', '', '', '', '2', '', '', '', '', '1532490029', '1532490029', '100', '1', 'int', '11', '0', '0', null, '', '', '0', '1', '0');
INSERT INTO `cj_admin_field` VALUES ('359', 'delete_time', '删除时间', 'datetime', 'int(11) UNSIGNED NOT NULL', '0', null, '', '0', '1', '73', '', '', '', '', '', '2', '', '', '', '', '1532490029', '1532490029', '100', '1', 'int', '11', '0', '0', null, '', '', '0', '1', '0');
INSERT INTO `cj_admin_field` VALUES ('360', 'status', '状态', 'radio', 'tinyint(2) NOT NULL', '1', '0:禁用\n1:启用', '', '0', '1', '73', '', '', '', '', '', '2', '', '', '', '', '1532490029', '1532490029', '100', '1', 'tinyint', '1', '0', 'hidden', null, '', '', '0', '1', '0');
INSERT INTO `cj_admin_field` VALUES ('378', 'user_token', '用户', 'text', 'varchar(255)  not null', '', '', '', '0', '1', '75', '', '', '', '', '', '0', '', '', '', '', '1532502407', '1532502407', '3', '1', 'varchar', '255', '0', '1', '', '', '', '0', '0', '0');
INSERT INTO `cj_admin_field` VALUES ('380', 'title', '标题', 'text', 'varchar(255)  NOT NULL', '', '', '', '0', '1', '75', '', '', '', '', '', '0', '', '', '', '', '1532502767', '1532502767', '2', '1', 'varchar', '255', '0', '1', 'text', 'text', '', '1', '1', '0');
INSERT INTO `cj_admin_field` VALUES ('394', 'liste', '列表', 'text', 'varchar(255)  NOT NULL', '', '', '', '0', '1', '75', '', '', '', '', '', '0', '', '', '', '', '1532509193', '1532509193', '100', '1', 'varchar', '255', '0', 'textarea', '', 'text', 'max:255', '1', '1', '0');
INSERT INTO `cj_admin_field` VALUES ('501', 'id', 'id', 'text', 'int(11) UNSIGNED NOT NULL', null, null, '', '0', '1', '115', '', '', '', '', '', '2', '', '', '', '', '1533112918', '1533112918', '100', '1', 'int', '11', '0', '', '', '', '', '0', '0', '0');
INSERT INTO `cj_admin_field` VALUES ('502', 'create_time', '创建时间', 'datetime', 'int(11) UNSIGNED NOT NULL', '0', null, '', '0', '1', '115', '', '', '', '', '', '2', '', '', '', '', '1533112918', '1533112918', '100', '1', 'int', '11', '0', '', '', '', '', '0', '0', '0');
INSERT INTO `cj_admin_field` VALUES ('503', 'update_time', '更新时间', 'datetime', 'int(11) UNSIGNED NOT NULL', '0', null, '', '0', '1', '115', '', '', '', '', '', '2', '', '', '', '', '1533112918', '1533112918', '100', '1', 'int', '11', '0', '', '', '', '', '0', '0', '0');
INSERT INTO `cj_admin_field` VALUES ('504', 'delete_time', '删除时间', 'datetime', 'int(11) UNSIGNED NOT NULL', '0', null, '', '0', '1', '115', '', '', '', '', '', '2', '', '', '', '', '1533112918', '1533112918', '100', '1', 'int', '11', '0', '', '', '', '', '0', '0', '0');
INSERT INTO `cj_admin_field` VALUES ('505', 'status', '状态', 'radio', 'tinyint(2) NOT NULL', '1', '0:禁用\n1:启用', '', '0', '1', '115', '', '', '', '', '', '2', '', '', '', '', '1533112918', '1533112918', '100', '1', 'tinyint', '1', '0', '', '', '', '', '0', '0', '0');

-- ----------------------------
-- Table structure for cj_admin_hook
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_hook`;
CREATE TABLE `cj_admin_hook` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `plugin` varchar(32) NOT NULL DEFAULT '' COMMENT '钩子来自哪个插件',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子描述',
  `system` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统钩子',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='钩子表';

-- ----------------------------
-- Records of cj_admin_hook
-- ----------------------------
INSERT INTO `cj_admin_hook` VALUES ('1', 'admin_index', '', '后台首页', '1', '1468174214', '1477757518', '1');
INSERT INTO `cj_admin_hook` VALUES ('2', 'plugin_index_tab_list', '', '插件扩展tab钩子', '1', '1468174214', '1468174214', '1');
INSERT INTO `cj_admin_hook` VALUES ('3', 'module_index_tab_list', '', '模块扩展tab钩子', '1', '1468174214', '1468174214', '1');
INSERT INTO `cj_admin_hook` VALUES ('4', 'page_tips', '', '每个页面的提示', '1', '1468174214', '1468174214', '1');
INSERT INTO `cj_admin_hook` VALUES ('5', 'signin_footer', '', '登录页面底部钩子', '1', '1479269315', '1479269315', '1');
INSERT INTO `cj_admin_hook` VALUES ('6', 'signin_captcha', '', '登录页面验证码钩子', '1', '1479269315', '1479269315', '1');
INSERT INTO `cj_admin_hook` VALUES ('7', 'signin', '', '登录控制器钩子', '1', '1479386875', '1479386875', '1');
INSERT INTO `cj_admin_hook` VALUES ('8', 'upload_attachment', '', '附件上传钩子', '1', '1501493808', '1501493808', '1');
INSERT INTO `cj_admin_hook` VALUES ('9', 'page_plugin_js', '', '页面插件js钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `cj_admin_hook` VALUES ('10', 'page_plugin_css', '', '页面插件css钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `cj_admin_hook` VALUES ('11', 'signin_sso', '', '单点登录钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `cj_admin_hook` VALUES ('12', 'signout_sso', '', '单点退出钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `cj_admin_hook` VALUES ('13', 'user_add', '', '添加用户钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `cj_admin_hook` VALUES ('14', 'user_edit', '', '编辑用户钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `cj_admin_hook` VALUES ('15', 'user_delete', '', '删除用户钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `cj_admin_hook` VALUES ('16', 'user_enable', '', '启用用户钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `cj_admin_hook` VALUES ('17', 'user_disable', '', '禁用用户钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `cj_admin_hook` VALUES ('19', 'my_hook', 'HelloWorld', '我的钩子', '0', '1533114900', '1533114900', '1');

-- ----------------------------
-- Table structure for cj_admin_hook_plugin
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_hook_plugin`;
CREATE TABLE `cj_admin_hook_plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hook` varchar(32) NOT NULL DEFAULT '' COMMENT '钩子id',
  `plugin` varchar(32) NOT NULL DEFAULT '' COMMENT '插件标识',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='钩子-插件对应表';

-- ----------------------------
-- Records of cj_admin_hook_plugin
-- ----------------------------
INSERT INTO `cj_admin_hook_plugin` VALUES ('1', 'admin_index', 'SystemInfo', '1477757503', '1477757503', '1', '1');
INSERT INTO `cj_admin_hook_plugin` VALUES ('2', 'admin_index', 'DevTeam', '1477755780', '1477755780', '2', '1');
INSERT INTO `cj_admin_hook_plugin` VALUES ('6', 'page_tips', 'HelloWorld', '1533114900', '1533114900', '100', '1');
INSERT INTO `cj_admin_hook_plugin` VALUES ('5', 'admin_index', 'CeshiGangqiang', '1533103928', '1533103928', '100', '1');
INSERT INTO `cj_admin_hook_plugin` VALUES ('7', 'my_hook', 'HelloWorld', '1533114900', '1533114900', '100', '1');

-- ----------------------------
-- Table structure for cj_admin_icon
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_icon`;
CREATE TABLE `cj_admin_icon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '图标名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图标css地址',
  `prefix` varchar(32) NOT NULL DEFAULT '' COMMENT '图标前缀',
  `font_family` varchar(32) NOT NULL DEFAULT '' COMMENT '字体名',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='图标表';

-- ----------------------------
-- Records of cj_admin_icon
-- ----------------------------
INSERT INTO `cj_admin_icon` VALUES ('1', '天猫图标', '//at.alicdn.com/t/font_767312_2iekydirgbv.css', '', '', '1532749058', '1532749058', '1');

-- ----------------------------
-- Table structure for cj_admin_icon_list
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_icon_list`;
CREATE TABLE `cj_admin_icon_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `icon_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属图标id',
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '图标标题',
  `class` varchar(255) NOT NULL DEFAULT '' COMMENT '图标类名',
  `code` varchar(128) NOT NULL DEFAULT '' COMMENT '图标关键词',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=407 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='详细图标列表';

-- ----------------------------
-- Records of cj_admin_icon_list
-- ----------------------------
INSERT INTO `cj_admin_icon_list` VALUES ('190', '1', 'xinxi', 'iconfont icon-xinxi', 'xinxi');
INSERT INTO `cj_admin_icon_list` VALUES ('189', '1', 'wentifankui', 'iconfont icon-wentifankui', 'wentifankui');
INSERT INTO `cj_admin_icon_list` VALUES ('188', '1', 'shijian', 'iconfont icon-shijian', 'shijian');
INSERT INTO `cj_admin_icon_list` VALUES ('185', '1', 'wo1', 'iconfont icon-wo1', 'wo1');
INSERT INTO `cj_admin_icon_list` VALUES ('186', '1', 'biaoqing', 'iconfont icon-biaoqing', 'biaoqing');
INSERT INTO `cj_admin_icon_list` VALUES ('184', '1', 'huiyuanqia', 'iconfont icon-huiyuanqia', 'huiyuanqia');
INSERT INTO `cj_admin_icon_list` VALUES ('187', '1', 'gongnengjianyi', 'iconfont icon-gongnengjianyi', 'gongnengjianyi');
INSERT INTO `cj_admin_icon_list` VALUES ('180', '1', 'gouwurili', 'iconfont icon-gouwurili', 'gouwurili');
INSERT INTO `cj_admin_icon_list` VALUES ('181', '1', 'woguanzhudepinpai', 'iconfont icon-woguanzhudepinpai', 'woguanzhudepinpai');
INSERT INTO `cj_admin_icon_list` VALUES ('183', '1', 'zhibojian', 'iconfont icon-zhibojian', 'zhibojian');
INSERT INTO `cj_admin_icon_list` VALUES ('182', '1', 'wo', 'iconfont icon-wo', 'wo');
INSERT INTO `cj_admin_icon_list` VALUES ('179', '1', 'kanguo', 'iconfont icon-kanguo', 'kanguo');
INSERT INTO `cj_admin_icon_list` VALUES ('177', '1', 'xiebao', 'iconfont icon-xiebao', 'xiebao');
INSERT INTO `cj_admin_icon_list` VALUES ('178', '1', 'nvzhuangneiyi', 'iconfont icon-nvzhuangneiyi', 'nvzhuangneiyi');
INSERT INTO `cj_admin_icon_list` VALUES ('173', '1', 'jiajujiancai', 'iconfont icon-jiajujiancai', 'jiajujiancai');
INSERT INTO `cj_admin_icon_list` VALUES ('174', '1', 'jiayongdianqi', 'iconfont icon-jiayongdianqi', 'jiayongdianqi');
INSERT INTO `cj_admin_icon_list` VALUES ('176', '1', 'shumashouji', 'iconfont icon-shumashouji', 'shumashouji');
INSERT INTO `cj_admin_icon_list` VALUES ('175', '1', 'shipin', 'iconfont icon-shipin', 'shipin');
INSERT INTO `cj_admin_icon_list` VALUES ('171', '1', 'xiexiangbao', 'iconfont icon-xiexiangbao', 'xiexiangbao');
INSERT INTO `cj_admin_icon_list` VALUES ('172', '1', 'zhubaoshipin', 'iconfont icon-zhubaoshipin', 'zhubaoshipin');
INSERT INTO `cj_admin_icon_list` VALUES ('170', '1', 'chuzu', 'iconfont icon-chuzu', 'chuzu');
INSERT INTO `cj_admin_icon_list` VALUES ('163', '1', 'leqi', 'iconfont icon-leqi', 'leqi');
INSERT INTO `cj_admin_icon_list` VALUES ('164', '1', 'bingxiang', 'iconfont icon-bingxiang', 'bingxiang');
INSERT INTO `cj_admin_icon_list` VALUES ('165', '1', 'kafei', 'iconfont icon-kafei', 'kafei');
INSERT INTO `cj_admin_icon_list` VALUES ('166', '1', 'yaopin', 'iconfont icon-yaopin', 'yaopin');
INSERT INTO `cj_admin_icon_list` VALUES ('167', '1', 'kouhong', 'iconfont icon-kouhong', 'kouhong');
INSERT INTO `cj_admin_icon_list` VALUES ('168', '1', 'bangqiu', 'iconfont icon-bangqiu', 'bangqiu');
INSERT INTO `cj_admin_icon_list` VALUES ('169', '1', 'Txu', 'iconfont icon-Txu', 'Txu');
INSERT INTO `cj_admin_icon_list` VALUES ('161', '1', 'liebiao', 'iconfont icon-liebiao', 'liebiao');
INSERT INTO `cj_admin_icon_list` VALUES ('162', '1', 'chongzhi', 'iconfont icon-chongzhi', 'chongzhi');
INSERT INTO `cj_admin_icon_list` VALUES ('158', '1', 'kefuyouxian', 'iconfont icon-kefuyouxian', 'kefuyouxian');
INSERT INTO `cj_admin_icon_list` VALUES ('159', '1', 'chaozhijifen', 'iconfont icon-chaozhijifen', 'chaozhijifen');
INSERT INTO `cj_admin_icon_list` VALUES ('160', '1', 'tianmaohaoquan', 'iconfont icon-tianmaohaoquan', 'tianmaohaoquan');
INSERT INTO `cj_admin_icon_list` VALUES ('157', '1', 'jisutuikuan', 'iconfont icon-jisutuikuan', 'jisutuikuan');
INSERT INTO `cj_admin_icon_list` VALUES ('156', '1', 'shengriliwu', 'iconfont icon-shengriliwu', 'shengriliwu');
INSERT INTO `cj_admin_icon_list` VALUES ('154', '1', 'huodongyouxian', 'iconfont icon-huodongyouxian', 'huodongyouxian');
INSERT INTO `cj_admin_icon_list` VALUES ('155', '1', 'tianmaopaidui', 'iconfont icon-tianmaopaidui', 'tianmaopaidui');
INSERT INTO `cj_admin_icon_list` VALUES ('153', '1', 'tuihuobaozhang', 'iconfont icon-tuihuobaozhang', 'tuihuobaozhang');
INSERT INTO `cj_admin_icon_list` VALUES ('191', '1', 'rectangle390', 'iconfont icon-rectangle390', 'rectangle390');
INSERT INTO `cj_admin_icon_list` VALUES ('192', '1', 'icon', 'iconfont icon-icon', 'icon');
INSERT INTO `cj_admin_icon_list` VALUES ('193', '1', 'zhuanzhang', 'iconfont icon-zhuanzhang', 'zhuanzhang');
INSERT INTO `cj_admin_icon_list` VALUES ('194', '1', 'xinyongqiahuankuan', 'iconfont icon-xinyongqiahuankuan', 'xinyongqiahuankuan');
INSERT INTO `cj_admin_icon_list` VALUES ('195', '1', 'dangmianfu', 'iconfont icon-dangmianfu', 'dangmianfu');
INSERT INTO `cj_admin_icon_list` VALUES ('196', '1', 'shuidianmei', 'iconfont icon-shuidianmei', 'shuidianmei');
INSERT INTO `cj_admin_icon_list` VALUES ('197', '1', 'shoujichongzhi', 'iconfont icon-shoujichongzhi', 'shoujichongzhi');
INSERT INTO `cj_admin_icon_list` VALUES ('198', '1', 'qinmifu', 'iconfont icon-qinmifu', 'qinmifu');
INSERT INTO `cj_admin_icon_list` VALUES ('199', '1', 'gupiao', 'iconfont icon-gupiao', 'gupiao');
INSERT INTO `cj_admin_icon_list` VALUES ('200', '1', 'youxichongzhi', 'iconfont icon-youxichongzhi', 'youxichongzhi');
INSERT INTO `cj_admin_icon_list` VALUES ('201', '1', 'shoukuan', 'iconfont icon-shoukuan', 'shoukuan');
INSERT INTO `cj_admin_icon_list` VALUES ('202', '1', 'jipiao', 'iconfont icon-jipiao', 'jipiao');
INSERT INTO `cj_admin_icon_list` VALUES ('203', '1', 'huilvhuansuan', 'iconfont icon-huilvhuansuan', 'huilvhuansuan');
INSERT INTO `cj_admin_icon_list` VALUES ('204', '1', 'taobao', 'iconfont icon-taobao', 'taobao');
INSERT INTO `cj_admin_icon_list` VALUES ('205', '1', 'jizhang', 'iconfont icon-jizhang', 'jizhang');
INSERT INTO `cj_admin_icon_list` VALUES ('206', '1', 'lvyoutehui', 'iconfont icon-lvyoutehui', 'lvyoutehui');
INSERT INTO `cj_admin_icon_list` VALUES ('207', '1', 'caipiao', 'iconfont icon-caipiao', 'caipiao');
INSERT INTO `cj_admin_icon_list` VALUES ('208', '1', 'aa', 'iconfont icon-aa', 'aa');
INSERT INTO `cj_admin_icon_list` VALUES ('209', '1', 'kuaidi', 'iconfont icon-kuaidi', 'kuaidi');
INSERT INTO `cj_admin_icon_list` VALUES ('210', '1', 'guojihuikuan', 'iconfont icon-guojihuikuan', 'guojihuikuan');
INSERT INTO `cj_admin_icon_list` VALUES ('211', '1', 'aixinjuanzeng', 'iconfont icon-aixinjuanzeng', 'aixinjuanzeng');
INSERT INTO `cj_admin_icon_list` VALUES ('212', '1', 'diandian', 'iconfont icon-diandian', 'diandian');
INSERT INTO `cj_admin_icon_list` VALUES ('213', '1', 'huafeiqiazhuanrang', 'iconfont icon-huafeiqiazhuanrang', 'huafeiqiazhuanrang');
INSERT INTO `cj_admin_icon_list` VALUES ('214', '1', 'aliyouxi', 'iconfont icon-aliyouxi', 'aliyouxi');
INSERT INTO `cj_admin_icon_list` VALUES ('215', '1', 'shoujibaoling', 'iconfont icon-shoujibaoling', 'shoujibaoling');
INSERT INTO `cj_admin_icon_list` VALUES ('216', '1', 'tianmaobao', 'iconfont icon-tianmaobao', 'tianmaobao');
INSERT INTO `cj_admin_icon_list` VALUES ('217', '1', 'qianbaopengyou', 'iconfont icon-qianbaopengyou', 'qianbaopengyou');
INSERT INTO `cj_admin_icon_list` VALUES ('218', '1', 'dache', 'iconfont icon-dache', 'dache');
INSERT INTO `cj_admin_icon_list` VALUES ('219', '1', 'kuaiqiang', 'iconfont icon-kuaiqiang', 'kuaiqiang');
INSERT INTO `cj_admin_icon_list` VALUES ('220', '1', 'suishendai', 'iconfont icon-suishendai', 'suishendai');
INSERT INTO `cj_admin_icon_list` VALUES ('221', '1', 'xiaoyuanyiqiatong', 'iconfont icon-xiaoyuanyiqiatong', 'xiaoyuanyiqiatong');
INSERT INTO `cj_admin_icon_list` VALUES ('222', '1', 'zhaocaibao', 'iconfont icon-zhaocaibao', 'zhaocaibao');
INSERT INTO `cj_admin_icon_list` VALUES ('223', '1', 'yulebao', 'iconfont icon-yulebao', 'yulebao');
INSERT INTO `cj_admin_icon_list` VALUES ('224', '1', 'wodebaozhang', 'iconfont icon-wodebaozhang', 'wodebaozhang');
INSERT INTO `cj_admin_icon_list` VALUES ('225', '1', 'huiyuantequan', 'iconfont icon-huiyuantequan', 'huiyuantequan');
INSERT INTO `cj_admin_icon_list` VALUES ('226', '1', 'chenggong', 'iconfont icon-chenggong', 'chenggong');
INSERT INTO `cj_admin_icon_list` VALUES ('227', '1', 'shibai', 'iconfont icon-shibai', 'shibai');
INSERT INTO `cj_admin_icon_list` VALUES ('228', '1', 'jingshi', 'iconfont icon-jingshi', 'jingshi');
INSERT INTO `cj_admin_icon_list` VALUES ('229', '1', 'tishi', 'iconfont icon-tishi', 'tishi');
INSERT INTO `cj_admin_icon_list` VALUES ('230', '1', 'bangzhu', 'iconfont icon-bangzhu', 'bangzhu');
INSERT INTO `cj_admin_icon_list` VALUES ('231', '1', 'dengdai', 'iconfont icon-dengdai', 'dengdai');
INSERT INTO `cj_admin_icon_list` VALUES ('232', '1', 'xiangji', 'iconfont icon-xiangji', 'xiangji');
INSERT INTO `cj_admin_icon_list` VALUES ('233', '1', 'shoujitongxunlu', 'iconfont icon-shoujitongxunlu', 'shoujitongxunlu');
INSERT INTO `cj_admin_icon_list` VALUES ('234', '1', 'shezhi', 'iconfont icon-shezhi', 'shezhi');
INSERT INTO `cj_admin_icon_list` VALUES ('235', '1', 'wode', 'iconfont icon-wode', 'wode');
INSERT INTO `cj_admin_icon_list` VALUES ('236', '1', 'sousuo', 'iconfont icon-sousuo', 'sousuo');
INSERT INTO `cj_admin_icon_list` VALUES ('237', '1', 'liebiao1', 'iconfont icon-liebiao1', 'liebiao1');
INSERT INTO `cj_admin_icon_list` VALUES ('238', '1', 'bianji', 'iconfont icon-bianji', 'bianji');
INSERT INTO `cj_admin_icon_list` VALUES ('239', '1', 'shanchu', 'iconfont icon-shanchu', 'shanchu');
INSERT INTO `cj_admin_icon_list` VALUES ('240', '1', 'fenxiang', 'iconfont icon-fenxiang', 'fenxiang');
INSERT INTO `cj_admin_icon_list` VALUES ('241', '1', 'ditu', 'iconfont icon-ditu', 'ditu');
INSERT INTO `cj_admin_icon_list` VALUES ('242', '1', 'tianjia', 'iconfont icon-tianjia', 'tianjia');
INSERT INTO `cj_admin_icon_list` VALUES ('243', '1', 'bangzhuxiantiao', 'iconfont icon-bangzhuxiantiao', 'bangzhuxiantiao');
INSERT INTO `cj_admin_icon_list` VALUES ('244', '1', 'gengduo', 'iconfont icon-gengduo', 'gengduo');
INSERT INTO `cj_admin_icon_list` VALUES ('245', '1', 'saoyisao', 'iconfont icon-saoyisao', 'saoyisao');
INSERT INTO `cj_admin_icon_list` VALUES ('246', '1', 'fukuanma', 'iconfont icon-fukuanma', 'fukuanma');
INSERT INTO `cj_admin_icon_list` VALUES ('247', '1', 'chengshifuwu', 'iconfont icon-chengshifuwu', 'chengshifuwu');
INSERT INTO `cj_admin_icon_list` VALUES ('248', '1', 'jiaoyujiaofei', 'iconfont icon-jiaoyujiaofei', 'jiaoyujiaofei');
INSERT INTO `cj_admin_icon_list` VALUES ('249', '1', 'yangchengtongchongzhi', 'iconfont icon-yangchengtongchongzhi', 'yangchengtongchongzhi');
INSERT INTO `cj_admin_icon_list` VALUES ('250', '1', 'chengshiyiqiatong', 'iconfont icon-chengshiyiqiatong', 'chengshiyiqiatong');
INSERT INTO `cj_admin_icon_list` VALUES ('251', '1', 'yiban', 'iconfont icon-yiban', 'yiban');
INSERT INTO `cj_admin_icon_list` VALUES ('252', '1', 'canyin', 'iconfont icon-canyin', 'canyin');
INSERT INTO `cj_admin_icon_list` VALUES ('253', '1', 'gouwu', 'iconfont icon-gouwu', 'gouwu');
INSERT INTO `cj_admin_icon_list` VALUES ('254', '1', 'fushi', 'iconfont icon-fushi', 'fushi');
INSERT INTO `cj_admin_icon_list` VALUES ('255', '1', 'jiaotong', 'iconfont icon-jiaotong', 'jiaotong');
INSERT INTO `cj_admin_icon_list` VALUES ('256', '1', 'yule', 'iconfont icon-yule', 'yule');
INSERT INTO `cj_admin_icon_list` VALUES ('257', '1', 'shejiao', 'iconfont icon-shejiao', 'shejiao');
INSERT INTO `cj_admin_icon_list` VALUES ('258', '1', 'jujia', 'iconfont icon-jujia', 'jujia');
INSERT INTO `cj_admin_icon_list` VALUES ('259', '1', 'tongxun', 'iconfont icon-tongxun', 'tongxun');
INSERT INTO `cj_admin_icon_list` VALUES ('260', '1', 'lingshi', 'iconfont icon-lingshi', 'lingshi');
INSERT INTO `cj_admin_icon_list` VALUES ('261', '1', 'meirong', 'iconfont icon-meirong', 'meirong');
INSERT INTO `cj_admin_icon_list` VALUES ('262', '1', 'yundong', 'iconfont icon-yundong', 'yundong');
INSERT INTO `cj_admin_icon_list` VALUES ('263', '1', 'lvxing', 'iconfont icon-lvxing', 'lvxing');
INSERT INTO `cj_admin_icon_list` VALUES ('264', '1', 'shuma', 'iconfont icon-shuma', 'shuma');
INSERT INTO `cj_admin_icon_list` VALUES ('265', '1', 'xuexi', 'iconfont icon-xuexi', 'xuexi');
INSERT INTO `cj_admin_icon_list` VALUES ('266', '1', 'yiliao', 'iconfont icon-yiliao', 'yiliao');
INSERT INTO `cj_admin_icon_list` VALUES ('267', '1', 'shuji', 'iconfont icon-shuji', 'shuji');
INSERT INTO `cj_admin_icon_list` VALUES ('268', '1', 'chongwu', 'iconfont icon-chongwu', 'chongwu');
INSERT INTO `cj_admin_icon_list` VALUES ('269', '1', 'caipiao1', 'iconfont icon-caipiao1', 'caipiao1');
INSERT INTO `cj_admin_icon_list` VALUES ('270', '1', 'qiche', 'iconfont icon-qiche', 'qiche');
INSERT INTO `cj_admin_icon_list` VALUES ('271', '1', 'bangong', 'iconfont icon-bangong', 'bangong');
INSERT INTO `cj_admin_icon_list` VALUES ('272', '1', 'zhufang', 'iconfont icon-zhufang', 'zhufang');
INSERT INTO `cj_admin_icon_list` VALUES ('273', '1', 'weixiu', 'iconfont icon-weixiu', 'weixiu');
INSERT INTO `cj_admin_icon_list` VALUES ('274', '1', 'haizi', 'iconfont icon-haizi', 'haizi');
INSERT INTO `cj_admin_icon_list` VALUES ('275', '1', 'changbei', 'iconfont icon-changbei', 'changbei');
INSERT INTO `cj_admin_icon_list` VALUES ('276', '1', 'liwu', 'iconfont icon-liwu', 'liwu');
INSERT INTO `cj_admin_icon_list` VALUES ('277', '1', 'lijin', 'iconfont icon-lijin', 'lijin');
INSERT INTO `cj_admin_icon_list` VALUES ('278', '1', 'huankuan', 'iconfont icon-huankuan', 'huankuan');
INSERT INTO `cj_admin_icon_list` VALUES ('279', '1', 'juanzeng', 'iconfont icon-juanzeng', 'juanzeng');
INSERT INTO `cj_admin_icon_list` VALUES ('280', '1', 'licai', 'iconfont icon-licai', 'licai');
INSERT INTO `cj_admin_icon_list` VALUES ('281', '1', 'gongzi', 'iconfont icon-gongzi', 'gongzi');
INSERT INTO `cj_admin_icon_list` VALUES ('282', '1', 'jianzhi', 'iconfont icon-jianzhi', 'jianzhi');
INSERT INTO `cj_admin_icon_list` VALUES ('283', '1', 'licaishouyi', 'iconfont icon-licaishouyi', 'licaishouyi');
INSERT INTO `cj_admin_icon_list` VALUES ('284', '1', 'qitashouru', 'iconfont icon-qitashouru', 'qitashouru');
INSERT INTO `cj_admin_icon_list` VALUES ('285', '1', 'zidingyileimu', 'iconfont icon-zidingyileimu', 'zidingyileimu');
INSERT INTO `cj_admin_icon_list` VALUES ('286', '1', 'tianjialeimu', 'iconfont icon-tianjialeimu', 'tianjialeimu');
INSERT INTO `cj_admin_icon_list` VALUES ('287', '1', 'zhifubaoa', 'iconfont icon-zhifubaoa', 'zhifubaoa');
INSERT INTO `cj_admin_icon_list` VALUES ('288', '1', 'zhifubaob', 'iconfont icon-zhifubaob', 'zhifubaob');
INSERT INTO `cj_admin_icon_list` VALUES ('289', '1', 'fuwuchuanga', 'iconfont icon-fuwuchuanga', 'fuwuchuanga');
INSERT INTO `cj_admin_icon_list` VALUES ('290', '1', 'fuwuchuangb', 'iconfont icon-fuwuchuangb', 'fuwuchuangb');
INSERT INTO `cj_admin_icon_list` VALUES ('291', '1', 'tansuoa', 'iconfont icon-tansuoa', 'tansuoa');
INSERT INTO `cj_admin_icon_list` VALUES ('292', '1', 'tansuob', 'iconfont icon-tansuob', 'tansuob');
INSERT INTO `cj_admin_icon_list` VALUES ('293', '1', 'caifua', 'iconfont icon-caifua', 'caifua');
INSERT INTO `cj_admin_icon_list` VALUES ('294', '1', 'caifub', 'iconfont icon-caifub', 'caifub');
INSERT INTO `cj_admin_icon_list` VALUES ('295', '1', 'logo', 'iconfont icon-logo', 'logo');
INSERT INTO `cj_admin_icon_list` VALUES ('296', '1', 'Excel', 'iconfont icon-Excel', 'Excel');
INSERT INTO `cj_admin_icon_list` VALUES ('297', '1', 'image', 'iconfont icon-image', 'image');
INSERT INTO `cj_admin_icon_list` VALUES ('298', '1', 'pdf', 'iconfont icon-pdf', 'pdf');
INSERT INTO `cj_admin_icon_list` VALUES ('299', '1', 'ppt', 'iconfont icon-ppt', 'ppt');
INSERT INTO `cj_admin_icon_list` VALUES ('300', '1', 'txt', 'iconfont icon-txt', 'txt');
INSERT INTO `cj_admin_icon_list` VALUES ('301', '1', 'word', 'iconfont icon-word', 'word');
INSERT INTO `cj_admin_icon_list` VALUES ('302', '1', 'zip', 'iconfont icon-zip', 'zip');
INSERT INTO `cj_admin_icon_list` VALUES ('303', '1', 'baocun', 'iconfont icon-baocun', 'baocun');
INSERT INTO `cj_admin_icon_list` VALUES ('304', '1', 'danao', 'iconfont icon-danao', 'danao');
INSERT INTO `cj_admin_icon_list` VALUES ('305', '1', 'dangan', 'iconfont icon-dangan', 'dangan');
INSERT INTO `cj_admin_icon_list` VALUES ('306', '1', 'dituchizi', 'iconfont icon-dituchizi', 'dituchizi');
INSERT INTO `cj_admin_icon_list` VALUES ('307', '1', 'ditujiayouzhan', 'iconfont icon-ditujiayouzhan', 'ditujiayouzhan');
INSERT INTO `cj_admin_icon_list` VALUES ('308', '1', 'dituzuzhijiagou', 'iconfont icon-dituzuzhijiagou', 'dituzuzhijiagou');
INSERT INTO `cj_admin_icon_list` VALUES ('309', '1', 'dituzuzhizhandian', 'iconfont icon-dituzuzhizhandian', 'dituzuzhizhandian');
INSERT INTO `cj_admin_icon_list` VALUES ('310', '1', 'dianchidianliang', 'iconfont icon-dianchidianliang', 'dianchidianliang');
INSERT INTO `cj_admin_icon_list` VALUES ('311', '1', 'dianhuaguhua', 'iconfont icon-dianhuaguhua', 'dianhuaguhua');
INSERT INTO `cj_admin_icon_list` VALUES ('312', '1', 'diannao', 'iconfont icon-diannao', 'diannao');
INSERT INTO `cj_admin_icon_list` VALUES ('313', '1', 'dingwei', 'iconfont icon-dingwei', 'dingwei');
INSERT INTO `cj_admin_icon_list` VALUES ('314', '1', 'fenpingduibi', 'iconfont icon-fenpingduibi', 'fenpingduibi');
INSERT INTO `cj_admin_icon_list` VALUES ('315', '1', 'fenxiang1', 'iconfont icon-fenxiang1', 'fenxiang1');
INSERT INTO `cj_admin_icon_list` VALUES ('316', '1', 'fuwuqi', 'iconfont icon-fuwuqi', 'fuwuqi');
INSERT INTO `cj_admin_icon_list` VALUES ('317', '1', 'fuwuqizhuji', 'iconfont icon-fuwuqizhuji', 'fuwuqizhuji');
INSERT INTO `cj_admin_icon_list` VALUES ('318', '1', 'fujian', 'iconfont icon-fujian', 'fujian');
INSERT INTO `cj_admin_icon_list` VALUES ('319', '1', 'fuzhibidui', 'iconfont icon-fuzhibidui', 'fuzhibidui');
INSERT INTO `cj_admin_icon_list` VALUES ('320', '1', 'guiji', 'iconfont icon-guiji', 'guiji');
INSERT INTO `cj_admin_icon_list` VALUES ('321', '1', 'huabanzhuti', 'iconfont icon-huabanzhuti', 'huabanzhuti');
INSERT INTO `cj_admin_icon_list` VALUES ('322', '1', 'jiazai', 'iconfont icon-jiazai', 'jiazai');
INSERT INTO `cj_admin_icon_list` VALUES ('323', '1', 'shejiaoqq', 'iconfont icon-shejiaoqq', 'shejiaoqq');
INSERT INTO `cj_admin_icon_list` VALUES ('324', '1', 'shejiaodingding', 'iconfont icon-shejiaodingding', 'shejiaodingding');
INSERT INTO `cj_admin_icon_list` VALUES ('325', '1', 'shejiaofeixin', 'iconfont icon-shejiaofeixin', 'shejiaofeixin');
INSERT INTO `cj_admin_icon_list` VALUES ('326', '1', 'shejiaomiliao', 'iconfont icon-shejiaomiliao', 'shejiaomiliao');
INSERT INTO `cj_admin_icon_list` VALUES ('327', '1', 'shejiaomomotubiao', 'iconfont icon-shejiaomomotubiao', 'shejiaomomotubiao');
INSERT INTO `cj_admin_icon_list` VALUES ('328', '1', 'shejiaoweibo', 'iconfont icon-shejiaoweibo', 'shejiaoweibo');
INSERT INTO `cj_admin_icon_list` VALUES ('329', '1', 'qiakoujiankongshexiangtou', 'iconfont icon-qiakoujiankongshexiangtou', 'qiakoujiankongshexiangtou');
INSERT INTO `cj_admin_icon_list` VALUES ('330', '1', 'shenpi', 'iconfont icon-shenpi', 'shenpi');
INSERT INTO `cj_admin_icon_list` VALUES ('331', '1', 'shijian1', 'iconfont icon-shijian1', 'shijian1');
INSERT INTO `cj_admin_icon_list` VALUES ('332', '1', 'shipin1', 'iconfont icon-shipin1', 'shipin1');
INSERT INTO `cj_admin_icon_list` VALUES ('333', '1', 'taishiji', 'iconfont icon-taishiji', 'taishiji');
INSERT INTO `cj_admin_icon_list` VALUES ('334', '1', 'tuandui', 'iconfont icon-tuandui', 'tuandui');
INSERT INTO `cj_admin_icon_list` VALUES ('335', '1', 'chenggong', 'iconfont icon-chenggong', 'chenggong');
INSERT INTO `cj_admin_icon_list` VALUES ('336', '1', 'jinggao', 'iconfont icon-jinggao', 'jinggao');
INSERT INTO `cj_admin_icon_list` VALUES ('337', '1', 'xinxi', 'iconfont icon-xinxi', 'xinxi');
INSERT INTO `cj_admin_icon_list` VALUES ('338', '1', 'shibai', 'iconfont icon-shibai', 'shibai');
INSERT INTO `cj_admin_icon_list` VALUES ('339', '1', 'xietong', 'iconfont icon-xietong', 'xietong');
INSERT INTO `cj_admin_icon_list` VALUES ('340', '1', 'xietongxitong', 'iconfont icon-xietongxitong', 'xietongxitong');
INSERT INTO `cj_admin_icon_list` VALUES ('341', '1', 'xinwen', 'iconfont icon-xinwen', 'xinwen');
INSERT INTO `cj_admin_icon_list` VALUES ('342', '1', 'xinwenbaozhi', 'iconfont icon-xinwenbaozhi', 'xinwenbaozhi');
INSERT INTO `cj_admin_icon_list` VALUES ('343', '1', 'nan', 'iconfont icon-nan', 'nan');
INSERT INTO `cj_admin_icon_list` VALUES ('344', '1', 'nv', 'iconfont icon-nv', 'nv');
INSERT INTO `cj_admin_icon_list` VALUES ('345', '1', 'niantie', 'iconfont icon-niantie', 'niantie');
INSERT INTO `cj_admin_icon_list` VALUES ('346', '1', 'zhandianwangzhanhulianwangie', 'iconfont icon-zhandianwangzhanhulianwangie', 'zhandianwangzhanhulianwangie');
INSERT INTO `cj_admin_icon_list` VALUES ('347', '1', 'zhangdan', 'iconfont icon-zhangdan', 'zhangdan');
INSERT INTO `cj_admin_icon_list` VALUES ('348', '1', 'jingdong', 'iconfont icon-jingdong', 'jingdong');
INSERT INTO `cj_admin_icon_list` VALUES ('349', '1', 'yinlian', 'iconfont icon-yinlian', 'yinlian');
INSERT INTO `cj_admin_icon_list` VALUES ('350', '1', 'zhifubao', 'iconfont icon-zhifubao', 'zhifubao');
INSERT INTO `cj_admin_icon_list` VALUES ('351', '1', 'zhiwen', 'iconfont icon-zhiwen', 'zhiwen');
INSERT INTO `cj_admin_icon_list` VALUES ('352', '1', 'guanxi', 'iconfont icon-guanxi', 'guanxi');
INSERT INTO `cj_admin_icon_list` VALUES ('353', '1', 'ziliaoshenfenzhengdangan', 'iconfont icon-ziliaoshenfenzhengdangan', 'ziliaoshenfenzhengdangan');
INSERT INTO `cj_admin_icon_list` VALUES ('354', '1', 'rss', 'iconfont icon-rss', 'rss');
INSERT INTO `cj_admin_icon_list` VALUES ('355', '1', 'USB', 'iconfont icon-USB', 'USB');
INSERT INTO `cj_admin_icon_list` VALUES ('356', '1', 'wifi', 'iconfont icon-wifi', 'wifi');
INSERT INTO `cj_admin_icon_list` VALUES ('357', '1', 'bianhaoliebiao', 'iconfont icon-bianhaoliebiao', 'bianhaoliebiao');
INSERT INTO `cj_admin_icon_list` VALUES ('358', '1', 'bianji1', 'iconfont icon-bianji1', 'bianji1');
INSERT INTO `cj_admin_icon_list` VALUES ('359', '1', 'bianqian', 'iconfont icon-bianqian', 'bianqian');
INSERT INTO `cj_admin_icon_list` VALUES ('360', '1', 'biaoqian', 'iconfont icon-biaoqian', 'biaoqian');
INSERT INTO `cj_admin_icon_list` VALUES ('361', '1', 'biaoqianzu', 'iconfont icon-biaoqianzu', 'biaoqianzu');
INSERT INTO `cj_admin_icon_list` VALUES ('362', '1', 'biaoge', 'iconfont icon-biaoge', 'biaoge');
INSERT INTO `cj_admin_icon_list` VALUES ('363', '1', 'biaoge1', 'iconfont icon-biaoge1', 'biaoge1');
INSERT INTO `cj_admin_icon_list` VALUES ('364', '1', 'bingtu', 'iconfont icon-bingtu', 'bingtu');
INSERT INTO `cj_admin_icon_list` VALUES ('365', '1', 'bofang', 'iconfont icon-bofang', 'bofang');
INSERT INTO `cj_admin_icon_list` VALUES ('366', '1', 'shang', 'iconfont icon-shang', 'shang');
INSERT INTO `cj_admin_icon_list` VALUES ('367', '1', 'xia', 'iconfont icon-xia', 'xia');
INSERT INTO `cj_admin_icon_list` VALUES ('368', '1', 'you', 'iconfont icon-you', 'you');
INSERT INTO `cj_admin_icon_list` VALUES ('369', '1', 'zuo', 'iconfont icon-zuo', 'zuo');
INSERT INTO `cj_admin_icon_list` VALUES ('370', '1', 'chaxun', 'iconfont icon-chaxun', 'chaxun');
INSERT INTO `cj_admin_icon_list` VALUES ('371', '1', 'danchu', 'iconfont icon-danchu', 'danchu');
INSERT INTO `cj_admin_icon_list` VALUES ('372', '1', 'denglu', 'iconfont icon-denglu', 'denglu');
INSERT INTO `cj_admin_icon_list` VALUES ('373', '1', 'diandeng', 'iconfont icon-diandeng', 'diandeng');
INSERT INTO `cj_admin_icon_list` VALUES ('374', '1', 'dianhua', 'iconfont icon-dianhua', 'dianhua');
INSERT INTO `cj_admin_icon_list` VALUES ('375', '1', 'duihao', 'iconfont icon-duihao', 'duihao');
INSERT INTO `cj_admin_icon_list` VALUES ('376', '1', 'fangxiang', 'iconfont icon-fangxiang', 'fangxiang');
INSERT INTO `cj_admin_icon_list` VALUES ('377', '1', 'feiji', 'iconfont icon-feiji', 'feiji');
INSERT INTO `cj_admin_icon_list` VALUES ('378', '1', 'fenxiang2', 'iconfont icon-fenxiang2', 'fenxiang2');
INSERT INTO `cj_admin_icon_list` VALUES ('379', '1', 'haoping', 'iconfont icon-haoping', 'haoping');
INSERT INTO `cj_admin_icon_list` VALUES ('380', '1', 'tuodong', 'iconfont icon-tuodong', 'tuodong');
INSERT INTO `cj_admin_icon_list` VALUES ('381', '1', 'kafei1', 'iconfont icon-kafei1', 'kafei1');
INSERT INTO `cj_admin_icon_list` VALUES ('382', '1', 'kuaijin', 'iconfont icon-kuaijin', 'kuaijin');
INSERT INTO `cj_admin_icon_list` VALUES ('383', '1', 'kuaitui', 'iconfont icon-kuaitui', 'kuaitui');
INSERT INTO `cj_admin_icon_list` VALUES ('384', '1', 'pinglun', 'iconfont icon-pinglun', 'pinglun');
INSERT INTO `cj_admin_icon_list` VALUES ('385', '1', 'pinglunzu', 'iconfont icon-pinglunzu', 'pinglunzu');
INSERT INTO `cj_admin_icon_list` VALUES ('386', '1', 'qizhi', 'iconfont icon-qizhi', 'qizhi');
INSERT INTO `cj_admin_icon_list` VALUES ('387', '1', 'renminbi', 'iconfont icon-renminbi', 'renminbi');
INSERT INTO `cj_admin_icon_list` VALUES ('388', '1', 'renwu', 'iconfont icon-renwu', 'renwu');
INSERT INTO `cj_admin_icon_list` VALUES ('389', '1', 'shujuku', 'iconfont icon-shujuku', 'shujuku');
INSERT INTO `cj_admin_icon_list` VALUES ('390', '1', 'tiaoxingma', 'iconfont icon-tiaoxingma', 'tiaoxingma');
INSERT INTO `cj_admin_icon_list` VALUES ('391', '1', 'wenjian', 'iconfont icon-wenjian', 'wenjian');
INSERT INTO `cj_admin_icon_list` VALUES ('392', '1', 'wenjianjia', 'iconfont icon-wenjianjia', 'wenjianjia');
INSERT INTO `cj_admin_icon_list` VALUES ('393', '1', 'dakai', 'iconfont icon-dakai', 'dakai');
INSERT INTO `cj_admin_icon_list` VALUES ('394', '1', 'wenben', 'iconfont icon-wenben', 'wenben');
INSERT INTO `cj_admin_icon_list` VALUES ('395', '1', 'wenjianzu', 'iconfont icon-wenjianzu', 'wenjianzu');
INSERT INTO `cj_admin_icon_list` VALUES ('396', '1', 'xiazai', 'iconfont icon-xiazai', 'xiazai');
INSERT INTO `cj_admin_icon_list` VALUES ('397', '1', 'xiantu', 'iconfont icon-xiantu', 'xiantu');
INSERT INTO `cj_admin_icon_list` VALUES ('398', '1', 'xinhao', 'iconfont icon-xinhao', 'xinhao');
INSERT INTO `cj_admin_icon_list` VALUES ('399', '1', 'yidongshebei', 'iconfont icon-yidongshebei', 'yidongshebei');
INSERT INTO `cj_admin_icon_list` VALUES ('400', '1', 'yonghu', 'iconfont icon-yonghu', 'yonghu');
INSERT INTO `cj_admin_icon_list` VALUES ('401', '1', 'yuanxing', 'iconfont icon-yuanxing', 'yuanxing');
INSERT INTO `cj_admin_icon_list` VALUES ('402', '1', 'zhexiantu', 'iconfont icon-zhexiantu', 'zhexiantu');
INSERT INTO `cj_admin_icon_list` VALUES ('403', '1', 'zhongzuo', 'iconfont icon-zhongzuo', 'zhongzuo');
INSERT INTO `cj_admin_icon_list` VALUES ('404', '1', 'bijibendiannao', 'iconfont icon-bijibendiannao', 'bijibendiannao');
INSERT INTO `cj_admin_icon_list` VALUES ('405', '1', 'zihangche', 'iconfont icon-zihangche', 'zihangche');
INSERT INTO `cj_admin_icon_list` VALUES ('406', '1', 'jingcha', 'iconfont icon-jingcha', 'jingcha');

-- ----------------------------
-- Table structure for cj_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_log`;
CREATE TABLE `cj_admin_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '行为id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(50) NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `record_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '触发行为的数据id',
  `remark` longtext NOT NULL COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `action_ip_ix` (`action_ip`) USING BTREE,
  KEY `action_id_ix` (`action_id`) USING BTREE,
  KEY `user_id_ix` (`user_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=156 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='行为日志表';

-- ----------------------------
-- Records of cj_admin_log
-- ----------------------------
INSERT INTO `cj_admin_log` VALUES ('1', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：门户', '1', '1532137775');
INSERT INTO `cj_admin_log` VALUES ('2', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：马术', '1', '1532137840');
INSERT INTO `cj_admin_log` VALUES ('3', '36', '1', '2130706433', 'admin_module', '0', '超级管理员 卸载了模块：马术', '1', '1532137864');
INSERT INTO `cj_admin_log` VALUES ('4', '57', '1', '2130706433', 'cms_model', '1', '超级管理员 添加了内容模型：测试', '1', '1532138364');
INSERT INTO `cj_admin_log` VALUES ('5', '30', '1', '2130706433', 'admin_menu', '331', '超级管理员 添加了节点：所属模块(admin),所属节点ID(33),节点标题(新增),节点链接(admin/module/add)', '1', '1532139502');
INSERT INTO `cj_admin_log` VALUES ('6', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：马术', '1', '1532142171');
INSERT INTO `cj_admin_log` VALUES ('7', '36', '1', '2130706433', 'admin_module', '0', '超级管理员 卸载了模块：马术', '1', '1532142182');
INSERT INTO `cj_admin_log` VALUES ('8', '36', '1', '2130706433', 'admin_module', '0', '超级管理员 卸载了模块：马术', '1', '1532146829');
INSERT INTO `cj_admin_log` VALUES ('9', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：马术', '1', '1532146841');
INSERT INTO `cj_admin_log` VALUES ('10', '30', '1', '2130706433', 'admin_menu', '334', '超级管理员 添加了节点：所属模块(mashu),所属节点ID(333),节点标题(模型管理),节点链接(mashu/user/index)', '1', '1532147149');
INSERT INTO `cj_admin_log` VALUES ('11', '32', '1', '2130706433', 'admin_menu', '334', '超级管理员 删除了节点：节点ID(334),节点标题(模型管理),节点链接(mashu/user/index)', '1', '1532151952');
INSERT INTO `cj_admin_log` VALUES ('12', '30', '1', '2130706433', 'admin_menu', '335', '超级管理员 添加了节点：所属模块(mashu),所属节点ID(333),节点标题(模型管理),节点链接(mashu/user/index)', '1', '1532151988');
INSERT INTO `cj_admin_log` VALUES ('13', '32', '1', '2130706433', 'admin_menu', '337', '超级管理员 删除了节点：节点ID(337),节点标题(编辑),节点链接(mashu/user/edit)', '1', '1532152059');
INSERT INTO `cj_admin_log` VALUES ('14', '31', '1', '2130706433', 'admin_menu', '339', '超级管理员 编辑了节点：节点ID(339)', '1', '1532152078');
INSERT INTO `cj_admin_log` VALUES ('15', '30', '1', '2130706433', 'admin_menu', '342', '超级管理员 添加了节点：所属模块(mashu),所属节点ID(335),节点标题(编辑),节点链接(mashu/user/edit)', '1', '1532152120');
INSERT INTO `cj_admin_log` VALUES ('16', '32', '1', '2130706433', 'admin_menu', '342', '超级管理员 删除了节点：节点ID(342),节点标题(编辑),节点链接(mashu/user/edit)', '1', '1532152139');
INSERT INTO `cj_admin_log` VALUES ('17', '32', '1', '2130706433', 'admin_menu', '335', '超级管理员 删除了节点：节点ID(335),节点标题(模型管理),节点链接(mashu/user/index)', '1', '1532152150');
INSERT INTO `cj_admin_log` VALUES ('18', '30', '1', '2130706433', 'admin_menu', '343', '超级管理员 添加了节点：所属模块(mashu),所属节点ID(333),节点标题(模型管理),节点链接(mashu/user/index)', '1', '1532152171');
INSERT INTO `cj_admin_log` VALUES ('19', '30', '1', '2130706433', 'admin_menu', '344', '超级管理员 添加了节点：所属模块(mashu),所属节点ID(343),节点标题(新增),节点链接(mashu/user/add)', '1', '1532152203');
INSERT INTO `cj_admin_log` VALUES ('20', '30', '1', '2130706433', 'admin_menu', '345', '超级管理员 添加了节点：所属模块(mashu),所属节点ID(343),节点标题(编辑),节点链接(mashu/user/edit)', '1', '1532152222');
INSERT INTO `cj_admin_log` VALUES ('21', '30', '1', '2130706433', 'admin_menu', '346', '超级管理员 添加了节点：所属模块(mashu),所属节点ID(343),节点标题(删除),节点链接(mashu/user/delete)', '1', '1532152275');
INSERT INTO `cj_admin_log` VALUES ('22', '30', '1', '2130706433', 'admin_menu', '347', '超级管理员 添加了节点：所属模块(mashu),所属节点ID(343),节点标题(子段管理),节点链接(admin/field/index)', '1', '1532154716');
INSERT INTO `cj_admin_log` VALUES ('23', '31', '1', '2130706433', 'admin_menu', '347', '超级管理员 编辑了节点：节点ID(347)', '1', '1532154755');
INSERT INTO `cj_admin_log` VALUES ('24', '32', '1', '2130706433', 'admin_menu', '347', '超级管理员 删除了节点：节点ID(347),节点标题(字段管理),节点链接(admin/field/index)', '1', '1532154945');
INSERT INTO `cj_admin_log` VALUES ('25', '30', '1', '2130706433', 'admin_menu', '348', '超级管理员 添加了节点：所属模块(mashu),所属节点ID(343),节点标题(字段管理),节点链接(admin/field/index)', '1', '1532154981');
INSERT INTO `cj_admin_log` VALUES ('26', '30', '1', '2130706433', 'admin_menu', '349', '超级管理员 添加了节点：所属模块(mashu),所属节点ID(348),节点标题(新增),节点链接(admin/field/add)', '1', '1532155005');
INSERT INTO `cj_admin_log` VALUES ('27', '30', '1', '2130706433', 'admin_menu', '350', '超级管理员 添加了节点：所属模块(mashu),所属节点ID(349),节点标题(编辑),节点链接(admin/field/edit)', '1', '1532155057');
INSERT INTO `cj_admin_log` VALUES ('28', '32', '1', '2130706433', 'admin_menu', '350', '超级管理员 删除了节点：节点ID(350),节点标题(编辑),节点链接(admin/field/edit)', '1', '1532155074');
INSERT INTO `cj_admin_log` VALUES ('29', '30', '1', '2130706433', 'admin_menu', '351', '超级管理员 添加了节点：所属模块(mashu),所属节点ID(348),节点标题(编辑),节点链接(admin/field/edit)', '1', '1532155086');
INSERT INTO `cj_admin_log` VALUES ('30', '30', '1', '2130706433', 'admin_menu', '352', '超级管理员 添加了节点：所属模块(mashu),所属节点ID(348),节点标题(删除),节点链接(admin/field/delete)', '1', '1532155144');
INSERT INTO `cj_admin_log` VALUES ('31', '31', '1', '2130706433', 'admin_menu', '344', '超级管理员 编辑了节点：节点ID(344)', '1', '1532164098');
INSERT INTO `cj_admin_log` VALUES ('32', '31', '1', '2130706433', 'admin_menu', '344', '超级管理员 编辑了节点：节点ID(344)', '1', '1532164156');
INSERT INTO `cj_admin_log` VALUES ('33', '34', '1', '2130706433', 'admin_menu', '344', '超级管理员 禁用了节点：节点ID(344),节点标题(新增),节点链接(mashu/user/add)', '1', '1532164314');
INSERT INTO `cj_admin_log` VALUES ('34', '34', '1', '2130706433', 'admin_menu', '345', '超级管理员 禁用了节点：节点ID(345),节点标题(编辑),节点链接(mashu/user/edit)', '1', '1532164316');
INSERT INTO `cj_admin_log` VALUES ('35', '34', '1', '2130706433', 'admin_menu', '346', '超级管理员 禁用了节点：节点ID(346),节点标题(删除),节点链接(mashu/user/delete)', '1', '1532164318');
INSERT INTO `cj_admin_log` VALUES ('36', '34', '1', '2130706433', 'admin_menu', '348', '超级管理员 禁用了节点：节点ID(348),节点标题(字段管理),节点链接(admin/field/index)', '1', '1532164321');
INSERT INTO `cj_admin_log` VALUES ('37', '15', '1', '2130706433', 'admin_config', '40', '超级管理员 添加了配置，详情：分组(system)、类型(array)、标题(数据库数据类型)、名称(database_data_type)', '1', '1532168360');
INSERT INTO `cj_admin_log` VALUES ('38', '16', '1', '2130706433', 'admin_config', '40', '超级管理员 编辑了配置：原数据：分组(system)、类型(array)、标题(数据库数据类型)、名称(database_data_type)', '1', '1532168488');
INSERT INTO `cj_admin_log` VALUES ('39', '16', '1', '2130706433', 'admin_config', '40', '超级管理员 编辑了配置：原数据：分组(system)、类型(array)、标题(数据库数据类型)、名称(database_data_type)', '1', '1532168548');
INSERT INTO `cj_admin_log` VALUES ('40', '16', '1', '2130706433', 'admin_config', '40', '超级管理员 编辑了配置：原数据：分组(system)、类型(array)、标题(数据库数据类型)、名称(database_data_type)', '1', '1532168729');
INSERT INTO `cj_admin_log` VALUES ('41', '16', '1', '2130706433', 'admin_config', '40', '超级管理员 编辑了配置：原数据：分组(system)、类型(linkages)、标题(数据库数据类型)、名称(database_data_type)', '1', '1532169020');
INSERT INTO `cj_admin_log` VALUES ('42', '42', '1', '2130706433', 'admin_config', '0', '超级管理员 更新了系统设置：分组(system)', '1', '1532169368');
INSERT INTO `cj_admin_log` VALUES ('43', '42', '1', '2130706433', 'admin_config', '0', '超级管理员 更新了系统设置：分组(system)', '1', '1532170282');
INSERT INTO `cj_admin_log` VALUES ('44', '39', '1', '2130706433', 'admin_module', '0', '超级管理员 导出了模块：马术', '1', '1532172770');
INSERT INTO `cj_admin_log` VALUES ('45', '36', '1', '2130706433', 'admin_module', '0', '超级管理员 卸载了模块：测试', '1', '1532173031');
INSERT INTO `cj_admin_log` VALUES ('46', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：测试', '1', '1532173042');
INSERT INTO `cj_admin_log` VALUES ('47', '36', '1', '2130706433', 'admin_module', '0', '超级管理员 卸载了模块：测试', '1', '1532173447');
INSERT INTO `cj_admin_log` VALUES ('48', '36', '1', '2130706433', 'admin_module', '0', '超级管理员 卸载了模块：测试', '1', '1532173597');
INSERT INTO `cj_admin_log` VALUES ('49', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：测试', '1', '1532173607');
INSERT INTO `cj_admin_log` VALUES ('50', '36', '1', '2130706433', 'admin_module', '0', '超级管理员 卸载了模块：小马哥', '1', '1532174510');
INSERT INTO `cj_admin_log` VALUES ('51', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：小马哥', '1', '1532174519');
INSERT INTO `cj_admin_log` VALUES ('52', '36', '1', '2130706433', 'admin_module', '0', '超级管理员 卸载了模块：测试', '1', '1532174846');
INSERT INTO `cj_admin_log` VALUES ('53', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：测试', '1', '1532174854');
INSERT INTO `cj_admin_log` VALUES ('54', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：测试', '1', '1532178239');
INSERT INTO `cj_admin_log` VALUES ('55', '30', '1', '2130706433', 'admin_menu', '398', '超级管理员 添加了节点：所属模块(admin),所属节点ID(33),节点标题(新增),节点链接(admin/module/add)', '1', '1532229273');
INSERT INTO `cj_admin_log` VALUES ('56', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：商城模块', '1', '1532229668');
INSERT INTO `cj_admin_log` VALUES ('57', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：商城', '1', '1532311225');
INSERT INTO `cj_admin_log` VALUES ('58', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：商城', '1', '1532311226');
INSERT INTO `cj_admin_log` VALUES ('59', '36', '1', '2130706433', 'admin_module', '0', '超级管理员 卸载了模块：商城', '1', '1532311445');
INSERT INTO `cj_admin_log` VALUES ('60', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：商城', '1', '1532311580');
INSERT INTO `cj_admin_log` VALUES ('61', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：商城', '1', '1532311581');
INSERT INTO `cj_admin_log` VALUES ('62', '16', '1', '2130706433', 'admin_config', '1', '超级管理员 编辑了配置：字段(title)，原值(站点开关)，新值：(站点开)', '1', '1532315916');
INSERT INTO `cj_admin_log` VALUES ('63', '16', '1', '2130706433', 'admin_config', '1', '超级管理员 编辑了配置：字段(title)，原值(站点开)，新值：(站点开关)', '1', '1532315924');
INSERT INTO `cj_admin_log` VALUES ('64', '30', '1', '2130706433', 'admin_menu', '444', '超级管理员 添加了节点：所属模块(admin),所属节点ID(33),节点标题(添加节点),节点链接(admin/fieldnode/index)', '1', '1532324929');
INSERT INTO `cj_admin_log` VALUES ('65', '7', '1', '2130706433', 'admin_role', '2', '超级管理员 添加了角色：协管员', '1', '1532329143');
INSERT INTO `cj_admin_log` VALUES ('66', '8', '1', '2130706433', 'admin_role', '2', '超级管理员 编辑了角色：字段(access)，原值(0)，新值：(true)', '1', '1532329173');
INSERT INTO `cj_admin_log` VALUES ('67', '1', '1', '2130706433', 'admin_user', '2', '超级管理员 添加了用户：的撒打算', '1', '1532329203');
INSERT INTO `cj_admin_log` VALUES ('68', '31', '1', '2130706433', 'admin_menu', '444', '超级管理员 编辑了节点：节点ID(444)', '1', '1532331158');
INSERT INTO `cj_admin_log` VALUES ('69', '30', '1', '2130706433', 'admin_menu', '452', '超级管理员 添加了节点：所属模块(admin),所属节点ID(33),节点标题(节点编辑),节点链接(admin/fieldnode/edit)', '1', '1532331225');
INSERT INTO `cj_admin_log` VALUES ('70', '30', '1', '2130706433', 'admin_menu', '453', '超级管理员 添加了节点：所属模块(admin),所属节点ID(33),节点标题(节点删除),节点链接(admin/fieldnode/delete)', '1', '1532331307');
INSERT INTO `cj_admin_log` VALUES ('71', '30', '1', '2130706433', 'admin_menu', '454', '超级管理员 添加了节点：所属模块(admin),所属节点ID(33),节点标题(节点添加),节点链接(admin/fieldnode/add)', '1', '1532331333');
INSERT INTO `cj_admin_log` VALUES ('72', '30', '1', '2130706433', 'admin_menu', '455', '超级管理员 添加了节点：所属模块(shop),所属节点ID(451),节点标题(新增会员),节点链接(shop/user/add)', '1', '1532332673');
INSERT INTO `cj_admin_log` VALUES ('73', '31', '1', '2130706433', 'admin_menu', '455', '超级管理员 编辑了节点：节点ID(455)', '1', '1532332826');
INSERT INTO `cj_admin_log` VALUES ('74', '31', '1', '2130706433', 'admin_menu', '455', '超级管理员 编辑了节点：节点ID(455)', '1', '1532332904');
INSERT INTO `cj_admin_log` VALUES ('75', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333022');
INSERT INTO `cj_admin_log` VALUES ('76', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333052');
INSERT INTO `cj_admin_log` VALUES ('77', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333097');
INSERT INTO `cj_admin_log` VALUES ('78', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333111');
INSERT INTO `cj_admin_log` VALUES ('79', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333293');
INSERT INTO `cj_admin_log` VALUES ('80', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333338');
INSERT INTO `cj_admin_log` VALUES ('81', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333481');
INSERT INTO `cj_admin_log` VALUES ('82', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333491');
INSERT INTO `cj_admin_log` VALUES ('83', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333567');
INSERT INTO `cj_admin_log` VALUES ('84', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333614');
INSERT INTO `cj_admin_log` VALUES ('85', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333646');
INSERT INTO `cj_admin_log` VALUES ('86', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333693');
INSERT INTO `cj_admin_log` VALUES ('87', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333717');
INSERT INTO `cj_admin_log` VALUES ('88', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333750');
INSERT INTO `cj_admin_log` VALUES ('89', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333809');
INSERT INTO `cj_admin_log` VALUES ('90', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333839');
INSERT INTO `cj_admin_log` VALUES ('91', '31', '1', '2130706433', 'admin_menu', '427', '超级管理员 编辑了节点：节点ID(427)', '1', '1532333873');
INSERT INTO `cj_admin_log` VALUES ('92', '31', '1', '2130706433', 'admin_menu', '427', '超级管理员 编辑了节点：节点ID(427)', '1', '1532333926');
INSERT INTO `cj_admin_log` VALUES ('93', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532333967');
INSERT INTO `cj_admin_log` VALUES ('94', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532334089');
INSERT INTO `cj_admin_log` VALUES ('95', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532334104');
INSERT INTO `cj_admin_log` VALUES ('96', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532334201');
INSERT INTO `cj_admin_log` VALUES ('97', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532334223');
INSERT INTO `cj_admin_log` VALUES ('98', '32', '1', '2130706433', 'admin_menu', '451', '超级管理员 删除了节点：节点ID(451),节点标题(会员),节点链接(shop/member/index)', '1', '1532334568');
INSERT INTO `cj_admin_log` VALUES ('99', '30', '1', '2130706433', 'admin_menu', '458', '超级管理员 添加了节点：所属模块(shop),所属节点ID(457),节点标题(商品分类),节点链接(shop/goods/add)', '1', '1532335602');
INSERT INTO `cj_admin_log` VALUES ('100', '30', '1', '2130706433', 'admin_menu', '460', '超级管理员 添加了节点：所属模块(admin),所属节点ID(33),节点标题(模块配置信息),节点链接(add/moduleconfig/index)', '1', '1532412266');
INSERT INTO `cj_admin_log` VALUES ('101', '31', '1', '2130706433', 'admin_menu', '460', '超级管理员 编辑了节点：节点ID(460)', '1', '1532412379');
INSERT INTO `cj_admin_log` VALUES ('102', '32', '1', '2130706433', 'admin_menu', '460', '超级管理员 删除了节点：节点ID(460),节点标题(模块配置信息),节点链接(admin/moduleconfig/index)', '1', '1532412392');
INSERT INTO `cj_admin_log` VALUES ('103', '30', '1', '2130706433', 'admin_menu', '467', '超级管理员 添加了节点：所属模块(admin),所属节点ID(33),节点标题(模块配置信息),节点链接(admin/moduleconfig/index)', '1', '1532412418');
INSERT INTO `cj_admin_log` VALUES ('104', '16', '1', '2130706433', 'admin_config', '1', '超级管理员 编辑了配置：字段(title)，原值(站点开关)，新值：(站点开关1)', '1', '1532484190');
INSERT INTO `cj_admin_log` VALUES ('105', '16', '1', '2130706433', 'admin_config', '1', '超级管理员 编辑了配置：字段(title)，原值(站点开关1)，新值：(站点开关)', '1', '1532484196');
INSERT INTO `cj_admin_log` VALUES ('106', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：门户', '1', '1532485010');
INSERT INTO `cj_admin_log` VALUES ('107', '36', '1', '2130706433', 'admin_module', '0', '超级管理员 卸载了模块：门户', '1', '1532495511');
INSERT INTO `cj_admin_log` VALUES ('108', '16', '1', '2130706433', 'admin_config', '11', '超级管理员 编辑了配置：原数据：分组(system)、类型(array)、标题(配置类型)、名称(form_item_type)', '1', '1532501081');
INSERT INTO `cj_admin_log` VALUES ('109', '32', '1', '2130706433', 'admin_menu', '582', '超级管理员 删除了节点：节点ID(582),节点标题(用户金额),节点链接(shop/usermoney/index)', '1', '1532506617');
INSERT INTO `cj_admin_log` VALUES ('110', '30', '1', '2130706433', 'admin_menu', '583', '超级管理员 添加了节点：所属模块(shop),所属节点ID(580),节点标题(新增),节点链接(shop/menber/add)', '1', '1532506668');
INSERT INTO `cj_admin_log` VALUES ('111', '42', '1', '2130706433', 'admin_config', '0', '超级管理员 更新了系统设置：分组(base)', '1', '1532567873');
INSERT INTO `cj_admin_log` VALUES ('112', '42', '1', '2130706433', 'admin_config', '0', '超级管理员 更新了系统设置：分组(base)', '1', '1532567891');
INSERT INTO `cj_admin_log` VALUES ('113', '30', '1', '2130706433', 'admin_menu', '584', '超级管理员 添加了节点：所属模块(shop),所属节点ID(427),节点标题(按钮配置),节点链接(shop/databasetable/buttonlist)', '1', '1532569288');
INSERT INTO `cj_admin_log` VALUES ('114', '34', '1', '2130706433', 'admin_menu', '584', '超级管理员 禁用了节点：节点ID(584),节点标题(按钮配置),节点链接(shop/databasetable/buttonlist)', '1', '1532569298');
INSERT INTO `cj_admin_log` VALUES ('115', '31', '1', '2130706433', 'admin_menu', '585', '超级管理员 编辑了节点：节点ID(585)', '1', '1532570070');
INSERT INTO `cj_admin_log` VALUES ('116', '31', '1', '2130706433', 'admin_menu', '586', '超级管理员 编辑了节点：节点ID(586)', '1', '1532570087');
INSERT INTO `cj_admin_log` VALUES ('117', '31', '1', '2130706433', 'admin_menu', '587', '超级管理员 编辑了节点：节点ID(587)', '1', '1532570101');
INSERT INTO `cj_admin_log` VALUES ('118', '32', '1', '2130706433', 'admin_menu', '588', '超级管理员 删除了节点：节点ID(588),节点标题(启用),节点链接(shop/databasetable/enable)', '1', '1532570113');
INSERT INTO `cj_admin_log` VALUES ('119', '32', '1', '2130706433', 'admin_menu', '589', '超级管理员 删除了节点：节点ID(589),节点标题(禁用),节点链接(shop/databasetable/disable)', '1', '1532570118');
INSERT INTO `cj_admin_log` VALUES ('120', '31', '1', '2130706433', 'admin_menu', '590', '超级管理员 编辑了节点：节点ID(590)', '1', '1532570128');
INSERT INTO `cj_admin_log` VALUES ('121', '32', '1', '2130706433', 'admin_menu', '584', '超级管理员 删除了节点：节点ID(584),节点标题(按钮配置),节点链接(shop/databasetable/buttonlist)', '1', '1532570932');
INSERT INTO `cj_admin_log` VALUES ('122', '30', '1', '2130706433', 'admin_menu', '591', '超级管理员 添加了节点：所属模块(shop),所属节点ID(427),节点标题(按钮配置),节点链接(shop/databasetable/buttonlist)', '1', '1532571015');
INSERT INTO `cj_admin_log` VALUES ('123', '34', '1', '2130706433', 'admin_menu', '591', '超级管理员 禁用了节点：节点ID(591),节点标题(按钮配置),节点链接(shop/databasetable/buttonlist)', '1', '1532571020');
INSERT INTO `cj_admin_log` VALUES ('124', '30', '1', '2130706433', 'admin_menu', '592', '超级管理员 添加了节点：所属模块(shop),所属节点ID(591),节点标题(新增按钮),节点链接(shop/databasetable/buttonlistadd)', '1', '1532571667');
INSERT INTO `cj_admin_log` VALUES ('125', '32', '1', '2130706433', 'admin_menu', '591', '超级管理员 删除了节点：节点ID(591),节点标题(按钮配置),节点链接(shop/databasetable/buttonlist)', '1', '1532582037');
INSERT INTO `cj_admin_log` VALUES ('126', '30', '1', '2130706433', 'admin_menu', '593', '超级管理员 添加了节点：所属模块(admin),所属节点ID(33),节点标题(模型按钮配置),节点链接(admin/button/index)', '1', '1532582099');
INSERT INTO `cj_admin_log` VALUES ('127', '34', '1', '2130706433', 'admin_menu', '593', '超级管理员 禁用了节点：节点ID(593),节点标题(模型按钮配置),节点链接(admin/button/index)', '1', '1532582121');
INSERT INTO `cj_admin_log` VALUES ('128', '33', '1', '2130706433', 'admin_menu', '593', '超级管理员 启用了节点：节点ID(593),节点标题(模型按钮配置),节点链接(admin/button/index)', '1', '1532582140');
INSERT INTO `cj_admin_log` VALUES ('129', '30', '1', '2130706433', 'admin_menu', '600', '超级管理员 添加了节点：所属模块(admin),所属节点ID(33),节点标题(生成校验规则),节点链接(admin/field/field_checkout)', '1', '1532698767');
INSERT INTO `cj_admin_log` VALUES ('130', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：门户', '1', '1532736129');
INSERT INTO `cj_admin_log` VALUES ('131', '36', '1', '2130706433', 'admin_module', '0', '超级管理员 卸载了模块：门户', '1', '1532736146');
INSERT INTO `cj_admin_log` VALUES ('132', '30', '1', '2130706433', 'admin_menu', '694', '超级管理员 添加了节点：所属模块(admin),所属节点ID(33),节点标题(生成菜单节点),节点链接(admin/field/generate_menu)', '1', '1532736901');
INSERT INTO `cj_admin_log` VALUES ('133', '31', '1', '2130706433', 'admin_menu', '578', '超级管理员 编辑了节点：节点ID(578)', '1', '1532740225');
INSERT INTO `cj_admin_log` VALUES ('134', '31', '1', '2130706433', 'admin_menu', '580', '超级管理员 编辑了节点：节点ID(580)', '1', '1532740245');
INSERT INTO `cj_admin_log` VALUES ('135', '31', '1', '2130706433', 'admin_menu', '426', '超级管理员 编辑了节点：节点ID(426)', '1', '1532740461');
INSERT INTO `cj_admin_log` VALUES ('136', '31', '1', '2130706433', 'admin_menu', '580', '超级管理员 编辑了节点：节点ID(580)', '1', '1532740493');
INSERT INTO `cj_admin_log` VALUES ('137', '31', '1', '2130706433', 'admin_menu', '580', '超级管理员 编辑了节点：节点ID(580)', '1', '1532740506');
INSERT INTO `cj_admin_log` VALUES ('138', '31', '1', '2130706433', 'admin_menu', '580', '超级管理员 编辑了节点：节点ID(580)', '1', '1532740525');
INSERT INTO `cj_admin_log` VALUES ('139', '31', '1', '2130706433', 'admin_menu', '580', '超级管理员 编辑了节点：节点ID(580)', '1', '1532740555');
INSERT INTO `cj_admin_log` VALUES ('140', '31', '1', '2130706433', 'admin_menu', '580', '超级管理员 编辑了节点：节点ID(580)', '1', '1532740631');
INSERT INTO `cj_admin_log` VALUES ('141', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：测试', '1', '1533028038');
INSERT INTO `cj_admin_log` VALUES ('142', '30', '1', '2130706433', 'admin_menu', '719', '超级管理员 添加了节点：所属模块(ceshi),所属节点ID(712),节点标题(会员管理),节点链接(ceshi/member/index)', '1', '1533029098');
INSERT INTO `cj_admin_log` VALUES ('143', '30', '1', '2130706433', 'admin_menu', '727', '超级管理员 添加了节点：所属模块(shop),所属节点ID(427),节点标题(参数配置),节点链接(shop/databasetable/getConfigureList)', '1', '1533087168');
INSERT INTO `cj_admin_log` VALUES ('144', '34', '1', '2130706433', 'admin_menu', '727', '超级管理员 禁用了节点：节点ID(727),节点标题(参数配置),节点链接(shop/databasetable/getconfigurelist)', '1', '1533087173');
INSERT INTO `cj_admin_log` VALUES ('145', '30', '1', '2130706433', 'admin_menu', '728', '超级管理员 添加了节点：所属模块(shop),所属节点ID(580),节点标题(编辑),节点链接(shop/userlist/edit)', '1', '1533088560');
INSERT INTO `cj_admin_log` VALUES ('146', '30', '1', '2130706433', 'admin_menu', '729', '超级管理员 添加了节点：所属模块(admin),所属节点ID(41),节点标题(新增插件),节点链接(admin/plugin/addplug)', '1', '1533092148');
INSERT INTO `cj_admin_log` VALUES ('147', '25', '1', '2130706433', 'admin_hook', '18', '超级管理员 添加了钩子：user_list', '1', '1533105057');
INSERT INTO `cj_admin_log` VALUES ('148', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：测试', '1', '1533108919');
INSERT INTO `cj_admin_log` VALUES ('149', '31', '1', '2130706433', 'admin_menu', '754', '超级管理员 编辑了节点：节点ID(754)', '1', '1533109120');
INSERT INTO `cj_admin_log` VALUES ('150', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：测试模块', '1', '1533109877');
INSERT INTO `cj_admin_log` VALUES ('151', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：测试模块', '1', '1533110343');
INSERT INTO `cj_admin_log` VALUES ('152', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：测试模块', '1', '1533110835');
INSERT INTO `cj_admin_log` VALUES ('153', '31', '1', '2130706433', 'admin_menu', '788', '超级管理员 编辑了节点：节点ID(788)', '1', '1533111542');
INSERT INTO `cj_admin_log` VALUES ('154', '31', '1', '2130706433', 'admin_menu', '789', '超级管理员 编辑了节点：节点ID(789)', '1', '1533111566');
INSERT INTO `cj_admin_log` VALUES ('155', '39', '1', '2130706433', 'admin_module', '0', '超级管理员 导出了模块：商城', '1', '1533113111');

-- ----------------------------
-- Table structure for cj_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_menu`;
CREATE TABLE `cj_admin_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单id',
  `module` varchar(16) NOT NULL DEFAULT '' COMMENT '模块名称',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '菜单标题',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '菜单图标',
  `url_type` varchar(16) NOT NULL DEFAULT '' COMMENT '链接类型（link：外链，module：模块）',
  `url_value` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `url_target` varchar(16) NOT NULL DEFAULT '_self' COMMENT '链接打开方式：_blank,_self',
  `online_hide` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '网站上线后是否隐藏',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `system_menu` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统菜单，系统菜单不可删除',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `params` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=800 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='后台菜单表';

-- ----------------------------
-- Records of cj_admin_menu
-- ----------------------------
INSERT INTO `cj_admin_menu` VALUES ('1', '0', 'admin', '首页', 'fa fa-fw fa-home', 'module_admin', 'admin/index/index', '_self', '0', '1467617722', '1477710540', '1', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('2', '1', 'admin', '快捷操作', 'fa fa-fw fa-folder-open-o', 'module_admin', '', '_self', '0', '1467618170', '1477710695', '1', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('3', '2', 'admin', '清空缓存', 'fa fa-fw fa-trash-o', 'module_admin', 'admin/index/wipecache', '_self', '0', '1467618273', '1489049773', '3', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('4', '0', 'admin', '系统', 'fa fa-fw fa-gear', 'module_admin', 'admin/system/index', '_self', '0', '1467618361', '1477710540', '2', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('5', '4', 'admin', '系统功能', 'si si-wrench', 'module_admin', '', '_self', '0', '1467618441', '1477710695', '1', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('6', '5', 'admin', '系统设置', 'fa fa-fw fa-wrench', 'module_admin', 'admin/system/index', '_self', '0', '1467618490', '1477710695', '1', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('7', '5', 'admin', '配置管理', 'fa fa-fw fa-gears', 'module_admin', 'admin/config/index', '_self', '0', '1467618618', '1477710695', '2', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('8', '7', 'admin', '新增', '', 'module_admin', 'admin/config/add', '_self', '0', '1467618648', '1477710695', '1', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('9', '7', 'admin', '编辑', '', 'module_admin', 'admin/config/edit', '_self', '0', '1467619566', '1477710695', '2', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('10', '7', 'admin', '删除', '', 'module_admin', 'admin/config/delete', '_self', '0', '1467619583', '1477710695', '3', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('11', '7', 'admin', '启用', '', 'module_admin', 'admin/config/enable', '_self', '0', '1467619609', '1477710695', '4', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('12', '7', 'admin', '禁用', '', 'module_admin', 'admin/config/disable', '_self', '0', '1467619637', '1477710695', '5', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('13', '5', 'admin', '节点管理', 'fa fa-fw fa-bars', 'module_admin', 'admin/menu/index', '_self', '0', '1467619882', '1477710695', '3', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('14', '13', 'admin', '新增', '', 'module_admin', 'admin/menu/add', '_self', '0', '1467619902', '1477710695', '1', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('15', '13', 'admin', '编辑', '', 'module_admin', 'admin/menu/edit', '_self', '0', '1467620331', '1477710695', '2', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('16', '13', 'admin', '删除', '', 'module_admin', 'admin/menu/delete', '_self', '0', '1467620363', '1477710695', '3', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('17', '13', 'admin', '启用', '', 'module_admin', 'admin/menu/enable', '_self', '0', '1467620386', '1477710695', '4', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('18', '13', 'admin', '禁用', '', 'module_admin', 'admin/menu/disable', '_self', '0', '1467620404', '1477710695', '5', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('19', '68', 'user', '权限管理', 'fa fa-fw fa-key', 'module_admin', '', '_self', '0', '1467688065', '1477710702', '1', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('20', '19', 'user', '用户管理', 'fa fa-fw fa-user', 'module_admin', 'user/index/index', '_self', '0', '1467688137', '1477710702', '1', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('21', '20', 'user', '新增', '', 'module_admin', 'user/index/add', '_self', '0', '1467688177', '1477710702', '1', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('22', '20', 'user', '编辑', '', 'module_admin', 'user/index/edit', '_self', '0', '1467688202', '1477710702', '2', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('23', '20', 'user', '删除', '', 'module_admin', 'user/index/delete', '_self', '0', '1467688219', '1477710702', '3', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('24', '20', 'user', '启用', '', 'module_admin', 'user/index/enable', '_self', '0', '1467688238', '1477710702', '4', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('25', '20', 'user', '禁用', '', 'module_admin', 'user/index/disable', '_self', '0', '1467688256', '1477710702', '5', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('211', '64', 'admin', '日志详情', '', 'module_admin', 'admin/log/details', '_self', '0', '1480299320', '1480299320', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('32', '4', 'admin', '扩展中心', 'si si-social-dropbox', 'module_admin', '', '_self', '0', '1467688853', '1477710695', '2', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('33', '32', 'admin', '模块管理', 'fa fa-fw fa-th-large', 'module_admin', 'admin/module/index', '_self', '0', '1467689008', '1477710695', '1', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('34', '33', 'admin', '导入', '', 'module_admin', 'admin/module/import', '_self', '0', '1467689153', '1477710695', '1', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('35', '33', 'admin', '导出', '', 'module_admin', 'admin/module/export', '_self', '0', '1467689173', '1477710695', '2', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('36', '33', 'admin', '安装', '', 'module_admin', 'admin/module/install', '_self', '0', '1467689192', '1477710695', '3', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('37', '33', 'admin', '卸载', '', 'module_admin', 'admin/module/uninstall', '_self', '0', '1467689241', '1477710695', '4', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('38', '33', 'admin', '启用', '', 'module_admin', 'admin/module/enable', '_self', '0', '1467689294', '1477710695', '5', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('39', '33', 'admin', '禁用', '', 'module_admin', 'admin/module/disable', '_self', '0', '1467689312', '1477710695', '6', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('40', '33', 'admin', '更新', '', 'module_admin', 'admin/module/update', '_self', '0', '1467689341', '1477710695', '7', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('41', '32', 'admin', '插件管理', 'fa fa-fw fa-puzzle-piece', 'module_admin', 'admin/plugin/index', '_self', '0', '1467689527', '1477710695', '2', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('42', '41', 'admin', '导入', '', 'module_admin', 'admin/plugin/import', '_self', '0', '1467689650', '1477710695', '1', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('43', '41', 'admin', '导出', '', 'module_admin', 'admin/plugin/export', '_self', '0', '1467689665', '1477710695', '2', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('44', '41', 'admin', '安装', '', 'module_admin', 'admin/plugin/install', '_self', '0', '1467689680', '1477710695', '3', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('45', '41', 'admin', '卸载', '', 'module_admin', 'admin/plugin/uninstall', '_self', '0', '1467689700', '1477710695', '4', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('46', '41', 'admin', '启用', '', 'module_admin', 'admin/plugin/enable', '_self', '0', '1467689730', '1477710695', '5', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('47', '41', 'admin', '禁用', '', 'module_admin', 'admin/plugin/disable', '_self', '0', '1467689747', '1477710695', '6', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('48', '41', 'admin', '设置', '', 'module_admin', 'admin/plugin/config', '_self', '0', '1467689789', '1477710695', '7', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('49', '41', 'admin', '管理', '', 'module_admin', 'admin/plugin/manage', '_self', '0', '1467689846', '1477710695', '8', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('50', '5', 'admin', '附件管理', 'fa fa-fw fa-cloud-upload', 'module_admin', 'admin/attachment/index', '_self', '0', '1467690161', '1477710695', '4', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('51', '70', 'admin', '文件上传', '', 'module_admin', 'admin/attachment/upload', '_self', '0', '1467690240', '1489049773', '1', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('52', '50', 'admin', '下载', '', 'module_admin', 'admin/attachment/download', '_self', '0', '1467690334', '1477710695', '2', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('53', '50', 'admin', '启用', '', 'module_admin', 'admin/attachment/enable', '_self', '0', '1467690352', '1477710695', '3', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('54', '50', 'admin', '禁用', '', 'module_admin', 'admin/attachment/disable', '_self', '0', '1467690369', '1477710695', '4', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('55', '50', 'admin', '删除', '', 'module_admin', 'admin/attachment/delete', '_self', '0', '1467690396', '1477710695', '5', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('56', '41', 'admin', '删除', '', 'module_admin', 'admin/plugin/delete', '_self', '0', '1467858065', '1477710695', '11', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('57', '41', 'admin', '编辑', '', 'module_admin', 'admin/plugin/edit', '_self', '0', '1467858092', '1477710695', '10', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('60', '41', 'admin', '新增', '', 'module_admin', 'admin/plugin/add', '_self', '0', '1467858421', '1477710695', '9', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('61', '41', 'admin', '执行', '', 'module_admin', 'admin/plugin/execute', '_self', '0', '1467879016', '1477710695', '14', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('62', '13', 'admin', '保存', '', 'module_admin', 'admin/menu/save', '_self', '0', '1468073039', '1477710695', '6', '1', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('64', '5', 'admin', '系统日志', 'fa fa-fw fa-book', 'module_admin', 'admin/log/index', '_self', '0', '1476111944', '1477710695', '6', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('65', '5', 'admin', '数据库管理', 'fa fa-fw fa-database', 'module_admin', 'admin/database/index', '_self', '0', '1476111992', '1477710695', '8', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('66', '32', 'admin', '数据包管理', 'fa fa-fw fa-database', 'module_admin', 'admin/packet/index', '_self', '0', '1476112326', '1477710695', '4', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('67', '19', 'user', '角色管理', 'fa fa-fw fa-users', 'module_admin', 'user/role/index', '_self', '0', '1476113025', '1477710702', '3', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('68', '0', 'user', '用户', 'fa fa-fw fa-user', 'module_admin', 'user/index/index', '_self', '0', '1476193348', '1477710540', '3', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('69', '32', 'admin', '钩子管理', 'fa fa-fw fa-anchor', 'module_admin', 'admin/hook/index', '_self', '0', '1476236193', '1477710695', '3', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('70', '2', 'admin', '后台首页', 'fa fa-fw fa-tachometer', 'module_admin', 'admin/index/index', '_self', '0', '1476237472', '1489049773', '1', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('71', '67', 'user', '新增', '', 'module_admin', 'user/role/add', '_self', '0', '1476256935', '1477710702', '1', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('72', '67', 'user', '编辑', '', 'module_admin', 'user/role/edit', '_self', '0', '1476256968', '1477710702', '2', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('73', '67', 'user', '删除', '', 'module_admin', 'user/role/delete', '_self', '0', '1476256993', '1477710702', '3', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('74', '67', 'user', '启用', '', 'module_admin', 'user/role/enable', '_self', '0', '1476257023', '1477710702', '4', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('75', '67', 'user', '禁用', '', 'module_admin', 'user/role/disable', '_self', '0', '1476257046', '1477710702', '5', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('76', '20', 'user', '授权', '', 'module_admin', 'user/index/access', '_self', '0', '1476375187', '1477710702', '6', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('77', '69', 'admin', '新增', '', 'module_admin', 'admin/hook/add', '_self', '0', '1476668971', '1477710695', '1', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('78', '69', 'admin', '编辑', '', 'module_admin', 'admin/hook/edit', '_self', '0', '1476669006', '1477710695', '2', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('79', '69', 'admin', '删除', '', 'module_admin', 'admin/hook/delete', '_self', '0', '1476669375', '1477710695', '3', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('80', '69', 'admin', '启用', '', 'module_admin', 'admin/hook/enable', '_self', '0', '1476669427', '1477710695', '4', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('81', '69', 'admin', '禁用', '', 'module_admin', 'admin/hook/disable', '_self', '0', '1476669564', '1477710695', '5', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('183', '66', 'admin', '安装', '', 'module_admin', 'admin/packet/install', '_self', '0', '1476851362', '1477710695', '1', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('184', '66', 'admin', '卸载', '', 'module_admin', 'admin/packet/uninstall', '_self', '0', '1476851382', '1477710695', '2', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('185', '5', 'admin', '行为管理', 'fa fa-fw fa-bug', 'module_admin', 'admin/action/index', '_self', '0', '1476882441', '1477710695', '7', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('186', '185', 'admin', '新增', '', 'module_admin', 'admin/action/add', '_self', '0', '1476884439', '1477710695', '1', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('187', '185', 'admin', '编辑', '', 'module_admin', 'admin/action/edit', '_self', '0', '1476884464', '1477710695', '2', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('188', '185', 'admin', '启用', '', 'module_admin', 'admin/action/enable', '_self', '0', '1476884493', '1477710695', '3', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('189', '185', 'admin', '禁用', '', 'module_admin', 'admin/action/disable', '_self', '0', '1476884534', '1477710695', '4', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('190', '185', 'admin', '删除', '', 'module_admin', 'admin/action/delete', '_self', '0', '1476884551', '1477710695', '5', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('191', '65', 'admin', '备份数据库', '', 'module_admin', 'admin/database/export', '_self', '0', '1476972746', '1477710695', '1', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('192', '65', 'admin', '还原数据库', '', 'module_admin', 'admin/database/import', '_self', '0', '1476972772', '1477710695', '2', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('193', '65', 'admin', '优化表', '', 'module_admin', 'admin/database/optimize', '_self', '0', '1476972800', '1477710695', '3', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('194', '65', 'admin', '修复表', '', 'module_admin', 'admin/database/repair', '_self', '0', '1476972825', '1477710695', '4', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('195', '65', 'admin', '删除备份', '', 'module_admin', 'admin/database/delete', '_self', '0', '1476973457', '1477710695', '5', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('210', '41', 'admin', '快速编辑', '', 'module_admin', 'admin/plugin/quickedit', '_self', '0', '1477713981', '1477713981', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('209', '185', 'admin', '快速编辑', '', 'module_admin', 'admin/action/quickedit', '_self', '0', '1477713939', '1477713939', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('208', '7', 'admin', '快速编辑', '', 'module_admin', 'admin/config/quickedit', '_self', '0', '1477713808', '1477713808', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('207', '69', 'admin', '快速编辑', '', 'module_admin', 'admin/hook/quickedit', '_self', '0', '1477713770', '1477713770', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('212', '2', 'admin', '个人设置', 'fa fa-fw fa-user', 'module_admin', 'admin/index/profile', '_self', '0', '1489049767', '1489049773', '2', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('213', '70', 'admin', '检查版本更新', '', 'module_admin', 'admin/index/checkupdate', '_self', '0', '1490588610', '1490588610', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('214', '68', 'user', '消息管理', 'fa fa-fw fa-comments-o', 'module_admin', '', '_self', '0', '1520492129', '1520492129', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('215', '214', 'user', '消息列表', 'fa fa-fw fa-th-list', 'module_admin', 'user/message/index', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('216', '215', 'user', '新增', '', 'module_admin', 'user/message/add', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('217', '215', 'user', '编辑', '', 'module_admin', 'user/message/edit', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('218', '215', 'user', '删除', '', 'module_admin', 'user/message/delete', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('219', '215', 'user', '启用', '', 'module_admin', 'user/message/enable', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('220', '215', 'user', '禁用', '', 'module_admin', 'user/message/disable', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('221', '215', 'user', '快速编辑', '', 'module_admin', 'user/message/quickedit', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('222', '2', 'admin', '消息中心', 'fa fa-fw fa-comments-o', 'module_admin', 'admin/message/index', '_self', '0', '1520495992', '1520496254', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('223', '222', 'admin', '删除', '', 'module_admin', 'admin/message/delete', '_self', '0', '1520495992', '1520496263', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('224', '222', 'admin', '启用', '', 'module_admin', 'admin/message/enable', '_self', '0', '1520495992', '1520496270', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('225', '32', 'admin', '图标管理', 'fa fa-fw fa-tint', 'module_admin', 'admin/icon/index', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('226', '225', 'admin', '新增', '', 'module_admin', 'admin/icon/add', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('227', '225', 'admin', '编辑', '', 'module_admin', 'admin/icon/edit', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('228', '225', 'admin', '删除', '', 'module_admin', 'admin/icon/delete', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('229', '225', 'admin', '启用', '', 'module_admin', 'admin/icon/enable', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('230', '225', 'admin', '禁用', '', 'module_admin', 'admin/icon/disable', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('231', '225', 'admin', '快速编辑', '', 'module_admin', 'admin/icon/quickedit', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('232', '225', 'admin', '图标列表', '', 'module_admin', 'admin/icon/items', '_self', '0', '1520923368', '1520923368', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('233', '225', 'admin', '更新图标', '', 'module_admin', 'admin/icon/reload', '_self', '0', '1520931908', '1520931908', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('234', '20', 'user', '快速编辑', '', 'module_admin', 'user/index/quickedit', '_self', '0', '1526028258', '1526028258', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('235', '67', 'user', '快速编辑', '', 'module_admin', 'user/role/quickedit', '_self', '0', '1526028282', '1526028282', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('398', '33', 'admin', '新增', '', 'module_admin', 'admin/module/add', '_self', '0', '1532229273', '1532229273', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('453', '33', 'admin', '节点删除', '', 'module_admin', 'admin/fieldnode/delete', '_self', '0', '1532331307', '1532331307', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('454', '33', 'admin', '节点添加', '', 'module_admin', 'admin/fieldnode/add', '_self', '0', '1532331334', '1532331334', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('472', '467', 'admin', '禁用', '', 'module_admin', 'admin/moduleconfig/disable', '_self', '0', '1532412418', '1532412418', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('434', '431', 'admin', '删除', '', 'module_admin', 'admin/field/delete', '_self', '0', '1532311581', '1532311581', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('433', '431', 'admin', '编辑', '', 'module_admin', 'admin/field/edit', '_self', '0', '1532311581', '1532311581', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('432', '431', 'admin', '新增', '', 'module_admin', 'admin/field/add', '_self', '0', '1532311581', '1532311581', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('431', '427', 'admin', '字段管理', '', 'module_admin', 'admin/field/index', '_self', '0', '1532311581', '1532311581', '100', '0', '0', '');
INSERT INTO `cj_admin_menu` VALUES ('430', '427', 'shop', '删除', '', 'module_admin', 'shop/databasetable/delete', '_self', '0', '1532311581', '1532311581', '100', '0', '0', '');
INSERT INTO `cj_admin_menu` VALUES ('429', '427', 'shop', '编辑', '', 'module_admin', 'shop/databasetable/edit', '_self', '0', '1532311581', '1532311581', '100', '0', '0', '');
INSERT INTO `cj_admin_menu` VALUES ('428', '427', 'shop', '新增', '', 'module_admin', 'shop/databasetable/add', '_self', '0', '1532311581', '1532311581', '100', '0', '0', '');
INSERT INTO `cj_admin_menu` VALUES ('427', '426', 'shop', '模型管理', 'fa fa-fw fa-th-list', 'module_admin', 'shop/databasetable/index', '_self', '0', '1532311581', '1532333926', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('426', '0', 'shop', '商城', 'fa fa-fw fa-newspaper-o', 'module_admin', 'shop/index/index', '_self', '0', '1532311581', '1532740461', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('452', '33', 'admin', '节点编辑', '', 'module_admin', 'admin/fieldnode/edit', '_self', '0', '1532331225', '1532331225', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('444', '33', 'admin', '节点列表', '', 'module_admin', 'admin/fieldnode/index', '_self', '0', '1532324929', '1532331158', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('471', '467', 'admin', '启用', '', 'module_admin', 'admin/moduleconfig/enable', '_self', '0', '1532412418', '1532412418', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('470', '467', 'admin', '删除', '', 'module_admin', 'admin/moduleconfig/delete', '_self', '0', '1532412418', '1532412418', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('469', '467', 'admin', '编辑', '', 'module_admin', 'admin/moduleconfig/edit', '_self', '0', '1532412418', '1532412418', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('468', '467', 'admin', '新增', '', 'module_admin', 'admin/moduleconfig/add', '_self', '0', '1532412418', '1532412418', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('467', '33', 'admin', '模块配置信息', '', 'module_admin', 'admin/moduleconfig/index', '_self', '0', '1532412418', '1532412418', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('473', '467', 'admin', '快速编辑', '', 'module_admin', 'admin/moduleconfig/quickedit', '_self', '0', '1532412418', '1532412418', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('578', '426', 'shop', '会员列表', 'fa fa-fw fa-film', 'module_admin', 'shop/userlist/index', '_self', '0', '1532490029', '1532740226', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('599', '593', 'admin', '快速编辑', '', 'module_admin', 'admin/button/quickedit', '_self', '0', '1532582099', '1532582099', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('593', '33', 'admin', '模型按钮配置', '', 'module_admin', 'admin/button/index', '_self', '0', '1532582100', '1532582100', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('594', '593', 'admin', '新增', '', 'module_admin', 'admin/button/add', '_self', '0', '1532582099', '1532582099', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('595', '593', 'admin', '编辑', '', 'module_admin', 'admin/button/edit', '_self', '0', '1532582099', '1532582099', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('596', '593', 'admin', '删除', '', 'module_admin', 'admin/button/delete', '_self', '0', '1532582099', '1532582099', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('597', '593', 'admin', '启用', '', 'module_admin', 'admin/button/enable', '_self', '0', '1532582099', '1532582099', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('598', '593', 'admin', '禁用', '', 'module_admin', 'admin/button/disable', '_self', '0', '1532582099', '1532582099', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('583', '580', 'shop', '新增', '', 'module_admin', 'shop/menber/add', '_self', '0', '1532506668', '1533088585', '100', '0', '0', '');
INSERT INTO `cj_admin_menu` VALUES ('580', '426', 'shop', '会员管理', 'fa fa-fw fa-repeat', 'module_admin', 'shop/menber/index', '_self', '0', '1532490563', '1532740631', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('600', '33', 'admin', '生成校验规则', '', 'module_admin', 'admin/field/field_checkout', '_self', '0', '1532698768', '1532698768', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('728', '580', 'shop', '编辑', '', 'module_admin', 'shop/userlist/edit', '_self', '0', '1533088561', '1533088561', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('729', '41', 'admin', '新增插件', '', 'module_admin', 'admin/plugin/addplug', '_self', '0', '1533092148', '1533092148', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('727', '427', 'shop', '参数配置', '', 'module_admin', 'shop/databasetable/getconfigurelist', '_self', '0', '1533087168', '1533087168', '100', '0', '0', '');
INSERT INTO `cj_admin_menu` VALUES ('796', '426', 'shop', '订单管理', 'fa fa-fw fa-calendar', 'module_admin', 'shop/order/index', '_self', '0', '1533112918', '1533112918', '100', '0', '1', '');
INSERT INTO `cj_admin_menu` VALUES ('797', '796', 'shop', '新增', 'fa fa-fw fa-calendar', 'module_admin', 'shop/order/add', '_self', '0', '1533112918', '1533112918', '100', '0', '0', '');
INSERT INTO `cj_admin_menu` VALUES ('798', '796', 'shop', '编辑', 'fa fa-fw fa-calendar', 'module_admin', 'shop/order/edit', '_self', '0', '1533112918', '1533112918', '100', '0', '0', '');
INSERT INTO `cj_admin_menu` VALUES ('799', '796', 'shop', '删除', 'fa fa-fw fa-calendar', 'module_admin', 'shop/order/delete', '_self', '0', '1533112918', '1533112918', '100', '0', '0', '');

-- ----------------------------
-- Table structure for cj_admin_message
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_message`;
CREATE TABLE `cj_admin_message` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid_receive` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '接收消息的用户id',
  `uid_send` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发送消息的用户id',
  `type` varchar(128) NOT NULL DEFAULT '' COMMENT '消息分类',
  `content` text NOT NULL COMMENT '消息内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `read_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '阅读时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='消息表';

-- ----------------------------
-- Records of cj_admin_message
-- ----------------------------

-- ----------------------------
-- Table structure for cj_admin_model
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_model`;
CREATE TABLE `cj_admin_model` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '模型名称',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模型标题',
  `table` varchar(64) NOT NULL DEFAULT '' COMMENT '附加表名称',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '模型类别：0-系统模型，1-普通模型，2-独立模型',
  `icon` varchar(64) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `is_top_button` tinyint(1) DEFAULT '1' COMMENT '顶部按钮是否启用  0不启用  1 启用',
  `is_right_button` tinyint(1) DEFAULT '1' COMMENT '右侧按钮是否显示 0 不显示  1 显示',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `system` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否系统模型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `top_button_value` varchar(255) DEFAULT '' COMMENT '按钮配置内容',
  `right_button_value` varchar(255) DEFAULT '' COMMENT '右侧按钮内容',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='内容模型表';

-- ----------------------------
-- Records of cj_admin_model
-- ----------------------------
INSERT INTO `cj_admin_model` VALUES ('73', 'shop', '会员列表', 'cj_shop_user_list', '2', 'fa fa-fw fa-film', '100', '1', '1', '1', '0', '1532490029', '1533087439', 'add,enable,disable,back', 'edit');
INSERT INTO `cj_admin_model` VALUES ('75', 'shop', '会员管理', 'cj_shop_menber', '2', 'fa fa-fw fa-repeat', '100', '1', '1', '1', '0', '1532490563', '1533087446', 'add,enable,disable,back', 'edit,delete,custom');
INSERT INTO `cj_admin_model` VALUES ('115', 'shop', '订单管理', 'cj_shop_order', '1', 'fa fa-fw fa-calendar', '100', '1', '1', '1', '0', '1533112918', '1533112918', 'back,add', 'edit,delete');

-- ----------------------------
-- Table structure for cj_admin_module
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_module`;
CREATE TABLE `cj_admin_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '模块名称（标识）',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模块标题',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '图标',
  `description` text NOT NULL COMMENT '描述',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `author_url` varchar(255) NOT NULL DEFAULT '' COMMENT '作者主页',
  `config` text COMMENT '配置信息',
  `access` text COMMENT '授权配置',
  `version` varchar(16) NOT NULL DEFAULT '' COMMENT '版本号',
  `identifier` varchar(64) NOT NULL DEFAULT '' COMMENT '模块唯一标识符',
  `system_module` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统模块',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='模块表';

-- ----------------------------
-- Records of cj_admin_module
-- ----------------------------
INSERT INTO `cj_admin_module` VALUES ('1', 'admin', '系统', 'fa fa-fw fa-gear', '系统模块，DolphinPHP的核心模块', 'DolphinPHP', 'http://www.dolphinphp.com', '', '', '1.0.0', 'admin.dolphinphp.module', '1', '1468204902', '1468204902', '100', '1');
INSERT INTO `cj_admin_module` VALUES ('2', 'user', '用户', 'fa fa-fw fa-user', '用户模块，DolphinPHP自带模块', 'DolphinPHP', 'http://www.dolphinphp.com', '', '', '1.0.0', 'user.dolphinphp.module', '1', '1468204902', '1468204902', '100', '1');
INSERT INTO `cj_admin_module` VALUES ('21', 'shop', '商城', '', '的萨达萨达sad', ' 的sad', '大的', '', '', '1.0.0.2', 'shop.caijion.module', '0', '1532311581', '1532485213', '100', '1');

-- ----------------------------
-- Table structure for cj_admin_module_config
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_module_config`;
CREATE TABLE `cj_admin_module_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '字段名称',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '字段标题',
  `group_name` varchar(32) NOT NULL DEFAULT '' COMMENT '分组名称',
  `default_value` varchar(255) NOT NULL DEFAULT '0' COMMENT '默认值',
  `module_name` varchar(255) NOT NULL DEFAULT '' COMMENT '模块标识',
  `field_type` varchar(255) NOT NULL DEFAULT '' COMMENT '字段类型',
  `field_hints` varchar(255) NOT NULL DEFAULT '' COMMENT '字段提示',
  `is_required` tinyint(2) NOT NULL DEFAULT '0' COMMENT '1,必填  0,不必填',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0禁用，1启用',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(11) unsigned DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='模块配置信息';

-- ----------------------------
-- Records of cj_admin_module_config
-- ----------------------------
INSERT INTO `cj_admin_module_config` VALUES ('1', 'name_time', '时间', '基本配置', '110ss', 'shop', 'text', '这是时间', '0', '1', '100', '1532423546', '1533088340', '0');
INSERT INTO `cj_admin_module_config` VALUES ('2', 'strat_time', '开始时间', '时间配置', '2018-08-01', 'shop', 'text', '这个是活动的开始时间配置', '0', '1', '100', '1533088072', '1533088352', '0');

-- ----------------------------
-- Table structure for cj_admin_packet
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_packet`;
CREATE TABLE `cj_admin_packet` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '数据包名',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '数据包标题',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `author_url` varchar(255) NOT NULL DEFAULT '' COMMENT '作者url',
  `version` varchar(16) NOT NULL,
  `tables` text NOT NULL COMMENT '数据表名',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='数据包表';

-- ----------------------------
-- Records of cj_admin_packet
-- ----------------------------

-- ----------------------------
-- Table structure for cj_admin_plugin
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_plugin`;
CREATE TABLE `cj_admin_plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '插件名称',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '插件标题',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '图标',
  `description` text NOT NULL COMMENT '插件描述',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `author_url` varchar(255) NOT NULL DEFAULT '' COMMENT '作者主页',
  `config` text NOT NULL COMMENT '配置信息',
  `version` varchar(16) NOT NULL DEFAULT '' COMMENT '版本号',
  `identifier` varchar(64) NOT NULL DEFAULT '' COMMENT '插件唯一标识符',
  `admin` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台管理',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='插件表';

-- ----------------------------
-- Records of cj_admin_plugin
-- ----------------------------
INSERT INTO `cj_admin_plugin` VALUES ('1', 'SystemInfo', '系统环境信息', 'fa fa-fw fa-info-circle', '在后台首页显示服务器信息', '蔡伟明', 'http://www.caiweiming.com', '{\"display\":\"1\",\"width\":\"6\"}', '1.0.0', 'system_info.ming.plugin', '0', '1477757503', '1477757503', '100', '1');
INSERT INTO `cj_admin_plugin` VALUES ('2', 'DevTeam', '开发团队成员信息', 'fa fa-fw fa-users', '开发团队成员信息', '蔡伟明', 'http://www.caiweiming.com', '{\"display\":\"0\",\"width\":\"6\"}', '1.0.0', 'dev_team.ming.plugin', '0', '1477755780', '1477755780', '100', '1');
INSERT INTO `cj_admin_plugin` VALUES ('3', 'Barcode', '条形码生成插件', 'fa fa-fw fa-barcode', '条形码生成插件', '蔡伟明', 'http://www.dolphinphp.com', '{\"file_type\":\"PNG\",\"dpi\":\"72\",\"thickness\":\"30\",\"scale\":\"2\",\"rotation\":0,\"font_size\":\"10\"}', '1.0.0', 'barcode.ming.plugin', '0', '1533089343', '1533089343', '100', '1');
INSERT INTO `cj_admin_plugin` VALUES ('8', 'CeshiGangqiang', '测试刚强', 'fa fa-fw fa-camera', '颠三倒四', '的速度', '都是都是', '{\"ak\":\"\",\"sk\":\"\",\"bucket\":\"\",\"domain\":\"http:\\/\\/\"}', '1.0.0', 'ceshi.ming.module', '0', '1533103928', '1533103928', '100', '1');
INSERT INTO `cj_admin_plugin` VALUES ('9', 'HelloWorld', '你好，世界', 'fa fa-fw fa-globe', '这是一个演示插件，会在每个页面生成一个提示“Hello World”。您可以查看源码，里面包含了绝大部分插件所用到的方法，以及能做的事情。', '蔡伟明', 'http://www.dolphinphp.com', '{\"status\":1,\"text\":\"x\",\"textarea\":\"\",\"checkbox\":0,\"status1\":1,\"text1\":\"x\",\"textarea1\":\"\",\"checkbox1\":0,\"textarea2\":\"\",\"checkbox2\":0}', '1.0.0', 'helloworld.ming.plugin', '1', '1533114900', '1533114900', '100', '1');

-- ----------------------------
-- Table structure for cj_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_role`;
CREATE TABLE `cj_admin_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级角色',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '角色名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '角色描述',
  `menu_auth` text NOT NULL COMMENT '菜单权限',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `access` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否可登录后台',
  `default_module` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '默认访问模块',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='角色表';

-- ----------------------------
-- Records of cj_admin_role
-- ----------------------------
INSERT INTO `cj_admin_role` VALUES ('1', '0', '超级管理员', '系统默认创建的角色，拥有最高权限', '', '0', '1476270000', '1468117612', '1', '1', '0');
INSERT INTO `cj_admin_role` VALUES ('2', '0', '协管员', '是第三代的大神都是', '[]', '100', '1532329143', '1532329143', '1', '1', '1');

-- ----------------------------
-- Table structure for cj_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `cj_admin_user`;
CREATE TABLE `cj_admin_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(96) NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱地址',
  `email_bind` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否绑定邮箱地址',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `mobile_bind` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否绑定手机号码',
  `avatar` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '头像',
  `money` decimal(11,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '余额',
  `score` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `role` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `group` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '部门id',
  `signup_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '注册ip',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次登录时间',
  `last_login_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '登录ip',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态：0禁用，1启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户表';

-- ----------------------------
-- Records of cj_admin_user
-- ----------------------------
INSERT INTO `cj_admin_user` VALUES ('1', 'admin', '超级管理员', '$2y$10$Brw6wmuSLIIx3Yabid8/Wu5l8VQ9M/H/CG3C9RqN9dUCwZW3ljGOK', '', '0', '', '0', '0', '0.00', '0', '1', '0', '0', '1476065410', '1533085669', '1533085668', '2130706433', '100', '1');
INSERT INTO `cj_admin_user` VALUES ('2', 'admin110', '的撒打算', '$2y$10$8Mpt3CdvLB3HX39.2HvCDOm3mAfp41AmP9iXwZ53NZQgwURG/SGVW', '584887013@qq.com', '0', '15881098622', '0', '0', '0.00', '0', '2', '0', '0', '1532329204', '1532329204', '0', '0', '100', '1');

-- ----------------------------
-- Table structure for cj_plugin_hello
-- ----------------------------
DROP TABLE IF EXISTS `cj_plugin_hello`;
CREATE TABLE `cj_plugin_hello` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名人',
  `said` text NOT NULL COMMENT '名言',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cj_plugin_hello
-- ----------------------------
INSERT INTO `cj_plugin_hello` VALUES ('1', '网络', '生活是一面镜子。你对它笑，它就对你笑；你对它哭，它也对你哭。', '1');
INSERT INTO `cj_plugin_hello` VALUES ('2', '网络', '活着一天，就是有福气，就该珍惜。当我哭泣我没有鞋子穿的时候，我发现有人却没有脚。', '1');
INSERT INTO `cj_plugin_hello` VALUES ('3', '爱迪生', '天才是百分之一的灵感加百分之九十九的汗水。', '1');
INSERT INTO `cj_plugin_hello` VALUES ('4', '美华纳', '勿问成功的秘诀为何，且尽全力做你应该做的事吧。', '1');
INSERT INTO `cj_plugin_hello` VALUES ('5', '陶铸', '如烟往事俱忘却，心底无私天地宽', '1');

-- ----------------------------
-- Table structure for cj_shop_goods
-- ----------------------------
DROP TABLE IF EXISTS `cj_shop_goods`;
CREATE TABLE `cj_shop_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) unsigned NOT NULL,
  `create_time` int(11) unsigned DEFAULT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  `delete_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='cj_shop_goods表';

-- ----------------------------
-- Records of cj_shop_goods
-- ----------------------------

-- ----------------------------
-- Table structure for cj_shop_menber
-- ----------------------------
DROP TABLE IF EXISTS `cj_shop_menber`;
CREATE TABLE `cj_shop_menber` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `user_token` varchar(255) NOT NULL COMMENT '用户',
  `title` varchar(255) DEFAULT NULL,
  `liste` varchar(255) NOT NULL COMMENT '列表',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='数据表模型表';

-- ----------------------------
-- Records of cj_shop_menber
-- ----------------------------
INSERT INTO `cj_shop_menber` VALUES ('2', '1532509044', '1532509044', '100', '1', '2', null, '1');
INSERT INTO `cj_shop_menber` VALUES ('3', '1532509055', '1532509055', '100', '1', '2', null, '2');
INSERT INTO `cj_shop_menber` VALUES ('4', '1532509261', '1532509261', '100', '1', '3', '3', '66');
INSERT INTO `cj_shop_menber` VALUES ('5', '1532510021', '1532510021', '100', '1', '3', '4', '4');
INSERT INTO `cj_shop_menber` VALUES ('6', '1532510871', '1532510871', '100', '1', '999', '999', '9999');

-- ----------------------------
-- Table structure for cj_shop_order
-- ----------------------------
DROP TABLE IF EXISTS `cj_shop_order`;
CREATE TABLE `cj_shop_order` (
  `id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单管理模型扩展表';

-- ----------------------------
-- Records of cj_shop_order
-- ----------------------------

-- ----------------------------
-- Table structure for cj_shop_user_list
-- ----------------------------
DROP TABLE IF EXISTS `cj_shop_user_list`;
CREATE TABLE `cj_shop_user_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员管理模型表';

-- ----------------------------
-- Records of cj_shop_user_list
-- ----------------------------

-- ----------------------------
-- Table structure for cj_user_img
-- ----------------------------
DROP TABLE IF EXISTS `cj_user_img`;
CREATE TABLE `cj_user_img` (
  `img_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `img` varchar(1000) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cj_user_img
-- ----------------------------
INSERT INTO `cj_user_img` VALUES ('1', '1', '15313067689b0dad1fd59e_0.jpeg;15313067689b0dad1fd59e_1.jpeg;');
INSERT INTO `cj_user_img` VALUES ('2', '1', '15313067689b0dad1fd59e_0.jpeg;15313067689b0dad1fd59e_1.jpeg;');
INSERT INTO `cj_user_img` VALUES ('3', '1', '15313067689b0dad1fd59e_0.jpeg;15313067689b0dad1fd59e_1.jpeg;');
INSERT INTO `cj_user_img` VALUES ('4', '1', '15313067689b0dad1fd59e_0.jpeg;15313067689b0dad1fd59e_1.jpeg;');
INSERT INTO `cj_user_img` VALUES ('6', '1', '15313067689b0dad1fd59e_0.jpeg;');
