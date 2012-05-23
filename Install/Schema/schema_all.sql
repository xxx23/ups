-- MySQL dump 10.11
--
-- Host: localhost    Database: elearning
-- ------------------------------------------------------
-- Server version	5.0.51a-3ubuntu5.7-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `begin_course`
--

DROP TABLE IF EXISTS `begin_course`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `begin_course` (
  `begin_course_cd` int(7) NOT NULL auto_increment COMMENT '開課編號',
  `course_cd` int(7) default NULL COMMENT '課程科目編號',
  `inner_course_cd` char(20) NOT NULL COMMENT '開課編號',
  `begin_unit_cd` char(10) default NULL COMMENT '開課系所(學校)',
  `begin_course_name` varchar(60) default NULL COMMENT '開課名稱',
  `d_course_begin` datetime default NULL COMMENT '開課開始日期',
  `d_course_end` datetime default NULL COMMENT '開課結束日期',
  `d_public_day` datetime default NULL COMMENT '開課公開日期',
  `d_select_begin` datetime default NULL COMMENT '選課開始日期',
  `d_select_end` datetime default NULL COMMENT '選課結束日期',
  `course_year` char(3) default NULL COMMENT '開課所屬的學年',
  `course_session` char(1) default NULL COMMENT '開課所屬的學期',
  `certify_type` char(1) default NULL COMMENT '認證表示',
  `quantity` int(11) default NULL COMMENT '招收名額',
  `locally` char(1) default NULL COMMENT '限定機關報名上課',
  `certify` float NOT NULL default '0' COMMENT '認證時數',
  `charge` int(11) NOT NULL default '0' COMMENT '學習費用',
  `class_city` char(5) default NULL COMMENT '上課縣市',
  `class_place` varchar(100) default NULL COMMENT '上課地點',
  `class_time` varchar(32) default NULL COMMENT '上課時間',
  `is_room` char(1) default NULL COMMENT '住宿否',
  `is_feed` char(1) default NULL COMMENT '飲食',
  `term` char(1) default NULL COMMENT '期別 or 班別',
  `if_course` char(1) default NULL COMMENT '修業判別',
  `change_time` date default NULL COMMENT '最近更改時間',
  `allowno` varchar(32) default NULL COMMENT '依據文號',
  `subsidizeid` char(4) default NULL COMMENT '補助單位',
  `subsidize_money` float default NULL COMMENT '補助費用',
  `coursekind` char(4) default NULL COMMENT '班別性質',
  `member` char(4) default NULL COMMENT '研習對象階段別',
  `charge_type` char(4) default NULL COMMENT '繳費方式',
  `type_cd` int(2) default NULL,
  `lrt_type_cd` int(2) default NULL,
  `lrt2_type_cd` int(2) default NULL,
  `lrt3_type_cd` int(2) default NULL,
  `memberkind` char(4) default NULL COMMENT '研習對象身分別',
  `begin_coursestate` char(1) default NULL COMMENT '開課狀態 1:課程為開啟 guest可以看到 0: 課程未開啟 p:審核中 n:審核未通過，需重新申請 ，若審核通過，則開啟此欄位設為1',
  `course_type` char(1) NOT NULL default '0' COMMENT '開課類別',
  `timeSet` varchar(60) default NULL COMMENT '課程時段',
  `is_preview` int(1) NOT NULL COMMENT '教材是否試閱',
  `director_name` char(20) default NULL COMMENT '承辦人',
  `director_tel` varchar(32) default NULL COMMENT '承辦人電話',
  `director_fax` varchar(32) default NULL COMMENT '承辦人傳真',
  `director_email` varchar(40) default NULL COMMENT '承辦人電子信箱',
  `criteria_total` int(11) default NULL COMMENT '評量標準(總分)',
  `criteria_score` int(11) default NULL COMMENT '評量標準(線上成績)',
  `criteria_score_pstg` float default NULL COMMENT '評量標準(線上成績比例)',
  `criteria_tea_score` int(11) default NULL COMMENT '評量標準(老師成績)',
  `criteria_tea_score_pstg` float default NULL COMMENT '評量標準(老師成績比例)',
  `criteria_content_hour` time default NULL COMMENT '評量標準(看教材時間)',
  `criteria_finish_survey` int(1) default NULL COMMENT '評量標準(完成問卷)',
  `take_hour` float NOT NULL default '0' COMMENT '課程時數',
  `attribute` int(1) NOT NULL default '0' COMMENT '課程屬性(自學:0or教導:1)',
  `charge_discount` int(11) NOT NULL default '0' COMMENT '優惠價',
  `auto_admission` int(1) NOT NULL default '0' COMMENT '選課是自動審核',
  `note` text COMMENT '備註',
  `course_classify_cd` int(5) default NULL COMMENT '課程科目類別編號',
  `course_classify_parent` char(5) default NULL COMMENT '所屬上級類別編號',
  `course_property` int(11) default NULL COMMENT '用來設定課程性質，如電腦類、音樂類的課程',
  `course_duration` int(11) default NULL COMMENT '自學式課程的修課期限，值為1~12月',
  `course_stage` varchar(11) default NULL COMMENT '課程研習對象階段(包含國中30、國小40、高中10、高職23等)',
  `career_stage` text COMMENT '課程研習對象身分(包含校長、主任、一般教師)',
  `deliver` int(11) default NULL COMMENT '本課程是否傳送高師大申請研習時數',
  `article_number` text COMMENT '課程開課依據文號',
  `guest_allowed` int(2) NOT NULL COMMENT '用來判斷訪客權限使用者是否可以顴看這門課程的資料',
  `state_note` text COMMENT '用以填寫begin_coursestate = n 不通過的理由、原因',
  `applycourse_no` int(11) default '0' COMMENT '是由哪一個開課帳號所開課，系統管理員預設為0，其餘值則對應到register_applycourse.no ',
  `applycourse_doc` int(11) NOT NULL COMMENT '用來紀錄開課單位屬於哪個doc，只有為applycourse_no為輔導團的no時才需要參考這個',
  PRIMARY KEY  (`begin_course_cd`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `calendar` (
  `calendar_cd` int(10) NOT NULL auto_increment,
  `personal_id` int(10) NOT NULL,
  `year` varchar(6) default NULL,
  `month` varchar(4) default NULL,
  `day` varchar(4) default NULL,
  `content` text,
  `notify` date default NULL,
  `notify_num` int(2) default NULL,
  `mtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`calendar_cd`),
  KEY `personal_id` (`personal_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `class_content`
--

DROP TABLE IF EXISTS `class_content`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `class_content` (
  `content_cd` int(7) NOT NULL,
  `menu_id` varchar(12) NOT NULL,
  `menu_parentid` varchar(12) NOT NULL,
  `caption` varchar(128) NOT NULL COMMENT '節點描述文字',
  `file_name` varchar(128) NOT NULL COMMENT '檔案名稱(目前跟caption一樣，未來可能會改的預留欄位)',
  `url` varchar(128) NOT NULL,
  `exp` varchar(10) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `seq` int(3) NOT NULL,
  PRIMARY KEY  (`content_cd`,`menu_id`),
  UNIQUE KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `class_content_current`
--

DROP TABLE IF EXISTS `class_content_current`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `class_content_current` (
  `begin_course_cd` int(7) NOT NULL,
  `content_cd` int(7) NOT NULL,
  PRIMARY KEY  (`begin_course_cd`),
  UNIQUE KEY `begin_course_cd` (`begin_course_cd`,`content_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='紀錄教材內有哪些題庫';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `class_content_error`
--

DROP TABLE IF EXISTS `class_content_error`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `class_content_error` (
  `content_cd` int(7) NOT NULL COMMENT '教材編號',
  `menu_id` varchar(12) NOT NULL COMMENT '教材節點編號',
  `personal_id` int(10) NOT NULL default '0' COMMENT '回報者id',
  `page` int(7) NOT NULL default '0' COMMENT '頁數',
  `content` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '勘誤內容',
  KEY `content_cd` (`content_cd`),
  KEY `menu_id` (`menu_id`),
  KEY `personal_id` (`personal_id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `content_download`
--

DROP TABLE IF EXISTS `content_download`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `content_download` (
  `content_cd` int(7) NOT NULL auto_increment,
  `is_download` char(1) NOT NULL,
  `download_role` char(10) default NULL COMMENT '0不提供下載,1所有身份,2平台教師,3研習學員(大專院),4研習學員 (國中小),5修課學生,6其他',
  `packet_type` char(10) default NULL COMMENT '0,1,2平台;3,4是zip',
  `license` char(1) default NULL,
  `announce` text,
  `rule` text,
  `memo` text,
  PRIMARY KEY  (`content_cd`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `content_test_bank`
--

DROP TABLE IF EXISTS `content_test_bank`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `content_test_bank` (
  `content_cd` int(11) NOT NULL COMMENT '課程教材id(科目教材編號)',
  `test_bank_id` int(11) NOT NULL auto_increment COMMENT '課程教材所屬題庫的id',
  `test_bank_name` varchar(60) collate utf8_unicode_ci NOT NULL COMMENT '題庫的名字',
  PRIMARY KEY  (`content_cd`,`test_bank_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='教材對應的題庫(一個教材有多個題庫,一個題庫內有多個題目)';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `course_basic`
--

DROP TABLE IF EXISTS `course_basic`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course_basic` (
  `course_id` char(20) NOT NULL COMMENT '課程科目編號',
  `course_cd` int(7) NOT NULL auto_increment COMMENT '課程科目編號',
  `teacher_cd` int(7) NOT NULL COMMENT '教師',
  `course_name` varchar(60) default NULL COMMENT '課程科目名稱',
  `need_validate_select` char(1) default NULL COMMENT '是否開放旁聽',
  `is_public` char(1) default NULL COMMENT '教材作業是否公開',
  `schedule_unit` char(4) default NULL COMMENT '課程科目時程單位',
  `introduction` text COMMENT '課程科目簡介',
  `goal` text COMMENT '教學目標',
  `future` text COMMENT '課程科目宗旨',
  `course_process` text COMMENT '課程進行方式',
  `person_mention` text COMMENT '個人簡介',
  `environment` text COMMENT '系統環境(軟硬體介紹)',
  `reguisition` text COMMENT '教學要求',
  `audience` text COMMENT '適合學習對象(資格條件)',
  `learning_test` text COMMENT '學習評量方式',
  `prepare_course` text COMMENT '先修課程',
  `mster_book` text COMMENT '教科書書目',
  `ref_book` text COMMENT '參考書目',
  `ref_url` text COMMENT '參考網址',
  `directory` varchar(20) default NULL COMMENT '課程科目首頁目錄',
  `index_file` varchar(60) default NULL COMMENT '課程科目首頁檔名',
  `content_maker` char(1) default NULL COMMENT '課程科目內容製作權限',
  `content_format` int(1) NOT NULL default '0' COMMENT '教材格式(scorm?)',
  `note` text COMMENT '備註',
  `outline` text COMMENT '這是提供給自學式使用的課程大綱。',
  PRIMARY KEY  (`course_cd`,`course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `course_concent_grade`
--

DROP TABLE IF EXISTS `course_concent_grade`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course_concent_grade` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `number_id` int(2) NOT NULL default '0' COMMENT '序號',
  `percentage_type` char(1) default NULL COMMENT '百分比種類 		1. 測驗, 2.作業 ',
  `percentage_num` int(7) default NULL COMMENT '百分比編號，隨種類不同而不同		homework_no or test_no',
  `student_id` int(10) NOT NULL COMMENT '學員編號',
  `concent_grade` float default '0' COMMENT '課程相關作業分數		欄位名稱很怪',
  PRIMARY KEY  (`begin_course_cd`,`number_id`,`student_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `course_content`
--

DROP TABLE IF EXISTS `course_content`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course_content` (
  `content_cd` int(7) NOT NULL auto_increment,
  `content_name` varchar(100) NOT NULL,
  `teacher_cd` int(10) NOT NULL,
  `datetime` datetime NOT NULL,
  `difficulty` char(1) default NULL,
  `content_type` char(1) default NULL,
  `is_public` char(1) default NULL,
  PRIMARY KEY  (`content_cd`,`teacher_cd`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `course_content_bank`
--

DROP TABLE IF EXISTS `course_content_bank`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course_content_bank` (
  `content_cd` int(7) NOT NULL,
  `content_id` int(3) NOT NULL auto_increment,
  `content_name` varchar(100) default NULL,
  `content_path` varchar(128) default NULL,
  `content_datatype` char(1) NOT NULL,
  PRIMARY KEY  (`content_cd`,`content_id`),
  UNIQUE KEY `content_id` (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `course_epaper`
--

DROP TABLE IF EXISTS `course_epaper`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course_epaper` (
  `epaper_cd` int(7) NOT NULL COMMENT '電子報編號',
  `epaper_id` int(3) NOT NULL COMMENT '電子報序號',
  `title` text COMMENT '標題',
  `content` text COMMENT '內容',
  `epaper_file_url` varchar(128) NOT NULL COMMENT '電子報檔案連結		',
  PRIMARY KEY  (`epaper_cd`,`epaper_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `course_grade`
--

DROP TABLE IF EXISTS `course_grade`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course_grade` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `type` int(3) NOT NULL default '0' COMMENT '分數型別代號',
  `percentage` int(11) default NULL COMMENT '分數',
  PRIMARY KEY  (`begin_course_cd`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `course_grade_report`
--

DROP TABLE IF EXISTS `course_grade_report`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course_grade_report` (
  `begin_course_cd` int(7) NOT NULL,
  `number_id` int(2) NOT NULL,
  `percentage_type` char(2) default NULL,
  `precentage_num` int(7) default NULL,
  `print` char(1) default NULL,
  PRIMARY KEY  (`begin_course_cd`,`number_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `course_percentage`
--

DROP TABLE IF EXISTS `course_percentage`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course_percentage` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `number_id` int(2) NOT NULL auto_increment COMMENT '序號	auto_increment',
  `percentage_type` char(1) default NULL COMMENT '百分比種類 		1. 測驗, 2.作業 ',
  `percentage_num` int(7) default NULL COMMENT '百分比編號，隨種類不同而不同		homework_no or test_no',
  `percentage` int(7) default NULL COMMENT '佔學期總分數百分比',
  PRIMARY KEY  (`begin_course_cd`,`number_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `course_property`
--

DROP TABLE IF EXISTS `course_property`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course_property` (
  `property_cd` int(11) NOT NULL default '0' COMMENT '用來記錄課程性質的數字',
  `property_name` varchar(32) default NULL COMMENT '用來記錄課程性質的名稱',
  PRIMARY KEY  (`property_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `course_schedule`
--

DROP TABLE IF EXISTS `course_schedule`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course_schedule` (
  `begin_course_cd` int(7) NOT NULL,
  `course_schedule_day` varchar(11) default NULL,
  `schedule_index` tinyint(4) NOT NULL default '0',
  `subject` varchar(100) default NULL,
  `course_type` varchar(32) default NULL,
  `teacher_cd` int(10) NOT NULL,
  `course_activity` text,
  PRIMARY KEY  (`begin_course_cd`,`schedule_index`,`teacher_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `credential_content`
--

DROP TABLE IF EXISTS `credential_content`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `credential_content` (
  `credential_type_cd` int(7) NOT NULL,
  `begin_course_no` int(7) NOT NULL,
  `credential_id` bigint(3) NOT NULL,
  `content` text NOT NULL,
  `seq_no` int(2) NOT NULL,
  PRIMARY KEY  (`credential_type_cd`,`begin_course_no`,`credential_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `credential_type`
--

DROP TABLE IF EXISTS `credential_type`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `credential_type` (
  `credential_type_cd` int(7) NOT NULL,
  `begin_course_no` int(7) NOT NULL,
  `d_create_day` date NOT NULL,
  `title` text,
  `sash_template_no` varchar(255) default NULL,
  `emboss_no2` varchar(255) default NULL,
  PRIMARY KEY  (`credential_type_cd`,`begin_course_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `discuss_content`
--

DROP TABLE IF EXISTS `discuss_content`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `discuss_content` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `discuss_cd` int(7) NOT NULL COMMENT '討論區主題編號',
  `discuss_content_cd` int(7) NOT NULL COMMENT '討論區文章編號',
  `reply_content_cd` int(7) NOT NULL COMMENT '回覆文章編號',
  `reply_conten_parentcd` int(7) NOT NULL COMMENT '上一層回覆文章編號',
  `d_reply` datetime NOT NULL COMMENT '文章回覆時間',
  `discuss_title` varchar(160) default NULL COMMENT '討論文章的主題',
  `reply_person` int(10) default NULL COMMENT '文章回覆者',
  `content_body` text COMMENT '文章內容',
  `viewed` int(7) default NULL COMMENT '被瀏覽次數',
  `file_picture_name` varchar(64) default NULL COMMENT '題目所用到圖片的檔案',
  `file_av_name` varchar(64) default NULL COMMENT '題目所用到影音的檔案',
  PRIMARY KEY  (`begin_course_cd`,`discuss_cd`,`discuss_content_cd`,`reply_content_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='開課編號';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `discuss_content_viewed`
--

DROP TABLE IF EXISTS `discuss_content_viewed`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `discuss_content_viewed` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `discuss_cd` int(7) NOT NULL COMMENT '討論區主題編號',
  `discuss_content_cd` int(7) NOT NULL COMMENT '討論區文章編號',
  `reply_content_cd` int(7) NOT NULL COMMENT '回覆文章編號',
  `reply_conten_parentcd` int(7) NOT NULL COMMENT '上一層回覆文章編號',
  `personal_id` int(10) NOT NULL,
  PRIMARY KEY  (`begin_course_cd`,`discuss_cd`,`discuss_content_cd`,`reply_content_cd`,`personal_id`),
  KEY `begin_course_cd` (`begin_course_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='開課編號';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `discuss_groups`
--

DROP TABLE IF EXISTS `discuss_groups`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `discuss_groups` (
  `begin_course_cd` int(7) NOT NULL,
  `discuss_cd` int(7) NOT NULL,
  `group_no` int(5) NOT NULL,
  `homework_group_no` int(5) default NULL,
  `homework_no` int(7) default NULL,
  `is_public` char(1) default NULL,
  `comment` varchar(100) default NULL,
  `mtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`begin_course_cd`,`discuss_cd`,`group_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `discuss_hoarding`
--

DROP TABLE IF EXISTS `discuss_hoarding`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `discuss_hoarding` (
  `begin_course_cd` int(7) NOT NULL,
  `discuss_cd` int(7) NOT NULL,
  `discuss_content_cd` int(7) NOT NULL,
  `reply_content_cd` int(7) NOT NULL,
  `personal_id` int(10) NOT NULL,
  `hoarding_type` char(1) default NULL,
  PRIMARY KEY  (`begin_course_cd`,`discuss_cd`,`discuss_content_cd`,`reply_content_cd`,`personal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `discuss_info`
--

DROP TABLE IF EXISTS `discuss_info`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `discuss_info` (
  `begin_course_cd` int(7) NOT NULL COMMENT '課程編號(開課編號)',
  `discuss_cd` int(7) NOT NULL COMMENT '討論區編號',
  `discuss_name` varchar(64) default NULL COMMENT '討論區名稱',
  `discuss_title` varchar(128) default NULL COMMENT '討論區主題',
  PRIMARY KEY  (`begin_course_cd`,`discuss_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='討論區資料';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `discuss_menber_groups`
--

DROP TABLE IF EXISTS `discuss_menber_groups`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `discuss_menber_groups` (
  `begin_course_cd` int(7) NOT NULL,
  `discuss_cd` int(7) NOT NULL,
  `group_no` int(5) NOT NULL,
  `student_id` int(10) NOT NULL,
  `homework_group_no` int(5) default NULL,
  `homework_no` int(7) default NULL,
  PRIMARY KEY  (`begin_course_cd`,`discuss_cd`,`group_no`,`student_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `discuss_subject`
--

DROP TABLE IF EXISTS `discuss_subject`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `discuss_subject` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號 begin_course.begin_course_cd',
  `discuss_cd` int(7) NOT NULL COMMENT '討論區編號 = discuss_info.discuss_cd ',
  `discuss_content_cd` int(7) NOT NULL COMMENT '討論區內的文章編號',
  `discuss_title` varchar(64) default NULL COMMENT '文章的主題',
  `discuss_author` int(10) default NULL COMMENT '作者 id , personal_basic.personal_id',
  `viewed` int(7) NOT NULL COMMENT '文章瀏覽次數 (program 更新) ',
  `reply_count` int(3) default NULL COMMENT '文章回覆次數',
  `d_created` datetime default NULL COMMENT '文章發表時間',
  `d_replied` datetime default NULL COMMENT '文章最後被回覆時間',
  PRIMARY KEY  (`begin_course_cd`,`discuss_cd`,`discuss_content_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='討論區文章資料';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `discuss_subscribe`
--

DROP TABLE IF EXISTS `discuss_subscribe`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `discuss_subscribe` (
  `begin_course_cd` int(7) NOT NULL,
  `discuss_cd` int(7) NOT NULL,
  `personal_id` int(10) NOT NULL,
  PRIMARY KEY  (`begin_course_cd`,`discuss_cd`,`personal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `docs`
--

DROP TABLE IF EXISTS `docs`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `docs` (
  `doc_cd` int(11) NOT NULL auto_increment,
  `city_cd` int(11) NOT NULL,
  `town` varchar(15) NOT NULL,
  `doc` varchar(20) NOT NULL,
  PRIMARY KEY  (`doc_cd`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `download_reason`
--

DROP TABLE IF EXISTS `download_reason`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `download_reason` (
  `content_cd` int(7) NOT NULL,
  `personal_id` int(10) NOT NULL,
  `organization` varchar(200) NOT NULL,
  `download_reason` text NOT NULL,
  `time` datetime NOT NULL COMMENT '填寫時間',
  PRIMARY KEY  (`content_cd`,`personal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `e_paper`
--

DROP TABLE IF EXISTS `e_paper`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `e_paper` (
  `epaper_cd` int(7) NOT NULL COMMENT '電子報編號		為何不auto_increment',
  `periodical_cd` int(7) default NULL COMMENT '期刊編號		期刊編號須跟據開課編號的不同重新編號',
  `begin_course_no` int(7) default NULL COMMENT '開課編號		下一個發送日期等於上一個電子報過期',
  `d_public_day` datetime default NULL COMMENT '發送日期',
  `if_auto` char(1) NOT NULL COMMENT '是否自動發送電子報		Y or N , 如果是 Y 就配合發送日期',
  `topic` varchar(64) NOT NULL COMMENT '本期主題',
  `releated_link` text NOT NULL COMMENT '相關連結		儲存方式:連結1;連結2;連結三;…',
  `d_create_day` datetime NOT NULL COMMENT '創建日期		RSS須需要有日期的資訊，所以加這個欄位',
  `epaper_file_url` varchar(128) NOT NULL COMMENT '電子報檔案連結',
  PRIMARY KEY  (`epaper_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `error_content_report`
--

DROP TABLE IF EXISTS `error_content_report`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `error_content_report` (
  `id` int(10) NOT NULL auto_increment,
  `content_cd` int(7) NOT NULL COMMENT '教材編號',
  `menu_id` varchar(12) NOT NULL COMMENT '節點編號',
  `personal_id` int(10) NOT NULL COMMENT '回報者',
  `page` int(7) default NULL COMMENT '頁數',
  `content` varchar(255) character set utf8 collate utf8_unicode_ci default NULL COMMENT '勘誤內容',
  `reportdate` datetime NOT NULL COMMENT '回報日期',
  `confirmdate` datetime default NULL COMMENT '確認日期',
  `enable` tinyint(1) NOT NULL default '0' COMMENT '0未確認，1確認，2拒絕',
  PRIMARY KEY  (`id`),
  KEY `content_cd` (`content_cd`,`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `event` (
  `personal_id` int(10) NOT NULL,
  `begin_course_cd` int(7) NOT NULL,
  `system_id` int(3) NOT NULL,
  `function_id` int(3) NOT NULL,
  `function_occur_time` datetime NOT NULL,
  KEY `personal_id` (`personal_id`),
  KEY `begin_course_cd` (`begin_course_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `event_statistics`
--

DROP TABLE IF EXISTS `event_statistics`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `event_statistics` (
  `personal_id` int(10) NOT NULL,
  `begin_course_cd` int(7) NOT NULL,
  `system_id` int(3) NOT NULL,
  `function_id` int(3) NOT NULL,
  `function_hold_time` datetime default NULL,
  `function_occur_average_cycle` datetime default NULL,
  `function_occur_number` int(5) default NULL,
  PRIMARY KEY  (`personal_id`,`begin_course_cd`,`system_id`,`function_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `generate_inner_course_cd`
--

DROP TABLE IF EXISTS `generate_inner_course_cd`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `generate_inner_course_cd` (
  `course_type` int(11) default NULL COMMENT '最外層的course_type(目前教育部平台先使用01)',
  `property_type` int(11) default NULL COMMENT '性質分類屬性 為01~06一共六種(01資訊技能 02電腦入門 03資訊融入教學 04資訊倫理 05資訊安全 06其它)',
  `course_number` int(11) default NULL COMMENT '該屬性下的課程編號 由01開始'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='此資料庫用來產生課程編號';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `goodfriend`
--

DROP TABLE IF EXISTS `goodfriend`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `goodfriend` (
  `goodfriend_cd` int(7) NOT NULL,
  `personal_id` int(10) NOT NULL,
  `friend_id` int(10) NOT NULL,
  `inform` char(1) default NULL,
  `friend_count` int(2) default NULL,
  PRIMARY KEY  (`goodfriend_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `grade_convert`
--

DROP TABLE IF EXISTS `grade_convert`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `grade_convert` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `grade_type_cd` char(2) NOT NULL COMMENT '分數型別代號',
  `number_id` int(2) NOT NULL COMMENT '序號		每個grade_Type_cd 都必須有自己的轉換後的分數',
  `convert_grade_cd` char(1) default NULL COMMENT '轉換代碼		如：1學分、2等級、3.時 4. 過 or 不過 ',
  `grade` float default NULL COMMENT '分數		如: 2. 等級  90-->A , 80-->B , 70 -->丙 , or 4. 60 -> 通過(pass) or  3. 60 --> 3 (小時)',
  `grade_convert` char(10) default NULL COMMENT '轉換後的分數',
  PRIMARY KEY  (`begin_course_cd`,`grade_type_cd`,`number_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `group_discuss_join`
--

DROP TABLE IF EXISTS `group_discuss_join`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `group_discuss_join` (
  `begin_course_cd` int(7) NOT NULL,
  `teacher_cd` int(10) NOT NULL,
  `join_reason` varchar(255) default NULL COMMENT '加入的理由',
  `not_pass_reason` varchar(255) default NULL COMMENT '被拒絕的原因',
  PRIMARY KEY  (`begin_course_cd`,`teacher_cd`),
  KEY `begin_course_cd` (`begin_course_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `groups_member`
--

DROP TABLE IF EXISTS `groups_member`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `groups_member` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `homework_no` int(7) NOT NULL COMMENT '作業編號',
  `group_no` int(5) NOT NULL COMMENT '分組編號',
  `student_id` int(10) NOT NULL COMMENT '學員編號		是討論區或作業由info_groups記錄',
  `assign_work` text NOT NULL COMMENT '分工狀況',
  PRIMARY KEY  (`begin_course_cd`,`homework_no`,`group_no`,`student_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='åˆ†çµ„çµ„å“¡åå–®';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `handin_homework`
--

DROP TABLE IF EXISTS `handin_homework`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `handin_homework` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `homework_no` int(7) NOT NULL COMMENT '作業編號',
  `personal_id` int(10) NOT NULL COMMENT '學員編號or project 編號',
  `work` text COMMENT '繳交的作業',
  `type` varchar(5) default NULL COMMENT '繳交作業的副檔名',
  `comment` text COMMENT '作業評語',
  `grade` float default NULL COMMENT '作業分數		直接更新`course_concent_grade`裡的concent_grade，以後不需要',
  `public` char(1) default '0' COMMENT '該學生的作業是否要公開		(0:False, 1:True, 預設值:0 )',
  `grade_public` char(1) NOT NULL default '1' COMMENT '作業成績是否公佈		(0:False, 1:True, 預設值:0)',
  `handin_time` datetime default NULL COMMENT '繳交時間	program_input',
  PRIMARY KEY  (`begin_course_cd`,`homework_no`,`personal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `homework`
--

DROP TABLE IF EXISTS `homework`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `homework` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `homework_no` int(5) NOT NULL auto_increment COMMENT '作業編號	auto_increment',
  `homework_name` varchar(80) default NULL COMMENT '作業名稱',
  `public` tinyint(1) default '0' COMMENT '"作業指派(即公開給學員看到)"(0:答案不公開，作業不公開)(1:答案不公開，作業公開)(2:答案公開，作業不公開)(3:答案公開，作業公開)',
  `question` text COMMENT '作業題目		多個 project  題目可由此輸入',
  `q_type` varchar(5) default NULL COMMENT '作業題目的類型		若作業題目為上傳，則紀錄副檔名',
  `answer` text COMMENT '作業答案',
  `ans_type` varchar(5) default NULL COMMENT '作業答案的類型',
  `percentage` int(7) default NULL COMMENT '佔學期總分數百分比',
  `late` char(1) default NULL COMMENT '作業是否可以遲交		(0:Fault, 1:True ,預設值:1)',
  `remind` int(3) NOT NULL default '0',
  `d_dueday` datetime default NULL COMMENT '作業繳交期限',
  `ans_day` datetime default NULL COMMENT '解答公佈日期',
  `is_co_learn` int(1) NOT NULL COMMENT '作業類型		(0:fault/1:ture)',
  PRIMARY KEY  (`homework_no`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `info_groups`
--

DROP TABLE IF EXISTS `info_groups`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `info_groups` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `homework_no` int(7) NOT NULL COMMENT '作業編號',
  `group_no` int(5) NOT NULL COMMENT '分組編號		當作業編號不同時,分組編號就會重新編號',
  `group_name` char(40) default NULL COMMENT '組別名稱',
  `project_no` int(7) NOT NULL COMMENT '合作學習編號',
  `if_grouptype` char(1) NOT NULL COMMENT '作業or討論區',
  `result_work` text NOT NULL COMMENT '成果發表',
  `upload` char(1) NOT NULL COMMENT '成果發表是否上傳		(1:true/0:false/預設值:0)',
  `if_true` char(1) NOT NULL COMMENT '是否同意		(1:true/0:false/預設值:0)',
  PRIMARY KEY  (`begin_course_cd`,`group_no`,`homework_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lchat_bandwidth`
--

DROP TABLE IF EXISTS `lchat_bandwidth`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lchat_bandwidth` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(255) NOT NULL default '',
  `used` bigint(20) NOT NULL default '0',
  `max` bigint(20) NOT NULL default '0',
  `current` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lchat_banned`
--

DROP TABLE IF EXISTS `lchat_banned`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lchat_banned` (
  `id` int(11) NOT NULL auto_increment,
  `room` varchar(255) NOT NULL default '',
  `user_ip_email` varchar(255) NOT NULL default '',
  `starttime` int(11) NOT NULL default '0',
  `endtime` int(11) NOT NULL default '0',
  `reason` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lchat_events`
--

DROP TABLE IF EXISTS `lchat_events`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lchat_events` (
  `id` int(11) NOT NULL auto_increment,
  `timestamp` int(11) NOT NULL default '0',
  `event` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lchat_filter`
--

DROP TABLE IF EXISTS `lchat_filter`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lchat_filter` (
  `id` int(11) NOT NULL auto_increment,
  `room` varchar(255) NOT NULL default '',
  `type` int(11) NOT NULL default '0',
  `text` varchar(255) NOT NULL default '',
  `replacement` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lchat_messages`
--

DROP TABLE IF EXISTS `lchat_messages`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lchat_messages` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(255) NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `body` text NOT NULL,
  `body_parsed` text NOT NULL,
  `room` varchar(255) NOT NULL default '',
  `time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lchat_muted`
--

DROP TABLE IF EXISTS `lchat_muted`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lchat_muted` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(255) NOT NULL default '',
  `ignored_user` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lchat_online`
--

DROP TABLE IF EXISTS `lchat_online`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lchat_online` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `ip` varchar(255) NOT NULL default '',
  `room` varchar(255) NOT NULL default '',
  `usersonline` tinytext NOT NULL,
  `time` int(11) NOT NULL default '0',
  `invisible` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lchat_permissions`
--

DROP TABLE IF EXISTS `lchat_permissions`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lchat_permissions` (
  `id` int(11) NOT NULL auto_increment,
  `usergroup` varchar(255) NOT NULL default '',
  `make_rooms` int(11) NOT NULL default '0',
  `make_proom` int(11) NOT NULL default '0',
  `make_nexp` int(11) NOT NULL default '0',
  `make_mod` int(11) NOT NULL default '0',
  `viewip` int(11) NOT NULL default '0',
  `kick` int(11) NOT NULL default '0',
  `ban_kick_imm` int(11) NOT NULL default '0',
  `AOP_all` int(11) NOT NULL default '0',
  `AV_all` int(11) NOT NULL default '0',
  `view_hidden_emails` int(11) NOT NULL default '0',
  `use_keywords` int(11) NOT NULL default '0',
  `access_room_logs` int(11) NOT NULL default '0',
  `log_pms` int(11) NOT NULL default '0',
  `set_background` int(11) NOT NULL default '0',
  `set_logo` int(11) NOT NULL default '0',
  `make_admins` int(11) NOT NULL default '0',
  `server_msg` int(11) NOT NULL default '0',
  `can_mdeop` int(11) NOT NULL default '0',
  `can_mkick` int(11) NOT NULL default '0',
  `admin_settings` int(11) NOT NULL default '0',
  `admin_themes` int(11) NOT NULL default '0',
  `admin_filter` int(11) NOT NULL default '0',
  `admin_groups` int(11) NOT NULL default '0',
  `admin_users` int(11) NOT NULL default '0',
  `admin_ban` int(11) NOT NULL default '0',
  `admin_bandwidth` int(11) NOT NULL default '0',
  `admin_logs` int(11) NOT NULL default '0',
  `admin_events` int(11) NOT NULL default '0',
  `admin_mail` int(11) NOT NULL default '0',
  `admin_mods` int(11) NOT NULL default '0',
  `admin_smilies` int(11) NOT NULL default '0',
  `admin_rooms` int(11) NOT NULL default '0',
  `access_disabled` int(11) NOT NULL default '0',
  `b_invisible` int(11) NOT NULL default '0',
  `c_invisible` int(11) NOT NULL default '0',
  `admin_keywords` int(11) NOT NULL default '0',
  `access_pw_rooms` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lchat_rooms`
--

DROP TABLE IF EXISTS `lchat_rooms`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lchat_rooms` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `type` int(11) NOT NULL default '0',
  `moderated` int(11) NOT NULL default '0',
  `topic` varchar(255) NOT NULL default '',
  `greeting` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `maxusers` int(11) NOT NULL default '0',
  `time` int(11) NOT NULL default '0',
  `ops` text NOT NULL,
  `voiced` text NOT NULL,
  `logged` int(11) NOT NULL default '0',
  `background` varchar(255) NOT NULL default '',
  `logo` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lchat_settings`
--

DROP TABLE IF EXISTS `lchat_settings`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lchat_settings` (
  `id` int(11) NOT NULL auto_increment,
  `variable` varchar(255) NOT NULL default '',
  `setting` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lchat_users`
--

DROP TABLE IF EXISTS `lchat_users`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lchat_users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `avatar` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `location` varchar(255) NOT NULL default '',
  `hobbies` varchar(255) NOT NULL default '',
  `bio` text NOT NULL,
  `status` varchar(255) NOT NULL default '',
  `user_group` text NOT NULL,
  `time` int(11) NOT NULL default '0',
  `settings` varchar(255) NOT NULL default '',
  `hideemail` int(11) NOT NULL default '0',
  `gender` int(11) NOT NULL default '0',
  `ip` varchar(255) NOT NULL default '',
  `activated` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `location` (
  `school_cd` int(11) NOT NULL auto_increment,
  `city_cd` int(11) NOT NULL,
  `city` varchar(10) NOT NULL,
  `school` varchar(32) NOT NULL,
  `moe_cd` varchar(11) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY  (`school_cd`),
  KEY `city_cd` (`city_cd`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `login_log`
--

DROP TABLE IF EXISTS `login_log`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `login_log` (
  `pid` int(11) NOT NULL COMMENT '登入id',
  `login_time` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT '登入時間',
  ` ip` varchar(40) NOT NULL COMMENT '登入ip位置'
) ENGINE=ARCHIVE DEFAULT CHARSET=utf8 COMMENT='紀錄每一個登入的log';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `login_statistic`
--

DROP TABLE IF EXISTS `login_statistic`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `login_statistic` (
  `which_month` datetime NOT NULL COMMENT '哪一個月',
  `count` int(11) NOT NULL COMMENT '線上人數',
  PRIMARY KEY  (`which_month`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='紀錄每個月線上人數';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lrtcourse_classify_`
--

DROP TABLE IF EXISTS `lrtcourse_classify_`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lrtcourse_classify_` (
  `course_classify_cd` int(5) NOT NULL auto_increment COMMENT '課程科目類別編號',
  `course_classify_name` varchar(32) NOT NULL COMMENT '課程科目類別名稱',
  `course_classify_parent` char(5) NOT NULL COMMENT '所屬上級類別編號',
  `course_classify_level` char(1) default NULL COMMENT '所屬層級',
  `inner_cd` int(5) default NULL COMMENT '對應對方內部編號--哪一個單位 (ex. 高師大系統, …)',
  PRIMARY KEY  (`course_classify_cd`,`course_classify_parent`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lrtmenu_`
--

DROP TABLE IF EXISTS `lrtmenu_`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lrtmenu_` (
  `menu_id` varchar(10) NOT NULL,
  `menu_level` char(1) NOT NULL,
  `menu_name` varchar(50) NOT NULL,
  `menu_link` varchar(100) NOT NULL,
  `menu_state` char(1) NOT NULL,
  `sort_id` int(11) NOT NULL,
  PRIMARY KEY  (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lrtrole_`
--

DROP TABLE IF EXISTS `lrtrole_`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lrtrole_` (
  `role_cd` int(2) NOT NULL,
  `role_name` varchar(16) NOT NULL,
  PRIMARY KEY  (`role_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lrtstorecd_basic_`
--

DROP TABLE IF EXISTS `lrtstorecd_basic_`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lrtstorecd_basic_` (
  `type_cd` int(2) NOT NULL auto_increment COMMENT '補助單位_代碼',
  `type_name` varchar(64) NOT NULL COMMENT '代碼型式名稱',
  `type_id` char(4) NOT NULL COMMENT '代碼型式',
  `type_id_name` varchar(30) NOT NULL COMMENT '編碼名稱',
  PRIMARY KEY  (`type_cd`,`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lrtunit_basic_`
--

DROP TABLE IF EXISTS `lrtunit_basic_`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lrtunit_basic_` (
  `unit_cd` int(10) NOT NULL COMMENT '系所代號',
  `unit_name` varchar(100) default NULL COMMENT '系所名稱',
  `unit_abbrev` varchar(30) default NULL COMMENT '系所英文名稱',
  `unit_e_name` varchar(64) default NULL COMMENT '系所簡稱',
  `unit_e_abbrev` varchar(70) default NULL COMMENT '系所英文簡稱',
  `unit_state` char(1) NOT NULL COMMENT '使用狀況，說明 : 0 不使用 , 1 使用 1:true/0:false/預設值:0), 未有功能',
  `department` varchar(10) default NULL COMMENT '所屬部門或機關，假設工學院代號為10，則資工系的department就是10',
  PRIMARY KEY  (`unit_cd`),
  KEY `department` (`department`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_course`
--

DROP TABLE IF EXISTS `mdl_course`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_course` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `category` bigint(10) unsigned NOT NULL default '0',
  `sortorder` bigint(10) unsigned NOT NULL default '0',
  `password` varchar(50) NOT NULL default '',
  `fullname` varchar(254) NOT NULL default '',
  `shortname` varchar(100) NOT NULL default '',
  `idnumber` varchar(100) NOT NULL default '',
  `summary` text,
  `format` varchar(10) NOT NULL default 'topics',
  `showgrades` tinyint(2) unsigned NOT NULL default '1',
  `modinfo` longtext,
  `newsitems` mediumint(5) unsigned NOT NULL default '1',
  `teacher` varchar(100) NOT NULL default 'Teacher',
  `teachers` varchar(100) NOT NULL default 'Teachers',
  `student` varchar(100) NOT NULL default 'Student',
  `students` varchar(100) NOT NULL default 'Students',
  `guest` tinyint(2) unsigned NOT NULL default '0',
  `startdate` bigint(10) unsigned NOT NULL default '0',
  `enrolperiod` bigint(10) unsigned NOT NULL default '0',
  `numsections` mediumint(5) unsigned NOT NULL default '1',
  `marker` bigint(10) unsigned NOT NULL default '0',
  `maxbytes` bigint(10) unsigned NOT NULL default '0',
  `showreports` smallint(4) unsigned NOT NULL default '0',
  `visible` tinyint(1) unsigned NOT NULL default '1',
  `hiddensections` tinyint(2) unsigned NOT NULL default '0',
  `groupmode` smallint(4) unsigned NOT NULL default '0',
  `groupmodeforce` smallint(4) unsigned NOT NULL default '0',
  `defaultgroupingid` bigint(10) unsigned NOT NULL default '0',
  `lang` varchar(30) NOT NULL default '',
  `theme` varchar(50) NOT NULL default '',
  `cost` varchar(10) NOT NULL default '',
  `currency` varchar(3) NOT NULL default 'USD',
  `timecreated` bigint(10) unsigned NOT NULL default '0',
  `timemodified` bigint(10) unsigned NOT NULL default '0',
  `metacourse` tinyint(1) unsigned NOT NULL default '0',
  `requested` tinyint(1) unsigned NOT NULL default '0',
  `restrictmodules` tinyint(1) unsigned NOT NULL default '0',
  `expirynotify` tinyint(1) unsigned NOT NULL default '0',
  `expirythreshold` bigint(10) unsigned NOT NULL default '0',
  `notifystudents` tinyint(1) unsigned NOT NULL default '0',
  `enrollable` tinyint(1) unsigned NOT NULL default '1',
  `enrolstartdate` bigint(10) unsigned NOT NULL default '0',
  `enrolenddate` bigint(10) unsigned NOT NULL default '0',
  `enrol` varchar(20) NOT NULL default '',
  `defaultrole` bigint(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `mdl_cour_cat_ix` (`category`),
  KEY `mdl_cour_idn_ix` (`idnumber`),
  KEY `mdl_cour_sho_ix` (`shortname`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Central course table';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_course_modules`
--

DROP TABLE IF EXISTS `mdl_course_modules`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_course_modules` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `course` bigint(10) unsigned NOT NULL default '0',
  `module` bigint(10) unsigned NOT NULL default '0',
  `instance` bigint(10) unsigned NOT NULL default '0',
  `section` bigint(10) unsigned NOT NULL default '0',
  `idnumber` varchar(100) default NULL,
  `added` bigint(10) unsigned NOT NULL default '0',
  `score` smallint(4) NOT NULL default '0',
  `indent` mediumint(5) unsigned NOT NULL default '0',
  `visible` tinyint(1) NOT NULL default '1',
  `visibleold` tinyint(1) NOT NULL default '1',
  `groupmode` smallint(4) NOT NULL default '0',
  `groupingid` bigint(10) unsigned NOT NULL default '0',
  `groupmembersonly` smallint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `mdl_courmodu_vis_ix` (`visible`),
  KEY `mdl_courmodu_cou_ix` (`course`),
  KEY `mdl_courmodu_mod_ix` (`module`),
  KEY `mdl_courmodu_ins_ix` (`instance`),
  KEY `mdl_courmodu_idncou_ix` (`idnumber`,`course`),
  KEY `mdl_courmodu_gro_ix` (`groupingid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='course_modules table retrofitted from MySQL';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_modules`
--

DROP TABLE IF EXISTS `mdl_modules`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_modules` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `version` bigint(10) NOT NULL default '0',
  `cron` bigint(10) unsigned NOT NULL default '0',
  `lastcron` bigint(10) unsigned NOT NULL default '0',
  `search` varchar(255) NOT NULL default '',
  `visible` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `mdl_modu_nam_ix` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='modules available in the site';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_scorm`
--

DROP TABLE IF EXISTS `mdl_scorm`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_scorm` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `course` bigint(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `reference` varchar(255) NOT NULL default '',
  `summary` text NOT NULL,
  `version` varchar(9) NOT NULL default '',
  `maxgrade` double NOT NULL default '0',
  `grademethod` tinyint(2) NOT NULL default '0',
  `whatgrade` bigint(10) NOT NULL default '0',
  `maxattempt` bigint(10) NOT NULL default '1',
  `updatefreq` tinyint(1) unsigned NOT NULL default '0',
  `md5hash` varchar(32) NOT NULL default '',
  `launch` bigint(10) unsigned NOT NULL default '0',
  `skipview` tinyint(1) unsigned NOT NULL default '1',
  `hidebrowse` tinyint(1) NOT NULL default '0',
  `hidetoc` tinyint(1) NOT NULL default '0',
  `hidenav` tinyint(1) NOT NULL default '0',
  `auto` tinyint(1) unsigned NOT NULL default '0',
  `popup` tinyint(1) unsigned NOT NULL default '0',
  `options` varchar(255) NOT NULL default '',
  `width` bigint(10) unsigned NOT NULL default '100',
  `height` bigint(10) unsigned NOT NULL default '600',
  `timemodified` bigint(10) unsigned NOT NULL default '0',
  `content_cd` int(7) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `mdl_scor_cou_ix` (`course`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='each table is one SCORM module and its configuration';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_scorm_scoes`
--

DROP TABLE IF EXISTS `mdl_scorm_scoes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_scorm_scoes` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `scorm` bigint(10) unsigned NOT NULL default '0',
  `manifest` varchar(255) NOT NULL default '',
  `organization` varchar(255) NOT NULL default '',
  `parent` varchar(255) NOT NULL default '',
  `identifier` varchar(255) NOT NULL default '',
  `launch` varchar(255) NOT NULL default '',
  `scormtype` varchar(5) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `mdl_scorscoe_sco_ix` (`scorm`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='each SCO part of the SCORM module';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_scorm_scoes_data`
--

DROP TABLE IF EXISTS `mdl_scorm_scoes_data`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_scorm_scoes_data` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `scoid` bigint(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `mdl_scorscoedata_sco_ix` (`scoid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Contains variable data get from packages';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_scorm_scoes_track`
--

DROP TABLE IF EXISTS `mdl_scorm_scoes_track`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_scorm_scoes_track` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `userid` bigint(10) unsigned NOT NULL default '0',
  `scormid` bigint(10) NOT NULL default '0',
  `scoid` bigint(10) unsigned NOT NULL default '0',
  `attempt` bigint(10) unsigned NOT NULL default '1',
  `element` varchar(255) NOT NULL default '',
  `value` longtext NOT NULL,
  `timemodified` bigint(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `mdl_scorscoetrac_usescosco_uix` (`userid`,`scormid`,`scoid`,`attempt`,`element`),
  KEY `mdl_scorscoetrac_sco_ix` (`scormid`),
  KEY `timemodified` (`timemodified`),
  KEY `userid` (`userid`,`scoid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='to track SCOes';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_scorm_scoes_track_time`
--

DROP TABLE IF EXISTS `mdl_scorm_scoes_track_time`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_scorm_scoes_track_time` (
  `id` bigint(10) unsigned NOT NULL,
  `timemodified` bigint(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='to track SCOes';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_scorm_seq_mapinfo`
--

DROP TABLE IF EXISTS `mdl_scorm_seq_mapinfo`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_scorm_seq_mapinfo` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `scoid` bigint(10) unsigned NOT NULL default '0',
  `objectiveid` bigint(10) unsigned NOT NULL default '0',
  `targetobjectiveid` bigint(10) unsigned NOT NULL default '0',
  `readsatisfiedstatus` tinyint(1) NOT NULL default '1',
  `readnormalizedmeasure` tinyint(1) NOT NULL default '1',
  `writesatisfiedstatus` tinyint(1) NOT NULL default '0',
  `writenormalizedmeasure` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `mdl_scorseqmapi_scoidobj_uix` (`scoid`,`id`,`objectiveid`),
  KEY `mdl_scorseqmapi_sco_ix` (`scoid`),
  KEY `mdl_scorseqmapi_obj_ix` (`objectiveid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='SCORM2004 objective mapinfo description';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_scorm_seq_objective`
--

DROP TABLE IF EXISTS `mdl_scorm_seq_objective`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_scorm_seq_objective` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `scoid` bigint(10) unsigned NOT NULL default '0',
  `primaryobj` tinyint(1) NOT NULL default '0',
  `objectiveid` bigint(10) unsigned NOT NULL default '0',
  `satisfiedbymeasure` tinyint(1) NOT NULL default '1',
  `minnormalizedmeasure` float(11,4) unsigned NOT NULL default '0.0000',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `mdl_scorseqobje_scoid_uix` (`scoid`,`id`),
  KEY `mdl_scorseqobje_sco_ix` (`scoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='SCORM2004 objective description';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_scorm_seq_rolluprule`
--

DROP TABLE IF EXISTS `mdl_scorm_seq_rolluprule`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_scorm_seq_rolluprule` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `scoid` bigint(10) unsigned NOT NULL default '0',
  `childactivityset` varchar(15) NOT NULL default '',
  `minimumcount` bigint(10) unsigned NOT NULL default '0',
  `minimumpercent` float(11,4) unsigned NOT NULL default '0.0000',
  `conditioncombination` varchar(3) NOT NULL default 'all',
  `action` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `mdl_scorseqroll_scoid_uix` (`scoid`,`id`),
  KEY `mdl_scorseqroll_sco_ix` (`scoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='SCORM2004 sequencing rule';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_scorm_seq_rolluprulecond`
--

DROP TABLE IF EXISTS `mdl_scorm_seq_rolluprulecond`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_scorm_seq_rolluprulecond` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `scoid` bigint(10) unsigned NOT NULL default '0',
  `rollupruleid` bigint(10) unsigned NOT NULL default '0',
  `operator` varchar(5) NOT NULL default 'noOp',
  `cond` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `mdl_scorseqroll_scorolid_uix` (`scoid`,`rollupruleid`,`id`),
  KEY `mdl_scorseqroll_sco2_ix` (`scoid`),
  KEY `mdl_scorseqroll_rol_ix` (`rollupruleid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='SCORM2004 sequencing rule';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_scorm_seq_rulecond`
--

DROP TABLE IF EXISTS `mdl_scorm_seq_rulecond`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_scorm_seq_rulecond` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `scoid` bigint(10) unsigned NOT NULL default '0',
  `ruleconditionsid` bigint(10) unsigned NOT NULL default '0',
  `refrencedobjective` varchar(255) NOT NULL default '',
  `measurethreshold` float(11,4) NOT NULL default '0.0000',
  `operator` varchar(5) NOT NULL default 'noOp',
  `cond` varchar(30) NOT NULL default 'always',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `mdl_scorseqrule_idscorul_uix` (`id`,`scoid`,`ruleconditionsid`),
  KEY `mdl_scorseqrule_sco2_ix` (`scoid`),
  KEY `mdl_scorseqrule_rul_ix` (`ruleconditionsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='SCORM2004 rule condition';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mdl_scorm_seq_ruleconds`
--

DROP TABLE IF EXISTS `mdl_scorm_seq_ruleconds`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mdl_scorm_seq_ruleconds` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `scoid` bigint(10) unsigned NOT NULL default '0',
  `conditioncombination` varchar(3) NOT NULL default 'all',
  `ruletype` tinyint(2) unsigned NOT NULL default '0',
  `action` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `mdl_scorseqrule_scoid_uix` (`scoid`,`id`),
  KEY `mdl_scorseqrule_sco_ix` (`scoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='SCORM2004 rule conditions';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `menu_role`
--

DROP TABLE IF EXISTS `menu_role`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `menu_role` (
  `menu_id` varchar(10) NOT NULL,
  `role_cd` int(2) NOT NULL,
  `is_used` char(1) default NULL,
  `begin_course_cd` int(7) NOT NULL,
  PRIMARY KEY  (`menu_id`,`role_cd`,`begin_course_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `message` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '-1',
  `content` text,
  `name` text,
  `email` varchar(50) default NULL,
  `release` tinyint(1) NOT NULL default '0',
  `date` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `msgbook`
--

DROP TABLE IF EXISTS `msgbook`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `msgbook` (
  `mid` smallint(5) NOT NULL auto_increment COMMENT 'main id ',
  `seq` int(3) NOT NULL default '0' COMMENT 'for_replay , 0 is main post , other is reply ',
  `nick` varchar(40) collate utf8_unicode_ci NOT NULL,
  `dtime` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `email` varchar(100) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
  `personal_id` int(10) NOT NULL,
  PRIMARY KEY  (`mid`,`seq`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `news` (
  `news_cd` int(7) NOT NULL auto_increment COMMENT '公告的id,  auto_increament,  公告編號',
  `subject` varchar(100) NOT NULL COMMENT '公告主旨',
  `personal_id` int(11) NOT NULL default '0' COMMENT '公告者的personal_id,用來紀錄是由誰發的公告, 如果查無id可能發文者不在系統內,請記得實做',
  `d_news_begin` datetime NOT NULL COMMENT '公告日期_起始時間',
  `d_news_end` datetime default NULL COMMENT '公告日期_結束公告時間',
  `content` text NOT NULL COMMENT '公告內容',
  `important` tinyint(4) default NULL COMMENT '重要性：0:普通/1:中級/2:高級/預設值:1',
  `frequency` int(11) default NULL COMMENT '瀏覽次數，有人瀏覽就加一',
  `d_cycle` char(8) default NULL COMMENT '週期日期，default "0000-00-00" 公告週期使用，搭配week',
  `week_cycle` char(2) default NULL COMMENT '週期星期，default 0  ',
  `handle` varchar(1) default NULL COMMENT '過期處理方式，default 0，0砍去，1保留',
  `mtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '最近更改時間，sql update 時自動更新',
  `if_news` char(1) default NULL COMMENT '判斷公告型式，1:一般/ 2:週期',
  PRIMARY KEY  (`news_cd`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='"公告"的主要Table';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `news_target`
--

DROP TABLE IF EXISTS `news_target`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `news_target` (
  `news_cd` int(7) NOT NULL COMMENT 'this.news_cd=news.news_cd  用來辨認是哪個news (global id)',
  `role_cd` int(2) default NULL COMMENT '發公告的角色為? 老師?助教?管理者?',
  `begin_course_cd` int(7) default NULL COMMENT '辨別是哪門課,管理者則為null',
  `course_type` int(1) default NULL COMMENT '0 - 一般民眾課程,1 - 國民中小學課程, 2 - 高中職課程, 3 - 大專院校課程',
  PRIMARY KEY  (`news_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `news_upload`
--

DROP TABLE IF EXISTS `news_upload`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `news_upload` (
  `news_cd` int(7) NOT NULL COMMENT 'this.news_cd=news.news_cd  用來辨認是哪個news (global id)',
  `file_cd` int(5) NOT NULL auto_increment COMMENT '檔案編號，auto increment',
  `file_name` varchar(128) NOT NULL COMMENT '檔案名稱，下載時幫user rename成此名稱',
  `file_type` char(10) default NULL COMMENT '檔案型態，rar=1，doc=2，pdf=3，htm=4，html=5，txt=6',
  `news_file` varchar(100) default NULL COMMENT '實體檔案系統檔名改為公告編號(參考news_cd)',
  `file_url` varchar(128) default NULL COMMENT '連結文件的網址',
  `if_url` char(1) default NULL COMMENT '判斷檔案or網址',
  PRIMARY KEY  (`news_cd`,`file_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公告上傳文件相關資訊';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `nknu_course_log`
--

DROP TABLE IF EXISTS `nknu_course_log`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `nknu_course_log` (
  `id` int(11) NOT NULL auto_increment,
  `Import_ID` varchar(50) default NULL,
  `CourseName` varchar(50) default NULL,
  `AllowNo` varchar(50) default NULL,
  `CourseProperty_1` int(11) default NULL,
  `CourseProperty_2` int(11) default NULL,
  `CourseProperty_3` int(11) default NULL,
  `CourseProperty_4` int(11) default NULL,
  `SchoolId` varchar(50) default NULL,
  `CourseKind` int(11) default NULL,
  `CourseHour` int(11) default NULL,
  `StartTime` varchar(50) default NULL,
  `EndTime` varchar(50) default NULL,
  `TimeId` varchar(50) default NULL,
  `FundId` int(11) default NULL,
  `SubsidizeId` int(11) default NULL,
  `Contact_1_name` varchar(50) default NULL,
  `Contact_1_tel` varchar(50) default NULL,
  `Contact_1_mail` varchar(50) default NULL,
  `Contact_2_name` varchar(50) default NULL,
  `Contact_2_tel` varchar(50) default NULL,
  `Contact_2_mail` varchar(50) default NULL,
  `TeacherList` varchar(50) default NULL,
  `FundMoney` int(11) default NULL,
  `Member` varchar(50) default NULL,
  `MemberKind` varchar(50) default NULL,
  `TeacherNum` int(11) default NULL,
  `ClassNum` int(11) default NULL,
  `ApplyStartTime` varchar(50) default NULL,
  `ApplyEndTime` varchar(50) default NULL,
  `Charge` int(11) default NULL,
  `CourseState` int(11) default NULL,
  `log_time` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `nknu_transfer_log`
--

DROP TABLE IF EXISTS `nknu_transfer_log`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `nknu_transfer_log` (
  `log_id` int(11) NOT NULL auto_increment,
  `begin_course_cd` int(11) NOT NULL,
  `course_name` varchar(60) NOT NULL,
  `log_type` varchar(16) NOT NULL,
  `log_info` text NOT NULL,
  `log_time` datetime NOT NULL,
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `notebook_content`
--

DROP TABLE IF EXISTS `notebook_content`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `notebook_content` (
  `notebook_cd` int(7) NOT NULL COMMENT '記事本編號',
  `menu_id` varchar(12) NOT NULL COMMENT 'Tree的 id',
  `menu_parentid` varchar(12) NOT NULL COMMENT 'parent node id',
  `caption` varchar(255) NOT NULL COMMENT '每個node的文字敘述',
  `url` varchar(255) NOT NULL COMMENT '每個node點下去要道哪個link去',
  `exp` int(1) NOT NULL COMMENT '資料夾預設是展開或是縮起來',
  `icon` varchar(255) NOT NULL COMMENT '每個node的圖示 的路徑',
  `seq` double NOT NULL auto_increment,
  PRIMARY KEY  (`notebook_cd`,`menu_id`),
  UNIQUE KEY `seq` (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='記事本樹狀結構';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `notebook_node_content`
--

DROP TABLE IF EXISTS `notebook_node_content`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `notebook_node_content` (
  `notebook_cd` int(7) NOT NULL,
  `personal_id` int(10) NOT NULL,
  `menu_id` varchar(12) NOT NULL,
  `notebook_content` text COMMENT '記事內容',
  PRIMARY KEY  (`notebook_cd`,`personal_id`,`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `on_line`
--

DROP TABLE IF EXISTS `on_line`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `on_line` (
  `content_cd` int(7) NOT NULL COMMENT '教材編號, 隨選視訊相應的教材',
  `seq` int(7) NOT NULL auto_increment COMMENT '影片索引',
  `d_course` datetime default NULL COMMENT '上課時間',
  `subject` varchar(70) default NULL COMMENT '影像檔title',
  `media_content` text COMMENT '影像檔描述',
  `rfile` varchar(128) default NULL COMMENT '影像檔案或者外部連結, 程式再利用"://"來判斷是否外部連結',
  PRIMARY KEY  (`content_cd`,`seq`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `online_number`
--

DROP TABLE IF EXISTS `online_number`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `online_number` (
  `online_cd` int(7) NOT NULL auto_increment,
  `personal_id` int(10) NOT NULL,
  `begin_course_cd` int(7) NOT NULL,
  `host` varchar(32) default NULL,
  `time` varchar(16) default NULL,
  `idle` varchar(16) default NULL,
  `status` varchar(20) default NULL,
  PRIMARY KEY  (`online_cd`),
  KEY `personal_id` (`personal_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `online_survey`
--

DROP TABLE IF EXISTS `online_survey`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `online_survey` (
  `response_no` int(11) NOT NULL auto_increment,
  `personal_id` int(10) NOT NULL,
  `survey_no` int(7) NOT NULL,
  PRIMARY KEY  (`response_no`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `online_survey_content`
--

DROP TABLE IF EXISTS `online_survey_content`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `online_survey_content` (
  `survey_no` int(7) NOT NULL COMMENT '線上問卷編號',
  `survey_bankno` int(7) NOT NULL COMMENT '題庫編號',
  `survey_cd` int(7) NOT NULL COMMENT '題庫問題編號',
  `block_id` int(7) NOT NULL COMMENT '區塊號碼',
  `survey_type` tinyint(2) default NULL COMMENT '線上測驗的題型 		type:1 選擇題/type:2 簡答題',
  `question` text COMMENT '選項內容',
  `selection_no` int(7) default NULL COMMENT '選項數目',
  `selection1` text COMMENT '第一選項題目',
  `selection2` text COMMENT '第二選項題目',
  `selection3` text COMMENT '第三選項題目',
  `selection4` text COMMENT '第四選項題目',
  `selection5` text COMMENT '第五選項題目',
  `selection6` text COMMENT '第六選項題目',
  `is_multiple` char(1) default NULL COMMENT '表示是否複選		(0:False, 1:True,預設值0)',
  `selection_grade` char(12) default NULL COMMENT '選項配分		每2byte為一個選項的配分,如果只有四個選項,沒有選到的就補00,所以四個就補0000',
  `sequence` int(11) NOT NULL auto_increment COMMENT '題目順序	auto_increment',
  `mtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '最近更改時間',
  PRIMARY KEY  (`survey_no`,`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `online_survey_response`
--

DROP TABLE IF EXISTS `online_survey_response`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `online_survey_response` (
  `response_no` int(11) NOT NULL,
  `survey_cd` int(7) NOT NULL,
  `response` text NOT NULL,
  `grade` int(2) NOT NULL,
  PRIMARY KEY  (`response_no`,`survey_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `online_survey_setup`
--

DROP TABLE IF EXISTS `online_survey_setup`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `online_survey_setup` (
  `survey_no` int(7) NOT NULL auto_increment COMMENT '線上問卷編號	auto_increment',
  `survey_target` int(7) default NULL COMMENT '問卷填寫對象		"-1"表示所有學生，其餘和begin_course_cd相同',
  `survey_name` varchar(40) default NULL COMMENT '問卷名稱',
  `d_survey_beg` datetime default NULL COMMENT '開始問卷日期時間		開始可以填問卷的日期時間',
  `d_survey_end` datetime default NULL COMMENT '結束問卷日期時間',
  `d_survey_public` datetime default NULL COMMENT '公佈問卷日期(即公開給學員看到)		目前沒任何意義',
  `is_register` char(1) default NULL COMMENT '問卷是否記名	1:是 0:否',
  `mtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '最近更改時間',
  PRIMARY KEY  (`survey_no`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `person_epaper`
--

DROP TABLE IF EXISTS `person_epaper`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `person_epaper` (
  `personal_id` int(10) NOT NULL COMMENT '使用者的代號		',
  `epaper_cd` int(7) default '0' COMMENT '電子報編號',
  `begin_course_cd` int(7) NOT NULL default '0' COMMENT '開課編號		電子報的訂閱是以課程為來區分, 需要紀錄課程編號',
  `start_periodical_cd` int(7) default NULL COMMENT '開始期刊編號		開始期刊編號		',
  `end_periodical_cd` int(7) default NULL COMMENT '結束期刊編號',
  `if_subscription` char(1) NOT NULL COMMENT '是否定閱電子報',
  PRIMARY KEY  (`personal_id`,`begin_course_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `personal_basic`
--

DROP TABLE IF EXISTS `personal_basic`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `personal_basic` (
  `personal_id` int(10) NOT NULL COMMENT '人員編號',
  `idorpas` tinyint(4) NOT NULL,
  `identify_id` char(20) NOT NULL COMMENT '身份證ID (有query會用到 故設index)',
  `passport` varchar(15) NOT NULL,
  `personal_name` char(20) NOT NULL COMMENT '名稱',
  `nickname` varchar(20) default NULL COMMENT '暱稱',
  `aptitude` varchar(20) default NULL COMMENT '性向',
  `forbear` varchar(32) default NULL COMMENT '發呆時間',
  `sex` char(1) NOT NULL default '1' COMMENT '性別',
  `d_birthday` datetime default NULL COMMENT '生日',
  `tel` varchar(32) default NULL COMMENT '聯絡電話',
  `tel2` varchar(32) default NULL COMMENT '聯絡電話2',
  `tel3` varchar(32) NOT NULL COMMENT '傳真號碼',
  `zone_cd` char(5) default NULL COMMENT '郵遞區號',
  `addr` varchar(60) default NULL COMMENT '住址',
  `familysite` varchar(20) NOT NULL,
  `familysiteo` varchar(30) NOT NULL,
  `email` varchar(40) default NULL COMMENT '電子郵件地址',
  `personal_home` varchar(128) default NULL COMMENT '個人首頁',
  `photo` varchar(100) default NULL COMMENT '照片位址',
  `job` varchar(60) default NULL COMMENT '現職',
  `title` varchar(60) NOT NULL,
  `degree` char(1) default NULL COMMENT '學歷',
  `teach_doc` varchar(36) default NULL COMMENT '教師證號',
  `city_cd` int(10) NOT NULL,
  `doc_cd` int(10) NOT NULL,
  `school_type` int(4) NOT NULL,
  `school_cd` int(4) NOT NULL,
  `othersch` varchar(20) NOT NULL,
  `organ_zone_cd` int(7) default NULL COMMENT '服務單位郵遞區號',
  `organization` varchar(64) default NULL COMMENT '服務單位',
  `introduction` text COMMENT '自我介紹',
  `interest` text COMMENT '興趣',
  `skill` text COMMENT '專長',
  `experience` text COMMENT '經歷',
  `dist_cd` char(1) default NULL COMMENT '身份別',
  `dist_type` tinyint(4) NOT NULL,
  `feedback` text COMMENT '心得(有話要說)',
  `signature` text COMMENT '簽名',
  `note` text COMMENT '備註',
  `personal_style` varchar(20) NOT NULL COMMENT '個人化頁面風格',
  `course_style` varchar(20) NOT NULL COMMENT '課程頁面風格',
  `course_div` varchar(20) NOT NULL default '1^2^3^4^5^6^' COMMENT '個人化版面設計記錄',
  `mtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '最近更改時間',
  `recnews` tinyint(4) NOT NULL,
  PRIMARY KEY  (`personal_id`),
  KEY `identify_id` (`identify_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `personal_notebook`
--

DROP TABLE IF EXISTS `personal_notebook`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `personal_notebook` (
  `notebook_cd` int(7) NOT NULL auto_increment,
  `personal_id` int(10) NOT NULL,
  `notebook_name` varchar(64) NOT NULL COMMENT '筆記本名稱',
  `d_notebook_beg` date NOT NULL,
  `is_public` int(1) NOT NULL default '0' COMMENT '是否公開',
  PRIMARY KEY  (`notebook_cd`,`personal_id`),
  KEY `personal_id` (`personal_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='個人筆記本';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `popularity`
--

DROP TABLE IF EXISTS `popularity`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `popularity` (
  `sid` int(11) NOT NULL auto_increment,
  `ip_addr` varchar(15) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `popularity_noip`
--

DROP TABLE IF EXISTS `popularity_noip`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `popularity_noip` (
  `date` date NOT NULL,
  `num` int(11) NOT NULL,
  PRIMARY KEY  (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `project_data`
--

DROP TABLE IF EXISTS `project_data`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `project_data` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `homework_no` int(7) NOT NULL COMMENT '作業編號',
  `project_goal` text NOT NULL COMMENT '目標',
  `due_date` datetime NOT NULL COMMENT '最慢分組時間',
  `ref_doc` text NOT NULL COMMENT '參考資料',
  `group_member` int(1) NOT NULL COMMENT '分組人數',
  `group_number` int(2) NOT NULL COMMENT '分組數目',
  `score_type` char(1) NOT NULL COMMENT '計分型式		1.組 , 2 . 個人 , 3 . 組% + 人%,4.不互評',
  `comment` text NOT NULL COMMENT 'project 備註 ',
  `person_rate` int(2) NOT NULL COMMENT 'score_type=3才會用到, 個人比率		100%- 個人比率 = 組比率',
  `self_appointed` int(1) NOT NULL COMMENT '學生是否自定題目		(0:Fault, 1:True ,預設值:0)',
  PRIMARY KEY  (`begin_course_cd`,`homework_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='­';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `projectwork`
--

DROP TABLE IF EXISTS `projectwork`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `projectwork` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號		一個作業不同的project題目',
  `homework_no` int(7) NOT NULL COMMENT '作業編號',
  `project_no` int(7) NOT NULL auto_increment COMMENT '合作學習編號	auto_increment',
  `groupno_topic` int(7) NOT NULL default '0' COMMENT '學生自定題目(存group_no)分組編號_題目		(0:Fault,預設值:0 , 如果由老師訂義,學生訂義就輸入組的編號)',
  `project_content` text COMMENT 'project 內容',
  `similar_project_number` int(1) default NULL COMMENT '可重覆組數		每一個project可以重覆該題目的組數',
  PRIMARY KEY  (`begin_course_cd`,`homework_no`,`project_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='å°ˆæ¡ˆä½œæ¥­å…§å®¹';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `register_applycourse`
--

DROP TABLE IF EXISTS `register_applycourse`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `register_applycourse` (
  `no` int(11) NOT NULL auto_increment COMMENT '帳號序號',
  `account` varchar(32) NOT NULL COMMENT '開課帳號',
  `password` varchar(80) NOT NULL COMMENT '開課密碼',
  `category` char(1) NOT NULL COMMENT '1-縣市政府, 2-大專院校, 3-數位機會中心輔導團, 4-DOC(數位機會中心), isalpha a-資教組, b-資源組, c-學習組',
  `city_cd` int(11) NOT NULL,
  `school_cd` int(11) NOT NULL,
  `org_title` varchar(64) NOT NULL COMMENT '單位名稱 (例：花蓮縣政府、國立宜蘭大學 輔導團隊)',
  `undertaker` varchar(10) NOT NULL COMMENT '聯絡人(或承辦人)',
  `identify` char(20) NOT NULL COMMENT '申請人身份證',
  `title` char(25) NOT NULL COMMENT '職稱',
  `tel` varchar(64) NOT NULL COMMENT '電話 (可存多組 用逗號分隔)',
  `email` varchar(100) NOT NULL COMMENT 'e-mail',
  `usage_note` text NOT NULL COMMENT '帳號申請用途',
  `apply_date` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT '申請日期',
  `verify_date` timestamp NULL default NULL COMMENT '審核日期',
  `login_date` timestamp NULL default NULL COMMENT '最後登入日期',
  `state` int(1) NOT NULL default '0' COMMENT '審核狀態：0-未審核,1-通過, -1-不通過',
  `state_reason` text COMMENT '未通過原因',
  `menu_role` text NOT NULL COMMENT '登入後，所要顯示的menu  (使用json array紀錄 )',
  PRIMARY KEY  (`no`),
  UNIQUE KEY `帳號是唯一的` (`account`),
  KEY `city_cd` (`city_cd`,`school_cd`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `register_basic`
--

DROP TABLE IF EXISTS `register_basic`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `register_basic` (
  `login_id` char(20) NOT NULL COMMENT '帳號',
  `personal_id` int(10) NOT NULL auto_increment COMMENT '人員編號',
  `pass` varchar(70) NOT NULL COMMENT '密碼',
  `password_hint` varchar(16) NOT NULL COMMENT '密碼提示',
  `d_loging` datetime default NULL COMMENT '帳號啟用日期',
  `role_cd` int(2) default NULL COMMENT '角色編號',
  `login_state` char(1) default '0' COMMENT '帳號使用狀況',
  `validated` char(1) default '0' COMMENT '帳號是否核準',
  PRIMARY KEY  (`login_id`),
  UNIQUE KEY `personal_id` (`personal_id`),
  KEY `role_cd` (`role_cd`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `roll_book`
--

DROP TABLE IF EXISTS `roll_book`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `roll_book` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `personal_id` int(10) NOT NULL COMMENT '學員編號',
  `roll_id` int(11) NOT NULL COMMENT '第幾次點名		程式產生?',
  `roll_date` datetime default NULL COMMENT '點名的日期',
  `state` int(11) default NULL COMMENT '出席狀況 0:出席 1:缺席 2:遲到 3:早退 4:請假  5:其他',
  `email_concent` text COMMENT 'email concent		拚錯字的感覺',
  `if_email` char(1) default NULL COMMENT 'email 通知',
  PRIMARY KEY  (`begin_course_cd`,`personal_id`,`roll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `roll_book_status_grade`
--

DROP TABLE IF EXISTS `roll_book_status_grade`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `roll_book_status_grade` (
  `begin_course_cd` int(7) NOT NULL,
  `status_id` int(2) NOT NULL,
  `status_grade` int(3) NOT NULL,
  PRIMARY KEY  (`begin_course_cd`,`status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `student_learning`
--

DROP TABLE IF EXISTS `student_learning`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `student_learning` (
  `begin_course_cd` int(7) NOT NULL,
  `content_cd` int(7) NOT NULL COMMENT '教材編號',
  `personal_id` int(10) NOT NULL,
  `menu_id` varchar(12) NOT NULL COMMENT 'tree的id',
  `event_happen_number` int(5) default NULL COMMENT '次數',
  `event_hold_time` time default NULL COMMENT '總共持續時間',
  `event_occur_time` timestamp NULL default NULL COMMENT '開始時間',
  `event_last_time` timestamp NULL default NULL COMMENT '最後時間',
  PRIMARY KEY  (`begin_course_cd`,`content_cd`,`personal_id`,`menu_id`),
  KEY `begin_course_cd` (`begin_course_cd`,`personal_id`,`menu_id`),
  KEY `personal_id` (`personal_id`,`content_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `survey_bank`
--

DROP TABLE IF EXISTS `survey_bank`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `survey_bank` (
  `survey_bankno` int(7) NOT NULL auto_increment COMMENT '問卷題庫編號	auto_increment',
  `personal_id` int(10) NOT NULL COMMENT '題庫擁有者編號',
  PRIMARY KEY  (`survey_bankno`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `survey_bank_question`
--

DROP TABLE IF EXISTS `survey_bank_question`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `survey_bank_question` (
  `survey_bankno` int(7) NOT NULL COMMENT '111題庫問卷編號',
  `survey_cd` int(7) NOT NULL auto_increment COMMENT '問卷的題號	auto_increment',
  `block_id` int(7) NOT NULL default '0' COMMENT 'survey_bank_question.survey_cd區塊號碼		子題--記錄隸屬哪一個問卷編號',
  `survey_type` tinyint(2) NOT NULL default '1' COMMENT '線上測驗的題型		1:選擇題/2:問答題',
  `question` text COMMENT '選項內容',
  `selection1` text COMMENT '第一選項題目',
  `selection2` text COMMENT '第二選項題目',
  `selection3` text COMMENT '第三選項題目',
  `selection4` text COMMENT '第四選項題目',
  `selection5` text COMMENT '第五選項題目',
  `selection6` text COMMENT '第六選項題目',
  `selection_no` int(7) NOT NULL default '0' COMMENT '選項數目',
  `is_multiple` char(1) NOT NULL default '0' COMMENT '表示是否複選		(0:False, 1:True,預設值0)',
  PRIMARY KEY  (`survey_bankno`,`survey_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='111';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `survey_student`
--

DROP TABLE IF EXISTS `survey_student`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `survey_student` (
  `survey_no` int(7) NOT NULL COMMENT '線上問卷編號',
  `survey_flag` int(1) default NULL COMMENT '學員是否已填寫問卷',
  `personal_id` int(10) NOT NULL COMMENT '學員編號',
  `mtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '最近更改時間',
  PRIMARY KEY  (`survey_no`,`personal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `take_course`
--

DROP TABLE IF EXISTS `take_course`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `take_course` (
  `begin_course_cd` int(7) NOT NULL,
  `personal_id` int(10) NOT NULL,
  `allow_course` char(1) default NULL,
  `status_student` char(1) default NULL COMMENT '0:旁聽生  1:正修生 ',
  `note` text,
  `pass` int(11) NOT NULL default '-1' COMMENT '判斷課程是否通過(自學式) -1:未判斷0:未通過,1:通過',
  `pass_time` date default NULL,
  `course_begin` date default NULL COMMENT '用來紀錄選課時間',
  `course_end` date default NULL COMMENT '用來紀錄使用者選了課程之後，修課期限到哪時候',
  `send2nknu_time` date NOT NULL COMMENT '傳送至高師大時間欄位',
  `send2nknu_course` varchar(128) NOT NULL,
  PRIMARY KEY  (`begin_course_cd`,`personal_id`),
  KEY `personal_id` (`personal_id`),
  KEY `allow_course` (`allow_course`,`pass`,`personal_id`),
  KEY `begin_course_cd` (`begin_course_cd`,`allow_course`,`course_begin`),
  KEY `course_begin` (`course_begin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `take_groups_score`
--

DROP TABLE IF EXISTS `take_groups_score`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `take_groups_score` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號		A組  成員 a1 , a2 , a3  , B組成員 b1 , b2 , b3 …',
  `homework_no` int(7) NOT NULL COMMENT '作業編號',
  `group_no` int(5) NOT NULL COMMENT '應該是組別編號',
  `assess_personal_id` int(10) NOT NULL COMMENT '評分學員編號		a1 打 B組分數',
  `take_group_no` int(5) NOT NULL COMMENT '受評組別編號',
  `take_group_score` int(3) default NULL COMMENT '受評組別分數		a2 打 B組分數',
  `assess_type` char(1) default NULL COMMENT '評分人員型式		判斷 assess_personal_id 是 s : student , t : teacher  ',
  PRIMARY KEY  (`begin_course_cd`,`homework_no`,`assess_personal_id`,`take_group_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='åˆ†çµ„åˆ†æ•¸';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `take_student_score`
--

DROP TABLE IF EXISTS `take_student_score`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `take_student_score` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號		A組  成員 a1 , a2 , a3  , B組成員 b1 , b2 , b3 …',
  `homework_no` int(7) NOT NULL COMMENT '作業編號',
  `group_no` int(5) NOT NULL COMMENT '評分組別編號',
  `assess_personal_id` int(10) NOT NULL COMMENT '評分者編號		a1 打 a2分數',
  `take_student_id` int(10) NOT NULL COMMENT '受評學員編號		a1 打 a3分數',
  `take_student_score` int(3) default NULL COMMENT '受評組員分數		a2 打 a1 分數 …',
  `assess_type` char(1) default NULL COMMENT '評分人員型式		判斷 assess_personal_id 是 s : student , t : teacher  ',
  PRIMARY KEY  (`begin_course_cd`,`homework_no`,`group_no`,`assess_personal_id`,`take_student_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='åˆ†çµ„çµ„å“¡åˆ†æ•¸ è©•å­¸ç”Ÿ';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `teach_aid`
--

DROP TABLE IF EXISTS `teach_aid`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `teach_aid` (
  `teacher_cd` int(10) NOT NULL,
  `if_aid_teacher_cd` int(10) NOT NULL,
  PRIMARY KEY  (`teacher_cd`,`if_aid_teacher_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `teach_begin_course`
--

DROP TABLE IF EXISTS `teach_begin_course`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `teach_begin_course` (
  `teacher_cd` int(10) NOT NULL COMMENT '老師編號',
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `course_master` char(1) default NULL COMMENT '是否主要課程填寫者(主要教師:1, 社群共同教師:0)',
  PRIMARY KEY  (`teacher_cd`,`begin_course_cd`),
  KEY `begin_course_cd` (`begin_course_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `test_bank`
--

DROP TABLE IF EXISTS `test_bank`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `test_bank` (
  `test_bankno` int(11) NOT NULL auto_increment COMMENT '測驗題目編號，auto_increment，題目的unique id',
  `content_cd` int(7) NOT NULL default '0' COMMENT '對應 content_test_bank的 content_cd，說明是哪份教材的(課程科目編號		為了對應content_test_bank的欄位)',
  `test_bank_id` int(7) NOT NULL default '0' COMMENT '對應到content_test_bank的 test_bank_id 對應到單一題庫，說明是哪份教材的哪份題庫的(課程科目教材編號		隸屬於教材的章節)',
  `test_type` tinyint(4) default NULL COMMENT '線上測驗的題型＝1:選擇題/2:是非題/3:填充題/4:問答題 (線上測驗的題型		1:選擇題/2:是非題/3:填充題/4:問答題)',
  `question` text COMMENT '題目內容',
  `selection_no` int(7) NOT NULL default '0' COMMENT '選項數目',
  `selection1` text COMMENT '第一選項題目',
  `selection2` text COMMENT '第二選項題目',
  `selection3` text COMMENT '第三選項題目',
  `selection4` text COMMENT '第四選項題目',
  `selection5` text COMMENT '第五選項題目',
  `selection6` text COMMENT '第六選項題目',
  `is_multiple` char(1) default '0' COMMENT '表示是否複選 (0:False, 1:True,預設值0)',
  `answer` text COMMENT '本題答案，以分號隔開各個答案',
  `answer_desc` text COMMENT '本題詳解',
  `file_picture_name` varchar(60) default NULL COMMENT '題目所用到圖片的檔案，放實體檔案名稱',
  `file_av_name` varchar(60) default NULL COMMENT '題目所用到影音的檔案，放實體檔案名稱',
  `difficulty` char(2) default NULL COMMENT '測驗難易 2:難 1:中 0:易',
  `if_ans_seq` char(1) default NULL COMMENT '答案是否依次序',
  PRIMARY KEY  (`test_bankno`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='所有題庫的所有測驗題目';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `test_course`
--

DROP TABLE IF EXISTS `test_course`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `test_course` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `test_bankno` int(7) NOT NULL COMMENT '題庫的測驗題目編號 this.test_bankno=test_bank.test_bankno',
  `test_no` int(7) NOT NULL COMMENT '線上測驗編號',
  `test_type` tinyint(4) default NULL COMMENT '線上測驗的題型1:選擇題/2:是非題/3:填充題/4:問答題',
  `question` text COMMENT '題目內容',
  `selection_no` int(7) default NULL COMMENT '選項數目',
  `selection1` text COMMENT '第一題選項題目',
  `selection2` text COMMENT '第二題選項題目',
  `selection3` text COMMENT '第三題選項題目',
  `selection4` text COMMENT '第四題選項題目',
  `selection5` text COMMENT '第五題選項題目',
  `selection6` text COMMENT '第六題選項題目',
  `is_multiple` char(1) default '0' COMMENT '表示是否複選(0:False, 1:True,預設值0)',
  `answer` text COMMENT '本題答案，以分號隔開各個答案',
  `answer_desc` text COMMENT '答案說明',
  `file_picture_name` varchar(60) default NULL COMMENT '題目所用到圖片的檔案，放檔案名稱&含路徑',
  `file_av_name` varchar(60) default NULL COMMENT '題目所用到影音的檔案，放檔案名稱&含路徑',
  `difficulty` char(2) default NULL COMMENT '測驗難易 2:難 1:中 0:易',
  `grade` int(3) default '0' COMMENT '本題配分，default 0分',
  `if_ans_seq` char(1) default '0' COMMENT '答案是否依次序 y or n?',
  `sequence` int(3) NOT NULL auto_increment COMMENT '題目順序 跟據不同 線上測驗的題型  Type 順序就重新編號',
  PRIMARY KEY  (`begin_course_cd`,`test_no`,`sequence`),
  KEY `begin_course_cd` (`begin_course_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='開課測驗試題，即線上測驗所出的題目';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `test_course_ans`
--

DROP TABLE IF EXISTS `test_course_ans`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `test_course_ans` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `test_no` int(7) NOT NULL COMMENT '線上測驗編號',
  `test_bankno` int(7) NOT NULL COMMENT '線上測驗題目',
  `personal_id` int(10) NOT NULL COMMENT '學員編號',
  `answer` text COMMENT '學員編號，以分號隔開各個答案',
  `grade` int(3) default NULL COMMENT '該題分數',
  PRIMARY KEY  (`begin_course_cd`,`test_no`,`test_bankno`,`personal_id`),
  KEY `begin_course_cd` (`begin_course_cd`,`test_no`,`personal_id`),
  KEY `begin_course_cd_2` (`begin_course_cd`,`test_no`,`personal_id`,`grade`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='線上測驗，學生測驗每題分數';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `test_course_setup`
--

DROP TABLE IF EXISTS `test_course_setup`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `test_course_setup` (
  `begin_course_cd` int(7) NOT NULL COMMENT '開課編號',
  `test_no` int(7) NOT NULL auto_increment COMMENT '測驗編號',
  `test_type` char(1) default NULL COMMENT '測驗種類 (1. 自評/2. 正式)',
  `test_name` varchar(80) default NULL COMMENT '測驗名稱',
  `is_online` char(1) default NULL COMMENT '是否為線上測驗(若否則為傳統紙上或其他方式測驗，此種狀況，系統只用來登記分數用)，(1:true/0:false/預設值:1)',
  `random` char(1) default NULL COMMENT '題目是否使用random排列，(0:False, 1:True, 預設值:0)',
  `d_test_beg` datetime default NULL COMMENT '開始測驗日期時間',
  `d_test_end` datetime default NULL COMMENT '結束測驗日期時間',
  `d_test_public` datetime default NULL COMMENT '公佈測驗日期(即公開給學員看到)',
  `percentage` int(7) default NULL COMMENT '佔學期總分數百分比 (0不計分)',
  `grade_public` char(1) default '0' COMMENT '測驗成績是否公佈(0:False/1:True/ 預設值:0)',
  `ans_public` int(1) NOT NULL default '0' COMMENT '答案是否公布(0:False, 1:True, 預設值:0)',
  `remind` int(3) NOT NULL default '0',
  PRIMARY KEY  (`begin_course_cd`,`test_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='紀錄有哪些線上測驗';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `test_rmd`
--

DROP TABLE IF EXISTS `test_rmd`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `test_rmd` (
  `rmd_id` int(20) NOT NULL,
  `personal_id` int(20) NOT NULL,
  `rmd_usb` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tracking_function_menu`
--

DROP TABLE IF EXISTS `tracking_function_menu`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tracking_function_menu` (
  `system_id` int(3) NOT NULL,
  `function_id` int(3) NOT NULL,
  `function_name` varchar(50) default NULL,
  `function_state` char(1) NOT NULL,
  PRIMARY KEY  (`system_id`,`function_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tracking_system_menu`
--

DROP TABLE IF EXISTS `tracking_system_menu`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tracking_system_menu` (
  `system_id` int(3) NOT NULL,
  `system_name` varchar(50) default NULL,
  `system_state` char(1) NOT NULL,
  PRIMARY KEY  (`system_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `transaction` (
  `online_trans` int(7) NOT NULL auto_increment,
  `send` int(10) default NULL,
  `receive` int(10) default NULL,
  `off_line` int(11) default NULL,
  `multi` int(11) default NULL,
  `message` text,
  `time` datetime default NULL,
  PRIMARY KEY  (`online_trans`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `transaction_friend`
--

DROP TABLE IF EXISTS `transaction_friend`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `transaction_friend` (
  `online_trans` int(7) NOT NULL auto_increment,
  `owner` int(10) default NULL,
  `friend` int(10) default NULL,
  `validated` int(1) NOT NULL default '0',
  `time` datetime default NULL,
  PRIMARY KEY  (`online_trans`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ups_ws_key`
--

DROP TABLE IF EXISTS `ups_ws_key`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ups_ws_key` (
  `user_id` int(11) NOT NULL,
  `api_key` varchar(256) NOT NULL,
  `ip_restrict` text NOT NULL,
  `usage` text NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  KEY `user_id` (`user_id`,`api_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ups_ws_log`
--

DROP TABLE IF EXISTS `ups_ws_log`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ups_ws_log` (
  `id` int(11) NOT NULL auto_increment,
  `api_key` varchar(256) NOT NULL,
  `service_id` int(11) NOT NULL,
  `level` varchar(10) NOT NULL,
  `message` varchar(256) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `api_key` (`api_key`,`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ups_ws_permission`
--

DROP TABLE IF EXISTS `ups_ws_permission`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ups_ws_permission` (
  `service_id` int(11) NOT NULL,
  `role_cd` char(1) NOT NULL,
  KEY `service_id` (`service_id`,`role_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ups_ws_services`
--

DROP TABLE IF EXISTS `ups_ws_services`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ups_ws_services` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  `class` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `class` (`class`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `users` (
  `User` varbinary(16) NOT NULL COMMENT 'user name (login username)',
  `Password` varbinary(64) NOT NULL COMMENT 'password md5 encryption',
  `Uid` int(11) NOT NULL default '-1',
  `Gid` int(11) NOT NULL default '-1',
  `Dir` varbinary(128) NOT NULL COMMENT 'home directory',
  PRIMARY KEY  (`User`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='pureftpä½¿ç”¨çš„å¸³è™Ÿè³‡æ–™table';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `users_admin`
--

DROP TABLE IF EXISTS `users_admin`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `users_admin` (
  `User` varbinary(16) NOT NULL COMMENT 'user name (login username)',
  `Password` varbinary(64) NOT NULL COMMENT 'password md5 encryption',
  `Uid` int(11) NOT NULL default '-1',
  `Gid` int(11) NOT NULL default '-1',
  `Dir` varbinary(128) NOT NULL COMMENT 'home directory',
  PRIMARY KEY  (`User`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='pureftpä½¿ç”¨çš„å¸³è™Ÿè³‡æ–™table';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `working_discuss_groups`
--

DROP TABLE IF EXISTS `working_discuss_groups`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `working_discuss_groups` (
  `begin_course_cd` int(7) NOT NULL,
  `group_no` int(5) NOT NULL,
  `discuss_cd` int(7) NOT NULL,
  PRIMARY KEY  (`begin_course_cd`,`group_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-03-13  8:24:22
