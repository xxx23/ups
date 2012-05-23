<?php
/*修改者：lunsrot
 * 似乎沒有任何用處
 */
/***
FILE:   course_admin.php
DATE:   2006/12/11
AUTHOR: zqq

管理課程的主頁面
**/
	require_once("../config.php");
	//new smarty
	$tpl = new Smarty();			
	//輸出頁面
	$tpl->display("course_admin.tpl");	
	
?>
