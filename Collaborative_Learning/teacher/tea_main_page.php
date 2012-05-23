<?php
/******************************************************/
/* id: main_page.php v1.0 2007/7/30 by hushpuppy Exp. */
/* function: 教師 合作學習選擇頁面 		      */
/******************************************************/
require_once("../../config.php");
require_once("../../session.php");
require_once("../lib/co_learn_lib.php");

ini_set('display_errors',1);
error_reporting(E_ALL);

checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

$Begin_course_cd = $_SESSION['begin_course_cd'];
$Personal_id = $_SESSION['personal_id'];

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
	$row['key'] = check_get_produce_key($Homework_no,"tea");
	$smtpl->append("project_list", $row);
}
//die('eee');
assignTemplate( $smtpl, "/collaborative_learning/teacher/tea_main_page.tpl");
?>
