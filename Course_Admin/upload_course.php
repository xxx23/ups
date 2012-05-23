<?php
/***
FILE:   upload_course.php
DATE:   2007/1/22
AUTHOR: zqq

管理課程的主頁面
**/
	require_once("../config.php");
	
	//new smarty
	$tpl = new Smarty();	
	
	
	//輸出頁面
	$tpl->display("upload_course.tpl");	
	
?>