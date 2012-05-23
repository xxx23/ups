--
-- 儲存使用者申請的APIKEY
--
CREATE TABLE `ups_ws_key` (
      `user_id` int(11) NOT NULL,
      `api_key` varchar(256) NOT NULL,
      `ip_restrict` text NOT NULL,
      `usage` text NOT NULL,
      `create_time` int(11) NOT NULL,
      `status` tinyint(1) NOT NULL default 0,
      KEY `user_id` (`user_id`,`api_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 儲存使用記錄
--
CREATE TABLE `ups_ws_log` (
      `id` int(11) NOT NULL auto_increment,
      `api_key` varchar(256) NOT NULL,
      `service_id` int(11) NOT NULL,
      `level` varchar(10) NOT NULL,
      `message` varchar(256) NOT NULL,
      `timestamp` int(11) NOT NULL,
      PRIMARY KEY  (`id`),
      KEY `api_key` (`api_key`,`service_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 儲存 可以使用webService的身分別
--
CREATE TABLE `ups_ws_permission` (
      `service_id` int(11) NOT NULL,
      `role_cd` char(1) NOT NULL,
      KEY `service_id` (`service_id`,`role_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 儲存系統中的webService
--
CREATE TABLE `ups_ws_services` (
      `id` int(11) NOT NULL auto_increment,
      `name` varchar(64) NOT NULL,
      `class` varchar(64) NOT NULL,
      `description` text NOT NULL,
      `status` tinyint(1) NOT NULL default '0',
      PRIMARY KEY  (`id`),
      KEY `class` (`class`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- applycourse的使用者欄位新增 縣市與學校用以查詢資料
--
ALTER TABLE  `register_applycourse` ADD  `city_cd` INT NOT NULL AFTER  `category` ,
ADD  `school_cd` INT NOT NULL AFTER  `city_cd` ,
ADD INDEX (  `city_cd` ,  `school_cd` );
