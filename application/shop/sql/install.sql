            
-- -----------------------------
-- 表结构 `cj_shop_goods`
-- -----------------------------
CREATE TABLE IF NOT EXISTS `cj_shop_goods` (
`id` int(11) UNSIGNED  NOT NULL AUTO_INCREMENT,
`status` tinyint(1) UNSIGNED NOT NULL,
`create_time` int(11) UNSIGNED  NULL,
`update_time` int(11) UNSIGNED  NULL,
`delete_time` int(11) UNSIGNED  NULL,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0
COMMENT='cj_shop_goods表';

