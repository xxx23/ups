<?php
/******************************************************************/
/* id: tea_group_mgt.php v1.0 2007/7/7 by hushpuppy Exp.          */
/* function: 教師合作學習 分組介面				      		  		  */
/******************************************************************/

include "../../config.php";
require_once("../../session.php");
require_once("../lib/co_learn_lib.php");
require_once("../lib/grouping_lib.php");
include('../../Discuss_Area/library.php'); 

checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

global $DB_CONN, $smtpl;

$Begin_course_cd = $_SESSION['begin_course_cd'];
$Homework_no = $_POST['homework_no'];

if(empty($Homework_no)){
	$Homework_no = $_GET['homework_no'];
	$key = $_GET['key'];
	check_get_reverse_key($Homework_no, $key, "tea");
}

$Auto = $_POST['auto_grouping'];
$delete_all_group = $_POST['delete_all_group'];

//取得分組人數與組數
$sql = "select * from project_data where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no'";
$res = $DB_CONN->query($sql);
if(PEAR::isError($res))	die($res->userinfo);
$row = $res->fetchRow(DB_FETCHMODE_ASSOC);	
$Group_member = $row['group_member'];	//分組人數
$Group_number = $row['group_number'];	//分組組數

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;
$smtpl->assign("group_member",$Group_member);
$smtpl->assign("homework_no",$Homework_no);

if(!empty($Auto)){
	$res = auto_grouping($Homework_no, $Group_member, $Group_number);
	if($res == 0)
		echo "<script>alert(\"本作業所有學生皆已自動分組完畢!\");</script>";
	else
		echo "<script>alert(\"本作業已經自動分組完畢!\");</script>";
}

if(!empty($delete_all_group)){
	delete_all_group($Homework_no);
}

//新增組別
$New = $_POST['submit_form'];
$Project_no = $_POST['project_name'];
if($New){
	$New_id = $_POST['stu_id'];
	//print_r($New_id);
	$New_id = to_personal_id_array($New_id);

	$res = check_if_exists($New_id, $Begin_course_cd, $Homework_no);
	//print_r($New_id);
	$New_array = array();
	array_push($New_array,$New_id);
	if($res == 1)
		insert2DB($New_array, $Group_member, $Group_number, $Homework_no, $Project_no, '');
}

//顯示手動分組表單資訊
//print $Group_member;
$smtpl->assign("count",$Group_member);
for($i = 0 ; $i < $Group_member ; $i++){
	$smtpl->append("text","<input type=\"text\" name=\"stu_id[]\" size=\"10\" value=\"\">");
}

$sql = "select * from projectwork where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no';";
$res = $DB_CONN->query($sql);
if(PEAR::isError($res))	die($res->userinfo);
$project_array = array();
$project_no = array();
while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
  //print $row['project_content'];
  if($row['groupno_topic'] != '0'){
    $str = "  (第".$row['groupno_topic']."組自訂題目)";
    array_push($project_array, $row['project_content'].$str);
  }
  else
    array_push($project_array, $row['project_content']);
	array_push($project_no, $row['project_no']);
}
//print_r($project_array);
$smtpl->assign("project",$project_array);
$smtpl->assign("project_no",$project_no);
$smtpl->assign("homework_no",$Homework_no);

$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/teacher/tea_group_mgt.tpl");


?>
