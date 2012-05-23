<?php
/******************************************************/
/* id: sign_up.php 2007/5/24 by hushpuppy Exp.   	  */
/* function: 報名主頁面								  */
/******************************************************/

require_once("../../session.php");
include "../../config.php";

checkMenu("/Collaborative_Learning/student/stu_main_page.php");

$Homework_no = $_GET['homework_no'];
$pid = $_GET['id'];
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
	
	$sql = "select * from groups_member where student_id = '$Personal_id';";
	$num = $DB_CONN->query($sql);
	$row['num'] = $num->numRows();
	
	$smtpl->append("project_list", $row);
}
$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/student/sign_up.tpl");

?>
