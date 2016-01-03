/*
Navicat MySQL Data Transfer

Source Server         : my
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : dev_ajb_test1

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-01-03 23:47:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ajb_action`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_action`;
CREATE TABLE `ajb_action` (
  `actionId` int(12) NOT NULL COMMENT '节点Id',
  `actionName` varchar(60) NOT NULL COMMENT '节点名',
  `describe` varchar(60) NOT NULL DEFAULT '' COMMENT '节点描述',
  `leavel` tinyint(1) NOT NULL DEFAULT '1' COMMENT '节点等级：相当于菜单的一级，二级',
  `mark` varchar(60) NOT NULL DEFAULT '' COMMENT '用户权限字符串，m_c_a',
  `parentId` int(12) NOT NULL DEFAULT '0' COMMENT '父节点',
  `sort` smallint(8) NOT NULL DEFAULT '0' COMMENT '排序',
  `modifyTime` int(12) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `addTime` int(12) NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:启用，0:关闭',
  PRIMARY KEY (`actionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='一级菜单。二级菜单。节点表';

-- ----------------------------
-- Records of ajb_action
-- ----------------------------

-- ----------------------------
-- Table structure for `ajb_group`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_group`;
CREATE TABLE `ajb_group` (
  `groupId` int(12) NOT NULL AUTO_INCREMENT COMMENT '管理组Id',
  `parentId` int(12) NOT NULL DEFAULT '1' COMMENT '上级Id ',
  `groupName` varchar(30) NOT NULL COMMENT '管理组名',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:启用，0:关闭',
  `describe` varchar(60) NOT NULL DEFAULT '' COMMENT '组描述',
  `addTime` varchar(12) NOT NULL COMMENT '添加时间',
  `modifyTime` varchar(12) NOT NULL DEFAULT '' COMMENT '修改时间',
  PRIMARY KEY (`groupId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台管理组';

-- ----------------------------
-- Records of ajb_group
-- ----------------------------

-- ----------------------------
-- Table structure for `ajb_groupaction`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_groupaction`;
CREATE TABLE `ajb_groupaction` (
  `groupId` int(12) NOT NULL COMMENT '管理组Id',
  `actionId` int(12) NOT NULL COMMENT '节点Id',
  `level` tinyint(1) NOT NULL COMMENT '节点所属级别'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='组关联节点表';

-- ----------------------------
-- Records of ajb_groupaction
-- ----------------------------

-- ----------------------------
-- Table structure for `ajb_groupuser`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_groupuser`;
CREATE TABLE `ajb_groupuser` (
  `groupId` int(12) NOT NULL COMMENT '组Id',
  `userId` int(12) NOT NULL COMMENT '用户Id',
  KEY `fk_ajb_groupUser_ajb_group_1` (`groupId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台权限用户关联组表';

-- ----------------------------
-- Records of ajb_groupuser
-- ----------------------------

-- ----------------------------
-- Table structure for `ajb_ugroup`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_ugroup`;
CREATE TABLE `ajb_ugroup` (
  `uGroupId` int(12) NOT NULL AUTO_INCREMENT COMMENT '管理组Id',
  `parentId` int(12) NOT NULL DEFAULT '1' COMMENT '上级Id ',
  `groupName` varchar(30) NOT NULL COMMENT '管理组名',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:启用，0:关闭',
  `describe` varchar(60) NOT NULL DEFAULT '' COMMENT '组描述',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型，1:用户组，2:管理组',
  `addTime` varchar(12) NOT NULL COMMENT '添加时间',
  `modifyTime` varchar(12) NOT NULL DEFAULT '' COMMENT '修改时间',
  PRIMARY KEY (`uGroupId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组';

-- ----------------------------
-- Records of ajb_ugroup
-- ----------------------------

-- ----------------------------
-- Table structure for `ajb_ugrouprule`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_ugrouprule`;
CREATE TABLE `ajb_ugrouprule` (
  `uGroupId` int(12) NOT NULL COMMENT '用户组Id',
  `rule` varchar(120) NOT NULL DEFAULT '' COMMENT '规则\r\n0字符串规则 mName_cName_aName;\r\n1范围规则 {scroe}>50;',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0字符串规则 mName_cName_aName;\r\n1范围规则 {scroe}>50;',
  `describe` varchar(60) NOT NULL DEFAULT '' COMMENT '规则描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ajb_ugrouprule
-- ----------------------------

-- ----------------------------
-- Table structure for `ajb_ugroupuser`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_ugroupuser`;
CREATE TABLE `ajb_ugroupuser` (
  `uGroupId` int(12) NOT NULL COMMENT '用户组Id',
  `userId` int(12) NOT NULL COMMENT '用户Id',
  KEY `fk_ajb_uGroupUser_ajb_uGroup_1` (`uGroupId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ajb_ugroupuser
-- ----------------------------

-- ----------------------------
-- Table structure for `ajb_user`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_user`;
CREATE TABLE `ajb_user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户Id',
  `username` varchar(60) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  `addTime` int(12) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `modifyTime` int(12) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常 1被删除',
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of ajb_user
-- ----------------------------
INSERT INTO `ajb_user` VALUES ('1', 'admin', '123456', '', '1451835631', '0', '0');
INSERT INTO `ajb_user` VALUES ('2', 'admin', 'c354ffcd96af5d8b418d22690557d5fe', '', '1451835905', '0', '0');
