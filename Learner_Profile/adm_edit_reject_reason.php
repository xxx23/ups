<?php
/***
FILE:   
DATE:   
AUTHOR: zqq
**/

	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	require_once($RELEATED_PATH . "library/common.php");
	//update_status ( "Æ[¬Ý¶}½Ò" );

	//new smarty	
	$tpl = new Smarty();

	$sql = "SELECT note FROM take_course WHERE begin_course_cd='".$_GET['begin_course_cd']."' and personal_id=".$_GET['personal_id'];
	
	$note_data = $DB_CONN->getOne($sql);
	
	$tpl->assign('begin_course_cd',$_GET['begin_course_cd']);
	$tpl->assign('personal_id',$_GET['personal_id']);
	$tpl->assign('note_data',$note_data);
	
	assignTemplate($tpl, "/learner_profile/adm_edit_reject_reason.tpl");
?>
