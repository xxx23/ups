<?php
/*****************************************************************/
/* id: inter_group_score.php v1.0 2007/6/20 by hushpuppy Exp.    */
/* function: 合作學習學生組間互評介面							     */
/*****************************************************************/
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

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;
$smtpl->assign("homework_no",$Homework_no);

//查詢組別
$sql = "select * from info_groups where 
	begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no' order by group_no";
$res = $DB_CONN->query($sql);
if(PEAR::isError($res))	die($res->getMessage());
$group_array = array();
while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
	$Group_no = $row['group_no'];
	array_push($group_array, $Group_no);
	
	//查詢本組受評分數
	$score_sql = "select take_group_score from take_groups_score 
		where homework_no = '$Homework_no' and take_group_no = '$Group_no' 
		and assess_personal_id = '$Personal_id'";
	$score = $DB_CONN->getOne($score_sql);
	if(PEAR::isError($score))	die($score->getMessage());
	
	$row['score'] = $score;
	$smtpl->append("group_list",$row);
}
if(isset($_POST['evaluate'])){
  //查詢本人是哪一組
  $sql = "select group_no from groups_member where student_id = '$Personal_id' and begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no'";
  $Group_no = $DB_CONN->getOne($sql);
  if(PEAR::isError($Group_no))       die($Group_no->userinfo);

  $score_array = $_POST['group_score'];
	for($i = 0 ; $i < sizeof($group_array) ; $i++){
		$option = check_if_scored($group_array[$i], $Personal_id, $Homework_no);
		if($option == -1)
			$sql = "insert into take_groups_score
				(begin_course_cd, homework_no, group_no, assess_personal_id, take_group_no, take_group_score, assess_type)
				values
				('$Begin_course_cd', '$Homework_no', '$Group_no', '$Personal_id', '$group_array[$i]', '$score_array[$i]', '0')";
		else
			$sql = "update take_groups_score set take_group_score = '$score_array[$i]'
				where homework_no = '$Homework_no' and take_group_no = '$group_array[$i]' 
				and assess_personal_id = '$Personal_id'";
		$res = $DB_CONN->query($sql);
		if(PEAR::isError($res))	die($res->getMessage());
	}
}

$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/student/inter_group_score.tpl");

//檢查此組是否被此id評分過
function check_if_scored($group_no, $id, $Homework_no)
{
	global $DB_CONN;
	$sql = "select take_group_score from take_groups_score where homework_no = '$Homework_no' 
		and assess_personal_id = '$id' and take_group_no = '$group_no'";
	$res = $DB_CONN->getOne($sql);
	if(PEAR::isError($res))	die($res->getMessage());
	
	if(!is_numeric($res))
		return -1;
	else
		return 1;
}
?>

