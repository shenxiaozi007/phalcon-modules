

SET FOREIGN_KEY_CHECKS=0;


DROP TABLE IF EXISTS `ajb_defect`;
CREATE TABLE `ajb_defect` (
  `defectId` int(10) NOT NULL AUTO_INCREMENT,
  `plateId` int(10) NOT NULL COMMENT '所属市场id',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '地址详情',
  `manageTypeId` int(3) NOT NULL COMMENT '检查类型id',
  `describeBefore` varchar(255) NOT NULL DEFAULT '' COMMENT '整改前缺陷描述',
  `imgIdsBefore` varchar(255) NOT NULL DEFAULT '' COMMENT '整改前现场图片 最多9张 用逗号隔开 单张imgId24位',
  `userIdBefore` int(9) NOT NULL COMMENT '整改前用户id',
  `addTimeBefore` int(10) NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0待确认 1延期待办 2整改中 3已经整改 4已闭环 5未闭环 6已反弹 7已延期 ',
  `modifyTime` int(10) NOT NULL COMMENT '最后编辑时间',
  `describeAfter` varchar(255) NOT NULL DEFAULT '' COMMENT '整改后缺陷描述',
  `imgIdsAfter` varchar(255) NOT NULL DEFAULT '' COMMENT '整改后缺陷图片',
  `userIdAfter` int(9) NOT NULL COMMENT '整改后用户id',
  `addTimeAfter` int(10) NOT NULL COMMENT '整改后添加的时间',
  PRIMARY KEY (`defectId`),
  KEY `fk_ajb_defect_ajb_plate_1` (`plateId`),
  KEY `fk_ajb_defect_ajb_manageType_1` (`manageTypeId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='缺陷表';


INSERT INTO `ajb_defect` VALUES ('1', '1', '大石测试', '7', '5645', '', '20', '1449470848', '1', '0', '', '', '0', '0');
INSERT INTO `ajb_defect` VALUES ('2', '1', '', '7', '', '123456789', '21', '1449569188', '0', '0', '', '', '0', '0');
INSERT INTO `ajb_defect` VALUES ('3', '4', '12313', '7', '14312412', '123456789', '21', '1449569323', '0', '0', '', '', '0', '0');
INSERT INTO `ajb_defect` VALUES ('5', '4', '测试地址', '7', '测试描述', '166464854553', '21', '1449569945', '3', '1449570651', '测试整改完成', '789456123', '22', '1449570943');
INSERT INTO `ajb_defect` VALUES ('6', '4', '测试地址9', '7', '测试描述9', '166464854553', '26', '1449646691', '0', '0', '', '', '0', '0');

-- ----------------------------
-- Table structure for `ajb_defectdelay`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_defectdelay`;
CREATE TABLE `ajb_defectdelay` (
  `delayId` int(10) NOT NULL AUTO_INCREMENT,
  `defectId` int(10) NOT NULL DEFAULT '0' COMMENT '缺陷id',
  `applyUserId` int(10) NOT NULL DEFAULT '0' COMMENT '申请延期的用户id',
  `planTime` int(10) NOT NULL DEFAULT '0' COMMENT '计划整改时间',
  `reason` varchar(255) NOT NULL DEFAULT '' COMMENT '延期待办理由',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 申请中 1 批准 2 不批准',
  `chekUserId` int(10) NOT NULL DEFAULT '0' COMMENT '审核待办的用户id',
  `failMessage` varchar(255) NOT NULL DEFAULT '' COMMENT '不批准的理由',
  `addTime` int(10) NOT NULL DEFAULT '0' COMMENT '添加申请的时间',
  PRIMARY KEY (`delayId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='缺陷整改待办表';

-- ----------------------------
-- Records of ajb_defectdelay
-- ----------------------------
INSERT INTO `ajb_defectdelay` VALUES ('1', '4', '21', '1450540800', '测试延期', '0', '0', '', '1449571147');
INSERT INTO `ajb_defectdelay` VALUES ('2', '4', '21', '1450540800', '测试延期', '0', '0', '', '1449571212');

-- ----------------------------
-- Table structure for `ajb_defectlog`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_defectlog`;
CREATE TABLE `ajb_defectlog` (
  `defectLogId` int(10) NOT NULL AUTO_INCREMENT,
  `defectId` int(10) NOT NULL COMMENT '缺陷表id',
  `defectStatus` int(2) NOT NULL COMMENT '缺陷表状态',
  `describe` varchar(120) NOT NULL,
  `addUserId` int(11) NOT NULL COMMENT '添加人id',
  `addTime` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`defectLogId`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='缺陷日志表';

-- ----------------------------
-- Records of ajb_defectlog
-- ----------------------------
INSERT INTO `ajb_defectlog` VALUES ('1', '5', '3', '', '20', '1449570477');
INSERT INTO `ajb_defectlog` VALUES ('2', '5', '2', '', '20', '1449570614');
INSERT INTO `ajb_defectlog` VALUES ('3', '5', '4', '', '20', '1449570651');
INSERT INTO `ajb_defectlog` VALUES ('4', '5', '3', '', '20', '1449570943');
INSERT INTO `ajb_defectlog` VALUES ('5', '4', '1', '', '20', '1449571147');

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
  `modifyTime` varchar(12) NOT NULL COMMENT '添加时间',
  `sort` int(2) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`groupId`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='后台管理组';

-- ----------------------------
-- Records of ajb_group
-- ----------------------------
INSERT INTO `ajb_group` VALUES ('1', '1', 'admin_user_list', '1', '用户管理权限', '1449643248', '0');
INSERT INTO `ajb_group` VALUES ('6', '1', 'admin_group_list', '1', '角色管理权限', '1449643127', '0');
INSERT INTO `ajb_group` VALUES ('7', '1', 'admin_resource_list', '1', '资源管理权限', '1449643161', '0');

-- ----------------------------
-- Table structure for `ajb_groupresource`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_groupresource`;
CREATE TABLE `ajb_groupresource` (
  `groupId` int(12) NOT NULL COMMENT '管理组Id',
  `resourceId` int(12) NOT NULL COMMENT '节点Id',
  `level` tinyint(1) NOT NULL COMMENT '节点所属级别'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='组关联节点表';

-- ----------------------------
-- Records of ajb_groupresource
-- ----------------------------
INSERT INTO `ajb_groupresource` VALUES ('1', '5', '1');
INSERT INTO `ajb_groupresource` VALUES ('1', '4', '1');

-- ----------------------------
-- Table structure for `ajb_groupuser`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_groupuser`;
CREATE TABLE `ajb_groupuser` (
  `groupId` int(12) NOT NULL COMMENT '组Id',
  `userId` int(12) NOT NULL COMMENT '用户Id',
  KEY `fk_ajb_groupUser_ajb_groupAction_1` (`groupId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台权限用户关联组表';

-- ----------------------------
-- Records of ajb_groupuser
-- ----------------------------
INSERT INTO `ajb_groupuser` VALUES ('7', '21');
INSERT INTO `ajb_groupuser` VALUES ('6', '21');

-- ----------------------------
-- Table structure for `ajb_managetype`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_managetype`;
CREATE TABLE `ajb_managetype` (
  `manageTypeId` int(10) NOT NULL AUTO_INCREMENT COMMENT '管理类型id',
  `typeName` varchar(80) NOT NULL DEFAULT '' COMMENT '类型名称',
  PRIMARY KEY (`manageTypeId`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='管理类型表\r\n物业管理里，安全管理，客服管理等等';

-- ----------------------------
-- Records of ajb_managetype
-- ----------------------------
INSERT INTO `ajb_managetype` VALUES ('7', '物业');
INSERT INTO `ajb_managetype` VALUES ('8', '物业23');
INSERT INTO `ajb_managetype` VALUES ('9', '2545');
INSERT INTO `ajb_managetype` VALUES ('10', '12332');
INSERT INTO `ajb_managetype` VALUES ('11', '安全管理8');
INSERT INTO `ajb_managetype` VALUES ('12', '阿斯顿发放');

-- ----------------------------
-- Table structure for `ajb_plate`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_plate`;
CREATE TABLE `ajb_plate` (
  `plateId` int(10) NOT NULL AUTO_INCREMENT COMMENT '板块id',
  `parentId` int(10) NOT NULL,
  `plateName` varchar(100) NOT NULL DEFAULT '' COMMENT '板块名称或市场名称',
  `plateType` int(3) NOT NULL DEFAULT '0' COMMENT '类型 1板块 2市场',
  PRIMARY KEY (`plateId`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='板块和市场表';

-- ----------------------------
-- Records of ajb_plate
-- ----------------------------
INSERT INTO `ajb_plate` VALUES ('1', '0', '广州', '1');
INSERT INTO `ajb_plate` VALUES ('2', '1', '番禺', '2');
INSERT INTO `ajb_plate` VALUES ('3', '4', '大石', '1');
INSERT INTO `ajb_plate` VALUES ('4', '0', '南沙', '1');

-- ----------------------------
-- Table structure for `ajb_resource`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_resource`;
CREATE TABLE `ajb_resource` (
  `resourceId` int(12) NOT NULL AUTO_INCREMENT COMMENT '节点Id',
  `resourceName` varchar(60) NOT NULL COMMENT '节点名',
  `describe` varchar(60) NOT NULL DEFAULT '' COMMENT '节点描述',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '节点等级：相当于菜单的一级，二级',
  `parentId` int(12) NOT NULL DEFAULT '0' COMMENT '父节点',
  `sort` smallint(8) NOT NULL DEFAULT '0' COMMENT '排序',
  `modifyTime` int(12) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:启用，0:关闭',
  PRIMARY KEY (`resourceId`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='一级菜单。二级菜单。节点表';

-- ----------------------------
-- Records of ajb_resource
-- ----------------------------
INSERT INTO `ajb_resource` VALUES ('8', 'admin_login_reg', '用户注册', '2', '7', '0', '1449643803', '1');
INSERT INTO `ajb_resource` VALUES ('2', 'admin_user_list', '用户管理权限', '1', '0', '3', '1449641015', '1');
INSERT INTO `ajb_resource` VALUES ('4', 'admin_user_edit', '编辑用户', '2', '2', '6', '1449570860', '1');
INSERT INTO `ajb_resource` VALUES ('5', 'admin_user_add', '添加用户', '2', '2', '0', '1449640986', '1');
INSERT INTO `ajb_resource` VALUES ('6', 'admin_user_stop', '警用用户', '2', '2', '0', '1449643471', '1');
INSERT INTO `ajb_resource` VALUES ('7', 'admin_login_index', '用户登录', '1', '0', '0', '1449643550', '1');

-- ----------------------------
-- Table structure for `ajb_resourceannex`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_resourceannex`;
CREATE TABLE `ajb_resourceannex` (
  `annexId` int(10) NOT NULL AUTO_INCREMENT,
  `rule` varchar(120) NOT NULL DEFAULT '' COMMENT '积分规则',
  `resourceId` int(11) NOT NULL COMMENT 'resource表的id',
  `describe` varchar(60) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`annexId`),
  KEY `fk_ajb_actionAnnex_ajb_action_1` (`resourceId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='资源附件表 包括积分或付费金额等等对于的资源';

-- ----------------------------
-- Records of ajb_resourceannex
-- ----------------------------

-- ----------------------------
-- Table structure for `ajb_user`
-- ----------------------------
DROP TABLE IF EXISTS `ajb_user`;
CREATE TABLE `ajb_user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户Id',
  `username` varchar(60) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `nickname` varchar(64) NOT NULL DEFAULT '' COMMENT '昵称',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  `mobileprefixId` int(6) NOT NULL DEFAULT '0' COMMENT '手机号码的区号',
  `userAvatar` varchar(60) NOT NULL DEFAULT '' COMMENT '用户头像',
  `addTime` int(10) unsigned NOT NULL COMMENT '添加时间',
  `modifyTime` int(10) NOT NULL COMMENT '编辑时间',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常 1被删除',
  `marketName` varchar(80) NOT NULL DEFAULT '' COMMENT '市场名称',
  `marketPlateId` int(3) NOT NULL DEFAULT '0' COMMENT '市场id(数据来自Plate板块表)',
  `sectionName` varchar(80) NOT NULL DEFAULT '' COMMENT '部门名称',
  `sectionPlateId` int(3) NOT NULL DEFAULT '0' COMMENT '部门id(数据来自Plate板块表)',
  `token` varchar(32) NOT NULL DEFAULT '' COMMENT '快捷登录时token',
  `tokenAddTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'token添加时间',
  `tokenExpireTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'token有效时间',
  `lastLoginTime` int(10) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `apkBuild` varchar(23) NOT NULL DEFAULT '' COMMENT 'apk版本',
  PRIMARY KEY (`userId`),
  KEY `fk_ajb_user_ajb_plate_1` (`marketPlateId`),
  KEY `fk_ajb_user_ajb_plate_2` (`sectionPlateId`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of ajb_user
-- ----------------------------
INSERT INTO `ajb_user` VALUES ('21', '小女人', '10bb539d82e7cc2a98015f73ef34588c', '小女人昵称', '13434997556', '0', '', '1449468258', '0', '0', '', '0', '', '0', '', '0', '0', '0', '');
INSERT INTO `ajb_user` VALUES ('22', '13434997543', '10bb539d82e7cc2a98015f73ef34588c', '', '13434997557', '0', '', '1449468637', '0', '0', '', '0', '', '0', '', '0', '0', '0', '');
INSERT INTO `ajb_user` VALUES ('20', '13434997552', '10bb539d82e7cc2a98015f73ef34588c', '', '13434997550', '0', '', '1449467548', '0', '0', '', '0', '', '0', '', '0', '0', '0', '');
INSERT INTO `ajb_user` VALUES ('26', 'admin', '10bb539d82e7cc2a98015f73ef34588c', '', '13434997550', '0', '', '1449544542', '0', '0', '', '0', '', '0', '7c8b377dc3fd257ff09b64bc4fc1104c', '1449646654', '1450942654', '0', '2.0.0');
INSERT INTO `ajb_user` VALUES ('25', '123456', '10bb539d82e7cc2a98015f73ef34588c', '', '13434997550', '0', '', '1449544432', '0', '0', '', '0', '', '0', '', '0', '0', '0', '');
INSERT INTO `ajb_user` VALUES ('27', '143432', '10bb539d82e7cc2a98015f73ef34588c', '', '13434997552', '0', '', '1449553150', '0', '0', '', '0', '', '0', '', '0', '0', '0', '');
INSERT INTO `ajb_user` VALUES ('28', 'admin', 'efedf29b62614a4c5b34269a1b7806d0', '', '13799999999', '0', '', '1449626056', '0', '0', '', '0', '', '0', '', '0', '0', '0', '');
INSERT INTO `ajb_user` VALUES ('29', 'admin123', 'c354ffcd96af5d8b418d22690557d5fe', '', '15975502469', '0', '', '1449627118', '0', '0', '', '0', '', '0', '', '0', '0', '0', '');
INSERT INTO `ajb_user` VALUES ('30', 'test', 'acd79eb1e05ddd3a165b4a45e572554d', '', '13799999999', '0', '', '1449630249', '0', '0', '', '0', '', '0', '', '0', '0', '0', '');
