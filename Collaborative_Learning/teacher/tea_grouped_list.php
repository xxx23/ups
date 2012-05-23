<?php
/******************************************************************/
/* id: tea_grouped_list.php v1.0 2007/7/7 by hushpuppy Exp.       */
/* function: 教師合作學習 檢視已分組名單				      		  */
/******************************************************************/

include "../../config.php";
require_once("../../session.php");
require_once("../lib/co_learn_lib.php");
require_once("../lib/grouping_lib.php");
include("../../Discuss_Area/library.php");

checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

global $DB_CONN, $smtpl;

$Begin_course_cd = $_SESSION['begin_course_cd'];
$Homework_no = $_POST['homework_no'];

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;

if(empty($Homework_no)){
	$Homework_no = $_GET['homework_no'];
	$key = $_GET['key'];
	check_get_reverse_key($Homework_no, $key, "tea");
}

//assign homewrok name
$sql = "select homework_name from homework where homework_no = '$Homework_no';";
$Homework_name = $DB_CONN->getOne($sql);
if(PEAR::isError($Homework_name))	die($Homework_name);
$smtpl->assign("homework_name",$Homework_name);

$Group_no = $_POST['group_no'];
//print "group_no:".$Group_no;
//刪除一人
$tmp_str = "del_stu_".$Group_no;
$del = $_POST[$tmp_str];
if($del){
	$Student_array = $_POST['student'];
//	print_r($Student_id);
	delete_student($Homework_no, $Student_array, $Group_no);
}
/*
//刪除整組
if(isset($_POST['del_group'])){
	delete_student($Homework_no, $Student_array, $Group_no);
}*/

//新增組員
$tmp_str = "new_stu_".$Group_no;
$New = $_POST[$tmp_str];
if($New){
	$New_member = $_POST['new_member'];
	insert_member($Homework_no, $Group_no ,$New_member);
}
//print $Group_no;

//顯示分組資訊
show_group_infos($Homework_no, $Begin_course_cd, $Group_no);

$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/teacher/tea_grouped_list.tpl");


?>
