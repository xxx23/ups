<?php
/****************************************************/
/* id: stu_usage.php v1.0 2007/6/30 by hushpuppy Exp.   */
/* function: 學生合作學習進入後的首頁       			*/
/****************************************************/
require_once("../../session.php");
include "../../config.php";
require_once("../lib/co_learn_lib.php");

checkMenu("/Collaborative_Learning/student/stu_main_page.php");

$Homework_no = $_GET['homework_no'];
$Begin_course_cd = $_SESSION['begin_course_cd'];

$key = check_get_produce_key($Homework_no,"stu");

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;

$sql = "select * from groups_member where student_id = '$Personal_id';";
$num = $DB_CONN->query($sql);
$total = $num->numRows();

$sql = "select * from homework where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no';";
$hw_result = $DB_CONN->query($sql);
if(PEAR::isError($hw_result))	die($hw_result->userinfo);
$data = $hw_result->fetchRow(DB_FETCHMODE_ASSOC);

$smtpl->assign("homework_no",$Homework_no);
$smtpl->assign("homework_name",$data['homework_name']);
$smtpl->assign("due_day",$data['d_dueday']);
$smtpl->assign("percentage",$data['percentage']);
$smtpl->assign("num",$total);
$smtpl->assign("key",$key);

$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/student/stu_usage.tpl");

?>
