<?php
/***
FILE:   
DATE:   
AUTHOR: zqq
**/
$RELEATED_PATH = "../";
require_once($RELEATED_PATH . "config.php");
require_once($RELEATED_PATH . "session.php");
	//new smarty	
	$tpl = new Smarty();
	//查出課程資料
	$sql = "SELECT course_name, need_validate_select, is_public, schedule_unit, note FROM course_basic WHERE course_cd='".$_GET[course_cd]."'";
	$result = $DB_CONN->query($sql);	
	$course_data = $result->fetchRow(DB_FETCHMODE_ASSOC);
	//course_name
	$tpl->assign("course_name", $course_data[course_name]);
	//echo $course_data[course_name];
	//課程單位
	$tpl->assign("schedule_unit_ids", array('月', '週', '天', '次', '時'));
	$tpl->assign("schedule_unit_names",array('月', '週', '天', '次', '時'));
	$tpl->assign("schedule_unit_id", $course_data[schedule_unit]);
	//是否可選課
	$tpl->assign('need_validate_select_ids'		, array(0,1));
	$tpl->assign('need_validate_select_names'	, array('No','Yes'));
	$tpl->assign('need_validate_select_id'		, $course_data[need_validate_select]);	
	//是否開放教材
	$tpl->assign('is_public_ids'	, array(0,1));
	$tpl->assign('is_public_names'	, array('No','Yes'));
	$tpl->assign('is_public_id'		, $course_data[is_public]);	
	
	//note
	$tpl->assign("note", $course_data[note]);
	//輸出頁面
	$tpl->display("tea_show_course.tpl");			
?>	
	