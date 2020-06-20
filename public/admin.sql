-- --------------------------------------------------------
-- 主机:                           172.18.9.3
-- 服务器版本:                        10.1.32-MariaDB - MariaDB Server
-- 服务器操作系统:                      Linux
-- HeidiSQL 版本:                  9.5.0.5263
-- --------------------------------------------------------
-- 导出 admin 的数据库结构
DROP DATABASE IF EXISTS `admin`;

CREATE DATABASE IF NOT EXISTS `admin`
/*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */
;

USE `admin`;

-- 导出  表 tokay.to_admins 结构
DROP TABLE IF EXISTS `to_admins`;

CREATE TABLE IF NOT EXISTS `to_admins` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `username` varchar(16) NOT NULL COMMENT '登录名',
    `password` varchar(40) NOT NULL,
    `salt` char(10) DEFAULT NULL COMMENT '混淆码',
    `email` varchar(100) NOT NULL COMMENT '邮箱',
    `mobile` char(11) DEFAULT NULL COMMENT '手机号码',
    `role` smallint(5) unsigned DEFAULT NULL COMMENT '角色',
    `status` bigint(20) DEFAULT '0' COMMENT '0=正常，其它（1=永久冻结，冻结时间）不可登录	',
    `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `last_login` bigint(20) DEFAULT NULL COMMENT '最后登录时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    KEY `group` (`role`)
) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8 COMMENT = '后台用户表';

-- 正在导出表  tokay.to_admins 的数据：~0 rows (大约)
DELETE FROM
    `to_admins`;

/*!40000 ALTER TABLE `to_admins` DISABLE KEYS */
;

INSERT INTO
    `to_admins` (
        `id`,
        `username`,
        `password`,
        `salt`,
        `email`,
        `mobile`,
        `role`,
        `status`,
        `create_time`,
        `last_login`
    )
VALUES
    (
        1,
        'admin',
        '024f43383adace22e439c19545f168098c6bcb3e',
        '245af2964d',
        'luck@fmail.pro',
        '13428122341',
        1,
        1,
        '2008-08-18 18:58:13',
        NULL
    );

/*!40000 ALTER TABLE `to_admins` ENABLE KEYS */
;

-- 导出  表 tokay.to_roles 结构
DROP TABLE IF EXISTS `to_roles`;

CREATE TABLE IF NOT EXISTS `to_roles` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(20) NOT NULL,
    `rights` varchar(255) DEFAULT NULL,
    `default` varchar(50) DEFAULT NULL COMMENT '默认登录页',
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
) ENGINE = MyISAM AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8 COMMENT = '管理角色组表';

-- 正在导出表  tokay.to_roles 的数据：1 rows
DELETE FROM
    `to_roles`;

/*!40000 ALTER TABLE `to_roles` DISABLE KEYS */
;

INSERT INTO
    `to_roles` (`id`, `name`, `rights`, `default`)
VALUES
    (1, 'root=>超级管理员', '', '');

/*!40000 ALTER TABLE `to_roles` ENABLE KEYS */
;

-- 导出  表 tokay.to_rights 结构
DROP TABLE IF EXISTS `to_rights`;

CREATE TABLE IF NOT EXISTS `to_rights` (
    `right_id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
    `right_name` varchar(50) DEFAULT NULL,
    `right_class` varchar(30) DEFAULT NULL,
    `right_method` varchar(30) DEFAULT NULL,
    `right_detail` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`right_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT = '权限表';

-- 导出  表 tokay.to_menus 结构
DROP TABLE IF EXISTS `to_menus`;

CREATE TABLE IF NOT EXISTS `to_menus` (
    `id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
    `order_by` tinyint(2) unsigned NOT NULL COMMENT '排序',
    `class` varchar(20) NOT NULL COMMENT '类',
    `method` varchar(30) NOT NULL COMMENT '方法',
    `name` varchar(20) NOT NULL COMMENT '菜单名字',
    `level` tinyint(2) unsigned DEFAULT '0' COMMENT '菜单层级',
    `parent` tinyint(10) unsigned DEFAULT '0' COMMENT '父级',
    `icon` varchar(50) DEFAULT NULL COMMENT 'ICON',
    `department` varchar(20) DEFAULT NULL COMMENT '所属顶级',
    `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示：默认1显示，0不显示',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARSET = utf8 COMMENT = '后台菜单表';

-- 正在导出表  tokay.to_menus 的数据：~8 rows (大约)
DELETE FROM
    `to_menus`;

/*!40000 ALTER TABLE `to_menus` DISABLE KEYS */
;

INSERT INTO
    `to_menus` (
        `id`,
        `order_by`,
        `class`,
        `method`,
        `name`,
        `level`,
        `parent`,
        `icon`,
        `department`,
        `is_show`
    )
VALUES
    (
        1,
        1,
        'love',
        'index',
        '后台首页',
        1,
        0,
        'fa-desktop',
        '1',
        1
    ),
    (2, 8, '', '', '系统设置', 1, 0, 'fa-cogs', '请选择', 1),
    (
        3,
        1,
        'menus',
        'index',
        '菜单管理',
        2,
        2,
        'fa-folder',
        '2',
        1
    ),
    (
        4,
        4,
        'record',
        'index',
        '操作日志',
        2,
        2,
        NULL,
        '2',
        1
    ),
    (
        5,
        3,
        'roles',
        'index',
        '角色管理',
        2,
        2,
        'fa-key',
        '2',
        1
    ),
    (
        6,
        2,
        'admins',
        'index',
        '后台用户',
        2,
        2,
        'ssssss',
        '2',
        1
    ),
    (
        7,
        2,
        'nav',
        'index',
        '导航菜单',
        1,
        0,
        'fa-fire',
        '请选择',
        1
    ),
    (
        8,
        2,
        'article',
        'index',
        '文章管理',
        1,
        0,
        'fa-leanpub',
        '请选择',
        1
    );

/*!40000 ALTER TABLE `to_menus` ENABLE KEYS */
;

-- 导出  表 tokay.to_record 结构
DROP TABLE IF EXISTS `to_record`;

CREATE TABLE IF NOT EXISTS `to_record` (
    `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
    `table_id` int(10) unsigned NOT NULL COMMENT '操作表ID',
    `table_name` varchar(180) NOT NULL COMMENT '操作表名',
    `user_id` int(10) unsigned NOT NULL COMMENT '操作用户ID',
    `username` varchar(16) NOT NULL COMMENT '操作用户名',
    `action` varchar(180) NOT NULL COMMENT '操作动作',
    `ip` varchar(39) NOT NULL COMMENT '操作IP',
    `record_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT = '操作记录表';

-- 正在导出表  tokay.to_record 的数据：~0 rows (大约)
DELETE FROM
    `to_record`;

/*!40000 ALTER TABLE `to_record` DISABLE KEYS */
;

/*!40000 ALTER TABLE `to_record` ENABLE KEYS */
;