<?php
/***
FILE:   
DATE:   2006/12/11
AUTHOR: zqq
**/
	require_once("../config.php");
	
	//new smarty
	$tpl = new Smarty();	
		
	//輸出頁面
	$tpl->display("create_course_unit.tpl");	
	
?>