<?php
/***
FILE:   
DATE:   2006/12/11
AUTHOR: zqq
**/
	require_once("../config.php");
	//new smarty
	$tpl = new Smarty();
	//查出課程資訊
	$sql = "SELECT * FROM begin_course WHERE begin_course_cd='".$_GET['begin_course_cd']."'";
	$res = $DB_CONN->query($sql);
	if(!($row = $res->fetchRow(DB_FETCHMODE_ASSOC))){
		echo "errors";
	}	
	$tpl->assign("output_message", "新增課程成功");	
	$tpl->assign("begin_course_name", $row['begin_course_name']);
	$tpl->assign("inner_course_cd", $row['inner_course_cd']);
	
	//輸出頁面
	$tpl->display("create_course_sucess.tpl");	
	
?>
