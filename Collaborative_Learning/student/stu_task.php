<?php
/******************************************************/
/* id: group_infos.php 2007/5/30 by hushpuppy Exp.    */
/* function: 合作學習 組員資料							  */
/******************************************************/

include "../../config.php";
require_once("../../session.php");
require_once("../lib/co_learn_lib.php");

checkMenu("/Collaborative_Learning/student/stu_main_page.php");

$Begin_course_cd = $_SESSION['begin_course_cd'];
$Personal_id = $_SESSION['personal_id'];

$Homework_no = $_POST['homework_no'];

if(empty($Homework_no)){
	$Homework_no = $_GET['homework_no'];
	$key = $_GET['key'];
	check_get_reverse_key($Homework_no, $key, "stu");
}

if(empty($Homework_no)){
	$Homework_no = $_GET['homework_no'];
	$key = $_GET['key'];
	//check_get_reverse_key($Homework_no, $key, "stu");
}

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;
$smtpl->assign("homework_no",$Homework_no);

//取得group_no
$sql = "select group_no from groups_member where homework_no = '$Homework_no' and student_id='$Personal_id'";
$Group_no = $DB_CONN->getOne($sql);
if(PEAR::isError($Group_no))	die($Group_no->userinfo);
$smtpl->assign("group_no",$Group_no);

//取得本組學生名單
$id_array = array();
$sql_stu = "SELECT * FROM personal_basic pb, groups_member gm
	WHERE gm.begin_course_cd = '$Begin_course_cd' 
	and gm.homework_no = '$Homework_no'
	and gm.group_no = '$Group_no'
	and pb.personal_id = gm.student_id;
	";
$result = $DB_CONN->query($sql_stu);
if(PEAR::isError($result))	die($result->userinfo);
while( $stu_row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
	array_push($id_array,$stu_row['personal_id']);
	$smtpl->append("data_list",$stu_row);
}
//新增工作分配
if(isset($_POST['group_no'])){
	$work_assign = $_POST['stu_id'];
	for($i = 0 ; $i < sizeof($id_array) ; $i++){
		$sql = "update groups_member set assign_work = '$work_assign[$i]' 
			where homework_no = '$Homework_no' 
			and group_no = '$Group_no'
			and student_id = '$id_array[$i]'";
		$result = $DB_CONN->query($sql);
		if(PEAR::isError($result))	die($result->userinfo);
	}
}

$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/student/stu_task.tpl");

?>
