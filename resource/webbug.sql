/*
 Navicat Premium Data Transfer

 Source Server         : phpzc.net
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : www.phpzc.net
 Source Database       : webbug

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : utf-8

 Date: 01/14/2018 15:18:08 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `wb_bug`
-- ----------------------------
DROP TABLE IF EXISTS `wb_bug`;
CREATE TABLE `wb_bug` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bug_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bug_content` text COLLATE utf8mb4_unicode_ci,
  `create_time` datetime DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `current_user_id` int(11) DEFAULT NULL COMMENT '当前bug所属用户',
  `bug_status` tinyint(2) DEFAULT '0' COMMENT 'bug状态码 0刚创建 待处理 1待审核 - 处理完毕 2已解决',
  `priority_status` tinyint(2) DEFAULT '0' COMMENT '优先级  0低 1中 2高',
  `version_id` int(11) DEFAULT NULL COMMENT '版本id',
  `module_id` int(11) DEFAULT NULL COMMENT '模块id',
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='bug表';

-- ----------------------------
--  Table structure for `wb_bug_log`
-- ----------------------------
DROP TABLE IF EXISTS `wb_bug_log`;
CREATE TABLE `wb_bug_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bug_id` bigint(20) DEFAULT NULL,
  `old_user_id` int(11) DEFAULT NULL COMMENT '原BUG所属用户',
  `new_user_id` int(11) DEFAULT NULL COMMENT '分配给的新的用户',
  `content` text COLLATE utf8mb4_unicode_ci,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `old_bug_status` tinyint(2) DEFAULT NULL COMMENT '原BUG处理状态',
  `new_bug_status` tinyint(2) DEFAULT NULL COMMENT '本次操作的设置的BUG的状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='bug修改日志';

-- ----------------------------
--  Table structure for `wb_login_log`
-- ----------------------------
DROP TABLE IF EXISTS `wb_login_log`;
CREATE TABLE `wb_login_log` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `login_date` datetime DEFAULT NULL,
  `login_ip` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='登陆记录';

-- ----------------------------
--  Table structure for `wb_project`
-- ----------------------------
DROP TABLE IF EXISTS `wb_project`;
CREATE TABLE `wb_project` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_ip` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='项目表';

-- ----------------------------
--  Table structure for `wb_project_module`
-- ----------------------------
DROP TABLE IF EXISTS `wb_project_module`;
CREATE TABLE `wb_project_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `module_name` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `wb_project_user`
-- ----------------------------
DROP TABLE IF EXISTS `wb_project_user`;
CREATE TABLE `wb_project_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `wb_project_version`
-- ----------------------------
DROP TABLE IF EXISTS `wb_project_version`;
CREATE TABLE `wb_project_version` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `version_name` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `wb_user`
-- ----------------------------
DROP TABLE IF EXISTS `wb_user`;
CREATE TABLE `wb_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_ip` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_status` tinyint(1) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `nickname` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '昵称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户表';

SET FOREIGN_KEY_CHECKS = 1;
