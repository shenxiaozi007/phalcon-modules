CREATE TABLE `ajb_user` (
`userId` int(11) NOT NULL COMMENT '用户Id',
`username` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
`password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
`mobile` varchar(11) NOT NULL COMMENT '手机号码',
`addTime` int(12) NOT NULL DEFAULT 0 COMMENT '添加时间',
`modifyTime` int(12) NOT NULL DEFAULT 0 COMMENT '修改时间',
`isDel` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0正常 1被删除',
PRIMARY KEY (`userId`) 
)
COMMENT='用户表';

CREATE TABLE `ajb_group` (
`groupId` int(12) NOT NULL COMMENT '管理组Id',
`parentId` int(12) NOT NULL DEFAULT 1 COMMENT '上级Id ',
`groupName` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理组名',
`status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1:启用，0:关闭',
`describe` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '组描述',
`addTime` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '添加时间',
`modifyTime` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '修改时间',
PRIMARY KEY (`groupId`) 
)
COMMENT='后台管理组';

CREATE TABLE `ajb_action` (
`actionId` int(12) NOT NULL COMMENT '节点Id',
`actionName` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '节点名',
`describe` varchar(60) NOT NULL DEFAULT '' COMMENT '节点描述',
`leavel` tinyint(1) NOT NULL DEFAULT 1 COMMENT '节点等级：相当于菜单的一级，二级',
`mark` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户权限字符串，m_c_a',
`parentId` int(12) NOT NULL DEFAULT 0 COMMENT '父节点',
`sort` smallint(8) NOT NULL DEFAULT 0 COMMENT '排序',
`modifyTime` int(12) NOT NULL DEFAULT 0 COMMENT '修改时间',
`addTime` int(12) NOT NULL COMMENT '添加时间',
`status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1:启用，0:关闭',
PRIMARY KEY (`actionId`) 
)
COMMENT='一级菜单。二级菜单。节点表';

CREATE TABLE `ajb_groupUser` (
`groupId` int(12) NOT NULL COMMENT '组Id',
`userId` int(12) NOT NULL COMMENT '用户Id'
)
COMMENT='后台权限用户关联组表';

CREATE TABLE `ajb_groupAction` (
`groupId` int(12) NOT NULL COMMENT '管理组Id',
`actionId` int(12) NOT NULL COMMENT '节点Id',
`level` tinyint(1) NOT NULL COMMENT '节点所属级别'
)
COMMENT='组关联节点表';

CREATE TABLE `ajb_uGroup` (
`uGroupId` int(12) NOT NULL COMMENT '管理组Id',
`parentId` int(12) NOT NULL DEFAULT 1 COMMENT '上级Id ',
`groupName` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理组名',
`status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1:启用，0:关闭',
`describe` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '组描述',
`type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '类型，1:用户组，2:管理组',
`addTime` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '添加时间',
`modifyTime` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '修改时间',
PRIMARY KEY (`uGroupId`) 
)
COMMENT='用户组';

CREATE TABLE `ajb_uGroupUser` (
`uGroupId` int(12) NOT NULL COMMENT '用户组Id',
`userId` int(12) NOT NULL COMMENT '用户Id'
);

CREATE TABLE `ajb_uGroupRule` (
`uGroupId` int(12) NOT NULL COMMENT '用户组Id',
`rule` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则\r\n0字符串规则 mName_cName_aName;\r\n1范围规则 {scroe}>50;',
`type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0字符串规则 mName_cName_aName;\r\n1范围规则 {scroe}>50;',
`describe` varchar(60) NOT NULL DEFAULT '' COMMENT '规则描述'
);


ALTER TABLE `ajb_user` ADD CONSTRAINT `fk_ajb_user_ajb_groupUser_1` FOREIGN KEY (`userId`) REFERENCES `ajb_groupUser` (`userId`);
ALTER TABLE `ajb_groupUser` ADD CONSTRAINT `fk_ajb_groupUser_ajb_group_1` FOREIGN KEY (`groupId`) REFERENCES `ajb_group` (`groupId`);
ALTER TABLE `ajb_action` ADD CONSTRAINT `fk_ajb_action_ajb_groupAction_1` FOREIGN KEY (`actionId`) REFERENCES `ajb_groupAction` (`actionId`);
ALTER TABLE `ajb_group` ADD CONSTRAINT `fk_ajb_group_ajb_groupAction_1` FOREIGN KEY (`groupId`) REFERENCES `ajb_groupAction` (`groupId`);
ALTER TABLE `ajb_user` ADD CONSTRAINT `fk_ajb_user_ajb_uGroupUser_1` FOREIGN KEY (`userId`) REFERENCES `ajb_uGroupUser` (`userId`);
ALTER TABLE `ajb_uGroup` ADD CONSTRAINT `fk_ajb_uGroup_ajb_uGroupConfig_1` FOREIGN KEY (`uGroupId`) REFERENCES `ajb_uGroupRule` (`uGroupId`);
ALTER TABLE `ajb_uGroupUser` ADD CONSTRAINT `fk_ajb_uGroupUser_ajb_uGroup_1` FOREIGN KEY (`uGroupId`) REFERENCES `ajb_uGroup` (`uGroupId`);

