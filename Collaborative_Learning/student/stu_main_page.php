<?php
/******************************************************/
/* id: main_page.php 2007/6/30 by hushpuppy Exp.   	  */
/* function: 學生合作學習主頁面	(專案選單)			  */
/******************************************************/
require_once("../../session.php");
include "../../config.php";
include "../lib/co_learn_lib.php";

checkMenu("/Collaborative_Learning/student/stu_main_page.php");

$Begin_course_cd = $_SESSION['begin_course_cd'];
$Personal_id = $_SESSION['personal_id'];

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;

$sql = "select * from project_data where begin_course_cd = '$Begin_course_cd';";
$result = $DB_CONN->query($sql);
if(PEAR::isError($result))	die($result->userinfo);

while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
	$Homework_no = $row['homework_no'];
	$sql = "select * from homework where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no';";
	$hw_result = $DB_CONN->query($sql);
	if(PEAR::isError($hw_result))	die($hw_result->userinfo);

	$data = $hw_result->fetchRow(DB_FETCHMODE_ASSOC);
	
	$row['homework_name'] = $data['homework_name'];
	$row['d_dueday'] = $data['d_dueday'];
	$row['percentage'] = $data['percentage'];
	$row['key'] = check_get_produce_key($Homework_no,"stu");
	$smtpl->append("project_list", $row);
}

$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/student/stu_main_page.tpl");

?>
