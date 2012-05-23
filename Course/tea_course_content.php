<?php
/***
name : tea_course_content.php
date : 2007 4/17
function : 教師查看課程內容
***/
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	//new smarty	
	$tpl = new Smarty();
	assignTemplate($tpl, "tea_course_content.tpl");
	
//--------function area-------------
	
?>
