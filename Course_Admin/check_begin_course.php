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
	//將目前選定的begin_course_cd  註冊到session
	if(isset($_GET[begin_course_cd]))
		$_SESSION[cur_begin_course_cd] = $_GET[begin_course_cd];
	$course_type[ids] 	= array('unselect', 'normal', 'nknu');
	$course_type[names] = array('請選擇', '一般格式','高師格式');
	$tpl->assign("course_type_ids",$course_type[ids]);
	$tpl->assign("course_type_names",$course_type[names]);
	$tpl->assign("course_type_id",$course_type[ids][0]);			
	//輸出頁面
	$tpl->display("check_begin_course.tpl");
	
//----function area--------

?>
