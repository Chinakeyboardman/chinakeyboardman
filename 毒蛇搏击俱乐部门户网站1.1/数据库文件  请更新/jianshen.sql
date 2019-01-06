/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : jianshen

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-08-29 15:36:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for js_activity
-- ----------------------------
DROP TABLE IF EXISTS `js_activity`;
CREATE TABLE `js_activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext,
  `status` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_activity
-- ----------------------------
INSERT INTO `js_activity` VALUES ('1', '/upload\\20180716\\d32cc54115148b9fa3b72d3caa6f9de7.jpg', '&lt;p&gt;去去去QQ群群群群群群群群群群群群&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;/public/ueditor/php/upload/image/20180716/1531730246127051.png&quot; title=&quot;1531730246127051.png&quot; alt=&quot;q.png&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;/public/ueditor/php/upload/image/20180716/1531730253595688.jpg&quot; title=&quot;1531730253595688.jpg&quot; alt=&quot;哆啦A梦.jpg&quot;/&gt;&lt;/p&gt;', '1', '2018-07-16 04:38:49', '2018-07-16 04:50:11', '活动一');
INSERT INTO `js_activity` VALUES ('2', '/upload\\20180716\\c362c99cb7fd8ec2a0d450790b25572f.jpg', '&lt;p&gt;从自行车在&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;/public/ueditor/php/upload/image/20180716/1531730977725300.jpg&quot; title=&quot;1531730977725300.jpg&quot; alt=&quot;哆啦A梦.jpg&quot;/&gt;&lt;/p&gt;', '1', '2018-07-16 04:49:40', '2018-07-16 04:49:40', '活动二');
INSERT INTO `js_activity` VALUES ('3', '/upload\\20180716\\acd7c4439d1d34fab14547a109fbf72b.jpg', '&lt;p&gt;&lt;strong&gt;这些&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;/public/ueditor/php/upload/image/20180716/1531731000803618.png&quot; title=&quot;1531731000803618.png&quot; alt=&quot;q.png&quot;/&gt;&lt;/p&gt;', '1', '2018-07-16 04:50:02', '2018-07-16 05:12:48', '活动三');

-- ----------------------------
-- Table structure for js_card
-- ----------------------------
DROP TABLE IF EXISTS `js_card`;
CREATE TABLE `js_card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `term` varchar(255) DEFAULT NULL,
  `description` longtext,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_card
-- ----------------------------
INSERT INTO `js_card` VALUES ('1', '团课期限卡', '1', '2018-07-18 14:16:09', '2018-07-18 14:20:19', '20', '1', '&lt;p&gt;团课期限卡&lt;/p&gt;', '/upload\\20180718\\40ae09847795d8d646fc6c25dadb50c7.jpg');
INSERT INTO `js_card` VALUES ('2', '器材区期限卡', '1', '2018-07-18 14:20:40', '2018-07-18 14:20:40', '20', '1', '&lt;p&gt;器材区期限卡&lt;/p&gt;', '/upload\\20180718\\a3fecd3bf08fc2fca3c1417249901534.jpg');
INSERT INTO `js_card` VALUES ('3', '高级会员期限卡', '1', '2018-07-18 14:21:28', '2018-07-18 14:21:28', '30', '1', '&lt;p&gt;团课期限卡+器材区期限卡&lt;/p&gt;', '/upload\\20180718\\975e86447edf34b94f2a287bc04d6dfc.jpg');
INSERT INTO `js_card` VALUES ('4', '会员卡试试', '-1', '2018-07-18 19:27:36', '0000-00-00 00:00:00', '1', null, '&lt;p&gt;相处自行车&lt;/p&gt;', '/upload\\20180718\\7be3d3bb0085306d32572d34613dea4d.jpg');

-- ----------------------------
-- Table structure for js_coach
-- ----------------------------
DROP TABLE IF EXISTS `js_coach`;
CREATE TABLE `js_coach` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `special` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_coach
-- ----------------------------
INSERT INTO `js_coach` VALUES ('1', '教练1', '12', '12', '12', '123434', '2018-07-10 07:37:31', '0000-00-00 00:00:00', '1', '', '2,');
INSERT INTO `js_coach` VALUES ('2', '教练2', '12', '12', '12', '+86-532-8099 2361', '2018-07-10 07:38:39', '0000-00-00 00:00:00', '1', '/upload\\20180710\\e043a0da881a0e76d31a869eb217187e.jpg', '3,1,');
INSERT INTO `js_coach` VALUES ('3', '教练3', '30', '23', '23', '23232323', '2018-07-10 09:33:03', '0000-00-00 00:00:00', '1', '/upload\\20180710\\f052a8b338c4196c9a7389f5e626633c.jpg', '1,2,3,');
INSERT INTO `js_coach` VALUES ('4', '教练4', '12', '0', '0', '11111111111', '2018-07-10 03:22:25', '0000-00-00 00:00:00', '1', '/upload\\20180710\\a8c29d5e0592ccf9467bd30f7661ee00.jpg', '2,');
INSERT INTO `js_coach` VALUES ('5', '绸缪', '12', '0', '0', '11111111111', '2018-07-17 02:41:28', '0000-00-00 00:00:00', '1', '/upload\\20180717\\146272e9dc29130adf357d7da51f2036.jpg', '3,2,');

-- ----------------------------
-- Table structure for js_contact
-- ----------------------------
DROP TABLE IF EXISTS `js_contact`;
CREATE TABLE `js_contact` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contact` varchar(255) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_contact
-- ----------------------------
INSERT INTO `js_contact` VALUES ('1', 'QQ:12345678', '2018-07-19 08:35:20');

-- ----------------------------
-- Table structure for js_course
-- ----------------------------
DROP TABLE IF EXISTS `js_course`;
CREATE TABLE `js_course` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `coach_id` int(10) DEFAULT NULL,
  `brief` longtext,
  `price` decimal(10,0) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `special` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_course
-- ----------------------------
INSERT INTO `js_course` VALUES ('1', '仰卧起坐', '/upload\\20180710\\ca83c6c43c4300aab2f245e76ac4004e.jpg', '2018-07-10 01:17:25', '0000-00-00 00:00:00', '1', '2', '&lt;p&gt;&lt;img src=&quot;/public/ueditor/php/upload/image/20180710/1531199802121594.jpg&quot; title=&quot;1531199802121594.jpg&quot; alt=&quot;timg (2).jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;asdsadas&lt;/p&gt;', '9', '2018-07-10 18:11:13', '2018-08-11 18:11:17', 'privacy', null);
INSERT INTO `js_course` VALUES ('2', '俯卧撑', '/upload\\20180710\\307d86a9e454fcf5f1eea1c377655030.jpg', '2018-07-10 01:43:28', '0000-00-00 00:00:00', '1', '3', '&lt;p&gt;dfdsfdfd&lt;/p&gt;', '8', '2018-07-16 18:11:02', '2018-08-11 18:11:05', 'privacy', null);
INSERT INTO `js_course` VALUES ('3', '跑步', '/upload\\20180710\\4c7562424c27f0e980ee1eab8cde5c74.jpg', '2018-07-10 10:45:55', '0000-00-00 00:00:00', '1', '3', '&lt;p&gt;&lt;img src=&quot;/public/ueditor/php/upload/image/20180710/1531233952769967.jpg&quot; title=&quot;1531233952769967.jpg&quot; alt=&quot;欲买桂花同载酒.jpg&quot;/&gt;&lt;/p&gt;', '101', '2018-07-16 18:10:52', '2018-08-06 18:10:54', 'public', null);
INSERT INTO `js_course` VALUES ('4', '课程2', '/upload\\20180710\\0457e1e919fd088cb75d188be5d4a2dd.jpg', '2018-07-10 11:35:07', '0000-00-00 00:00:00', '1', '4', '&lt;p&gt;问我群二群无&lt;/p&gt;', '199', '2018-07-16 18:12:18', '2018-08-04 18:12:21', 'privacy', null);
INSERT INTO `js_course` VALUES ('5', '伸腿运动', '/upload\\20180710\\294c916062ec12d8796fd53fc0ec4c44.jpg', '2018-07-10 11:35:50', '0000-00-00 00:00:00', '1', '4', '&lt;p&gt;问我群二群无&lt;/p&gt;', '199', '2018-07-16 18:10:43', '2018-08-09 18:10:45', 'privacy', null);
INSERT INTO `js_course` VALUES ('6', '跑步', '/upload\\20180716\\030d63af467b7c6d17204702b1ffa4b3.jpg', '2018-07-16 06:03:56', '0000-00-00 00:00:00', '1', '4', '&lt;p&gt;嗯我翁无谁谁谁谁谁谁所所所所所所所所所所所&lt;/p&gt;', '199', '2018-07-16 18:02:06', '2018-08-06 18:02:08', 'public', null);
INSERT INTO `js_course` VALUES ('7', '课程1', '/upload\\20180717\\fc6c3a0b594568ecdc8ae8b79d1631a0.jpg', '2018-07-17 10:20:46', '0000-00-00 00:00:00', '1', '4', '&lt;p&gt;萨达所大所大所多撒多所大所大所多&lt;/p&gt;', '199', '2018-07-17 10:20:24', '2018-08-11 10:20:26', 'privacy', null);
INSERT INTO `js_course` VALUES ('8', '团体课', '/upload\\20180717\\96ab9ee065597267fccf90026aaf3fff.jpg', '2018-07-17 01:43:11', '2018-07-17 01:43:11', '1', '3', '&lt;p&gt;下呈现出想从&lt;/p&gt;', '199', '2018-07-17 13:41:53', '2018-07-18 13:42:04', 'public', null);
INSERT INTO `js_course` VALUES ('9', '团体课', '/upload\\20180717\\80f4d0d8f3e65f4c82b7ee588ed446b1.jpg', '2018-07-17 01:45:19', '2018-07-17 01:45:19', '1', '3', '&lt;p&gt;地方的辅导费&lt;/p&gt;', '199', '2018-07-17 13:45:09', '2018-07-18 13:45:10', 'public', null);
INSERT INTO `js_course` VALUES ('10', '团体课', '/upload\\20180717\\80f4d0d8f3e65f4c82b7ee588ed446b1.jpg', '2018-07-17 01:46:09', '2018-07-17 01:46:09', '1', '3', '&lt;p&gt;地方的辅导费&lt;/p&gt;', '199', '2018-07-17 13:45:09', '2018-07-18 13:45:10', 'public', null);
INSERT INTO `js_course` VALUES ('11', '团体课ss', '/upload\\20180717\\80f4d0d8f3e65f4c82b7ee588ed446b1.jpg', '2018-07-17 01:46:24', '0000-00-00 00:00:00', '1', '3', '&lt;p&gt;地方的辅导费&lt;/p&gt;', '199', '2018-07-17 13:45:09', '2018-07-18 13:45:10', 'public', null);
INSERT INTO `js_course` VALUES ('12', '私教课1ss', '/upload\\20180717\\f620ecbbb41a305fa6c3ed01754376e1.jpg', '2018-07-17 01:52:31', '0000-00-00 00:00:00', '1', '0', '&lt;p&gt;宣传宣传&lt;/p&gt;', '199', '2018-07-17 13:52:17', '2018-07-18 13:52:19', 'privacy', '3');
INSERT INTO `js_course` VALUES ('13', 'sijiao453434', '/upload\\20180717\\994690090def9548de963415acec51cf.jpg', '2018-07-17 03:21:55', '0000-00-00 00:00:00', '1', null, '&lt;p&gt;44&lt;/p&gt;', '101', '2018-07-17 15:21:22', '2018-07-27 15:21:24', 'privacy', '2');

-- ----------------------------
-- Table structure for js_equipment
-- ----------------------------
DROP TABLE IF EXISTS `js_equipment`;
CREATE TABLE `js_equipment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `term` int(11) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `description` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_equipment
-- ----------------------------
INSERT INTO `js_equipment` VALUES ('1', '跑步机', '1', '24', '/upload\\20180717\\e8d716dc6bee2afd68a7ad347c786305.jpg', '1', '2018-07-17 19:07:42', '2018-07-17 19:12:37', null);
INSERT INTO `js_equipment` VALUES ('2', '健身车', '1', '20', '/upload\\20180717\\120be62b16f57be694732ecc570ddb1a.jpg', '1', '2018-07-17 19:14:44', '2018-07-17 19:14:44', null);
INSERT INTO `js_equipment` VALUES ('3', '划船器', '1', '20', '/upload\\20180717\\5d8e114bffdf65a7a343c03df9a0fc97.jpg', '1', '2018-07-17 19:14:55', '2018-07-17 19:23:44', '&lt;p&gt;sfdsfdsfdfsdf&lt;/p&gt;');
INSERT INTO `js_equipment` VALUES ('5', '动感单车', '12', '199', '/upload\\20180718\\297908332b497c7f2de4971f5914ffb1.jpg', '1', '2018-07-18 09:29:54', '2018-07-18 09:29:54', '&lt;p&gt;阿萨飒飒飒飒&lt;/p&gt;');
INSERT INTO `js_equipment` VALUES ('7', '器材订单', null, '20', '/upload\\20180718\\90139fd11a59b055cdb6dbac6ce6f7fc.jpg', '-1', '2018-07-18 19:30:33', '0000-00-00 00:00:00', '&lt;p&gt;相处&lt;/p&gt;');

-- ----------------------------
-- Table structure for js_gallery
-- ----------------------------
DROP TABLE IF EXISTS `js_gallery`;
CREATE TABLE `js_gallery` (
  `id` varchar(255) NOT NULL,
  `gallery` longtext,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_gallery
-- ----------------------------
INSERT INTO `js_gallery` VALUES ('1', '|/upload\\20180829\\49a75632305f3b604673b267ae772fff.jpg|/upload\\20180829\\d138947d292d86191969357474a2cd6c.jpg|/upload\\20180829\\71ea4678ca093f50b05c8ba06b8d958c.jpg|/upload\\20180829\\a8e4817078393fe0febd302b1b35265d.jpg|/upload\\20180829\\35f4bb709ac948b7e9f24a26f359fbae.jpg|/upload\\20180829\\87e685333dbfab5b1b27e71b4257ac6a.jpg|/upload\\20180829\\9ddcaea16c71973dcee22ce2ae736a88.jpg|/upload\\20180829\\b95f8381a8a54908083ce3a7f7243a2d.jpg|/upload\\20180829\\e8644da8609679f9a39c01ac6761ffd9.jpg|/upload\\20180828\\106ca2ddc0c12cb597232905f45d5c1d.jpg|/upload\\20180828\\89da6e0efc17144af865de74c95dd77d.jpg|/upload\\20180828\\47a5a4461639a6b63cf9632fc188b636.jpg|/upload\\20180828\\eb2c4933a46ecad2ad57f9d9128f2969.jpg|/upload\\20180828\\673c71b1a6ccbdff96f8d82cb58292ce.jpg|/upload\\20180828\\d4cc5cb947088ad08e64fc280b635031.jpg|/upload\\20180828\\f329040ca3fae3f616a7884df54662d6.jpg|/upload\\20180828\\cd85c6802572882e760711bf1e1b020b.jpg|/upload\\20180828\\c8d3ead6732220954e69fb97acd3addf.jpg|/upload\\20180828\\01315ebbbf46b9e38956aaff1a0cf361.jpg|/upload\\20180828\\452acc5a1c1ee85798fef82a9f7e31d2.jpg|/upload\\20180828\\8713ea836bb50bca6bd75cdc94ecd6bf.jpg|/upload\\20180828\\ab598b12b1f8fbbfadd3e412f653c9b2.jpg|/upload\\20180828\\c3a08d2c210675a09ec6790645c966ca.jpg|/upload\\20180828\\ba746a6658864735940764b20e2fdf24.jpg|/upload\\20180828\\43d00427127219db06562b040bbe4c78.jpg|/upload\\20180828\\2859bc70d5e3bdfb926beb41780c664f.jpg|/upload\\20180828\\ab94189ed7732042637cd2d4f0bda42e.jpg|/upload\\20180828\\9df940e6b3ceeb2d3e0f3f6046e42802.jpg|/upload\\20180828\\ed106f91cb03d6efcdc2c64236e9275f.jpg', '1');

-- ----------------------------
-- Table structure for js_notice
-- ----------------------------
DROP TABLE IF EXISTS `js_notice`;
CREATE TABLE `js_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_notice
-- ----------------------------
INSERT INTO `js_notice` VALUES ('1', 'xzcxzcxzxcxzc行政村自行车自行车谁谁谁111', '2018-07-11 06:49:17', '0000-00-00 00:00:00', '1');
INSERT INTO `js_notice` VALUES ('2', '电风扇的范德萨发的说法是的范德萨', '2018-07-11 06:53:40', '2018-07-11 06:53:40', '1');
INSERT INTO `js_notice` VALUES ('3', '的非官方的股份的风格', '2018-07-11 06:53:44', '2018-07-11 06:53:44', '1');
INSERT INTO `js_notice` VALUES ('4', '沙发沙发是飞洒发的说法', '2018-07-11 06:53:49', '2018-07-11 06:53:49', '1');
INSERT INTO `js_notice` VALUES ('5', '萨达所大所大所多撒多所大所大所多', '2018-07-11 06:53:56', '2018-07-11 06:53:56', '1');
INSERT INTO `js_notice` VALUES ('6', 'asdsadasdasdasdasda', '2018-07-11 06:57:15', '2018-07-11 06:57:15', '1');

-- ----------------------------
-- Table structure for js_order
-- ----------------------------
DROP TABLE IF EXISTS `js_order`;
CREATE TABLE `js_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `coach_name` varchar(255) DEFAULT NULL,
  `yuyue_time` datetime DEFAULT NULL,
  `term` varchar(255) DEFAULT NULL,
  `expiry_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_order
-- ----------------------------
INSERT INTO `js_order` VALUES ('136', '14', '8', '1', '2018-07-18 19:20:58', '199', '2018-07-18 19:20:58', 'public', '3', '教练3', null, '1', '2018-08-18 19:20:58');
INSERT INTO `js_order` VALUES ('137', '14', '6', '1', '2018-07-18 19:20:58', '199', '2018-07-18 19:20:58', 'public', '4', '教练4', null, '1', '2018-08-18 19:20:58');
INSERT INTO `js_order` VALUES ('17', '14', '1', '1', '2018-07-17 17:19:51', '9', '2018-07-17 17:19:51', 'privacy', '1', '教练1', '2018-07-17 17:19:48', null, null);
INSERT INTO `js_order` VALUES ('18', '14', '13', '1', '2018-07-17 17:31:57', '101', '2018-07-17 17:31:57', 'privacy', '4', '教练4', '2018-07-17 17:31:53', null, null);
INSERT INTO `js_order` VALUES ('19', '14', '2', '1', '2018-07-17 18:24:59', '8', '2018-07-17 18:24:59', 'privacy', '3', '教练3', '2018-07-17 18:24:55', null, null);
INSERT INTO `js_order` VALUES ('20', '14', '3', '1', '2018-07-17 19:35:38', '20', '2018-07-17 19:35:38', null, null, null, null, null, null);
INSERT INTO `js_order` VALUES ('21', '14', '5', '1', '2018-07-17 21:28:01', '199', '2018-07-17 21:28:01', 'privacy', '3', '教练3', '2018-07-17 21:27:56', null, null);
INSERT INTO `js_order` VALUES ('132', '14', '3', '1', '2018-07-18 19:20:58', '30', '2018-07-18 19:20:58', 'card', null, null, null, '1', '2018-08-18 19:20:58');
INSERT INTO `js_order` VALUES ('133', '14', '11', '1', '2018-07-18 19:20:58', '199', '2018-07-18 19:20:58', 'public', '3', '教练3', null, '1', '2018-08-18 19:20:58');
INSERT INTO `js_order` VALUES ('45', '14', '1', '1', '2018-07-18 17:42:40', '72', '2018-07-18 17:42:40', 'equipment', null, null, null, '3', '2018-10-18 17:42:40');
INSERT INTO `js_order` VALUES ('134', '14', '10', '1', '2018-07-18 19:20:58', '199', '2018-07-18 19:20:58', 'public', '3', '教练3', null, '1', '2018-08-18 19:20:58');
INSERT INTO `js_order` VALUES ('36', '14', '2', '1', '2018-07-18 11:37:09', '11', '2018-07-18 11:37:09', 'single', null, null, null, null, null);
INSERT INTO `js_order` VALUES ('135', '14', '9', '1', '2018-07-18 19:20:58', '199', '2018-07-18 19:20:58', 'public', '3', '教练3', null, '1', '2018-08-18 19:20:58');
INSERT INTO `js_order` VALUES ('41', '14', '3', '1', '2018-07-18 16:14:55', '303', '2018-07-18 16:14:55', 'public', null, null, null, '3', '2018-10-18 16:14:55');
INSERT INTO `js_order` VALUES ('138', '14', '3', '1', '2018-07-18 19:20:58', '101', '0000-00-00 00:00:00', 'public', '3', '教练3', null, '1', '2018-08-18 19:20:58');
INSERT INTO `js_order` VALUES ('139', '14', '5', '1', '2018-07-18 19:20:58', '199', '2018-07-18 19:20:58', 'equipment', null, null, null, '1', '2018-08-18 19:20:58');
INSERT INTO `js_order` VALUES ('140', '14', '3', '1', '2018-07-18 19:20:58', '20', '2018-07-18 19:20:58', 'equipment', null, null, null, '1', '2018-08-18 19:20:58');
INSERT INTO `js_order` VALUES ('141', '14', '2', '1', '2018-07-18 19:20:58', '20', '2018-07-18 19:20:58', 'equipment', null, null, null, '1', '2018-08-18 19:20:58');
INSERT INTO `js_order` VALUES ('142', '14', '1', '1', '2018-07-18 19:20:58', '24', '2018-07-18 19:20:58', 'equipment', null, null, null, '1', '2018-08-18 19:20:58');
INSERT INTO `js_order` VALUES ('143', '14', '1', '1', '2018-07-18 20:29:15', '10', '2018-07-18 20:29:15', 'single', null, null, null, null, null);

-- ----------------------------
-- Table structure for js_single
-- ----------------------------
DROP TABLE IF EXISTS `js_single`;
CREATE TABLE `js_single` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `participate_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_single
-- ----------------------------
INSERT INTO `js_single` VALUES ('1', '团建111', '1', '&lt;p&gt;下呈现出想从&lt;/p&gt;', '2018-07-18 09:59:04', '2018-07-18 10:57:02', '10', '/upload\\20180718\\5e3420f148226856b9a59da7e4777f6a.png', '2018-08-10 10:56:59');
INSERT INTO `js_single` VALUES ('2', '团建2', '1', '&lt;p&gt;撒大声地&lt;/p&gt;', '2018-07-18 10:01:04', '2018-07-18 10:56:54', '11', '/upload\\20180718\\539798bb87ca89f565e6fe02e1a26889.png', '2018-07-20 10:56:47');
INSERT INTO `js_single` VALUES ('3', '比赛1', '1', '&lt;p&gt;相处才v&lt;/p&gt;', '2018-07-18 10:46:59', '2018-07-18 10:47:38', '20', '/upload\\20180718\\934ba425e0702cb95d1e4083d4103011.png', '2018-07-19 10:46:47');

-- ----------------------------
-- Table structure for js_special
-- ----------------------------
DROP TABLE IF EXISTS `js_special`;
CREATE TABLE `js_special` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `special` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_special
-- ----------------------------
INSERT INTO `js_special` VALUES ('1', '特长1', '1', '2018-07-17 12:01:43', '2018-07-17 12:48:54');
INSERT INTO `js_special` VALUES ('2', '特长2', '1', '2018-07-17 12:06:08', '2018-07-17 12:06:08');
INSERT INTO `js_special` VALUES ('3', '特长3', '1', '2018-07-17 12:06:13', '2018-07-17 12:06:13');

-- ----------------------------
-- Table structure for js_user
-- ----------------------------
DROP TABLE IF EXISTS `js_user`;
CREATE TABLE `js_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `code` varchar(10) NOT NULL DEFAULT '',
  `last_login_ip` varchar(20) NOT NULL DEFAULT '',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0',
  `email` varchar(30) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `listorder` int(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `image` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `jifen` int(11) DEFAULT NULL,
  `is_admin` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_user
-- ----------------------------
INSERT INTO `js_user` VALUES ('13', 'jianshen1', '31458744cca372715d967d173c9fd4df', '4298', '', '1532387854', '', '', '0', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', null, null, null, null, null, null, '1');
INSERT INTO `js_user` VALUES ('14', 'js', '0ab11c2102ddc4afeb35be7fdc31b751', '6766', '', '1535528087', '1628043770@qq.com', '', '0', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '/upload\\20180716\\f6ce5a66e53814c3db3f6419394ed0c7.jpg', '+86-532-8099 2361', 'asdsadasdad', '0', '0', '98369', '0');

-- ----------------------------
-- Table structure for js_video
-- ----------------------------
DROP TABLE IF EXISTS `js_video`;
CREATE TABLE `js_video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `video` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_video
-- ----------------------------
INSERT INTO `js_video` VALUES ('1', 'https://v.qq.com/iframe/player.html?vid=z002692hgcr&amp;tiny=0&amp;auto=0', '2018-07-10 02:27:59', '2018-07-10 02:47:42');

-- ----------------------------
-- Table structure for js_week
-- ----------------------------
DROP TABLE IF EXISTS `js_week`;
CREATE TABLE `js_week` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oneMonday` int(11) DEFAULT NULL,
  `oneTuesday` int(11) DEFAULT NULL,
  `oneWednesday` int(11) DEFAULT NULL,
  `oneThursday` int(11) DEFAULT NULL,
  `oneFriday` int(11) DEFAULT NULL,
  `oneSaturday` int(11) DEFAULT NULL,
  `oneSunday` int(11) DEFAULT NULL,
  `twoMonday` int(11) DEFAULT NULL,
  `twoTuesday` int(11) DEFAULT NULL,
  `twoWednesday` int(11) DEFAULT NULL,
  `twoThursday` int(11) DEFAULT NULL,
  `twoFriday` int(11) DEFAULT NULL,
  `twoSaturday` int(11) DEFAULT NULL,
  `twoSunday` int(11) DEFAULT NULL,
  `threeMonday` int(11) DEFAULT NULL,
  `threeTuesday` int(11) DEFAULT NULL,
  `threeWednesday` int(11) DEFAULT NULL,
  `threeThursday` int(11) DEFAULT NULL,
  `threeFriday` int(11) DEFAULT NULL,
  `threeSaturday` int(11) DEFAULT NULL,
  `threeSunday` int(11) DEFAULT NULL,
  `fourMonday` int(11) DEFAULT NULL,
  `fourTuesday` int(11) DEFAULT NULL,
  `fourWednesday` int(11) DEFAULT NULL,
  `fourThursday` int(11) DEFAULT NULL,
  `fourFriday` int(11) DEFAULT NULL,
  `fourSaturday` int(11) DEFAULT NULL,
  `fourSunday` int(11) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `fiveMonday` int(11) DEFAULT NULL,
  `fiveTuesday` int(11) DEFAULT NULL,
  `fiveWednesday` int(11) DEFAULT NULL,
  `fiveThursday` int(11) DEFAULT NULL,
  `fiveFriday` int(11) DEFAULT NULL,
  `fiveSaturday` int(11) DEFAULT NULL,
  `fiveSunday` int(11) DEFAULT NULL,
  `sixMonday` int(11) DEFAULT NULL,
  `sixTuesday` int(11) DEFAULT NULL,
  `sixWednesday` int(11) DEFAULT NULL,
  `sixThursday` int(11) DEFAULT NULL,
  `sixFriday` int(11) DEFAULT NULL,
  `sixSaturday` int(11) DEFAULT NULL,
  `sixSunday` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_week
-- ----------------------------
INSERT INTO `js_week` VALUES ('1', '6', '3', '6', '6', '0', '0', '0', '6', '0', '0', '8', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '3', '11', '0', '0', '6', '0', '0', '2018-07-19 09:11:32', '1', '2018-07-17 09:29:07', '8', '0', '0', '0', '6', '0', '0', '0', '0', '0', '0', '0', '0', '0');
