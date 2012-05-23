<?php
/***
FILE:   
DATE:   2006/12/15
AUTHOR: zqq


**/
	require_once("../config.php");
	require_once("./path.php");
	//new smarty
	$tpl = new Smarty();	
	//判斷是否要繼續填寫詳細資料

	switch($_GET['type']){
		case 0:$tpl->display("create_course_sucess.tpl");break;
		case 1:$tpl->display("create_course_profile.tpl");break;	
		case 2:$tpl->display("create_course_profile_specially.tpl");break;
	}
?>