<?php
/**********************************************************/
/* id: new_project.php v1.0 2007/6/4 by hushpuppy Exp.    */
/* function: 合作學習 教師新增合作學習介面				      */
/**********************************************************/

include "../../config.php";
require_once("../../session.php");
require_once("../lib/co_learn_lib.php");

checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

$Homework_no = $_POST['homework_no'];
if(!isset($Homework_no))
	$Homework_no = $_SESSION['homework_no'];
$Begin_course_cd = $_SESSION['begin_course_cd'];

$Project_goal = $_POST['project_goal'];  //從new_project_content.php post過來的
$Due_date = $_POST['sign_up_due_date'];
$Ref_doc = $_POST['ref_doc'];
//$Group_member = $_POST['group_member'];
$Group_member = $_POST['group_member'];

$Score_type = $_POST['score_type'];
$Comment = $_POST['comment'];
$Personal_rate = $_POST['person_rate'];
$Modify = $_POST['modify'];
$Self_subject = $_POST['subject_type'];

$key = check_get_produce_key($Homework_no,"tea");

$Finish_option = $_POST['finish_option'];

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

//取得修課人數
$sql = "SELECT * FROM register_basic r, personal_basic p, take_course t 
		WHERE t.begin_course_cd = '$Begin_course_cd' 
		and t.personal_id = r.personal_id 
		and r.personal_id = p.personal_id 
		and r.role_cd = '3'";
$res = $DB_CONN->query($sql);
if(PEAR::isError($res))	die($res->getMessage());
//分組組數為總學生數/每組人數
//modify by lunsrot at 2007/07/09
if($Group_number == 0 || !is_numeric($Group_number))
  $Group_number = 1;
if(!empty($Group_member))
	$Group_number = $res->numRows()/$Group_member;
//print $sql;
//print $Group_member;
if(isset($Project_goal) && !isset($Modify)){
	$sql = "insert into project_data 
		(begin_course_cd, homework_no, project_goal, due_date, ref_doc, 
		group_member, group_number, score_type, comment, person_rate, self_appointed) 
		values
		('$Begin_course_cd', '$Homework_no', '$Project_goal', '$Due_date', '$Ref_doc',
		'$Group_member', '$Group_number', '$Score_type', '$Comment', '$Personal_rate', '$Self_subject');";
//print $sql;
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	
	if($Finish_option == 'finish')
		header("Location: ./tea_co_learn.php?homework_no=$Homework_no&key=$key");
	else if($Finish_option == 'continue')
		header("Location: ./new_project_content.php?homework_no=$Homework_no&key=$key");
	
}
else if(isset($Project_goal) && isset($Modify)){
	$sql = "update project_data set  
		project_goal = '$Project_goal', 
		due_date = '$Due_date', ref_doc = '$Ref_doc', group_member = '$Group_member', group_number = '$Group_number',
		score_type = '$Score_type', comment = '$Comment', person_rate = '$Personal_rate' ,self_appointed = '$Self_subject'
		where homework_no = $Homework_no; ";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	
	if($Finish_option == 'finish')
		header("Location: ./tea_co_learn.php?homework_no=$Homework_no&key=$key");
	else if($Finish_option == 'continue')
		header("Location: ./new_project_content.php?homework_no=$Homework_no&key=$key");
}
else{
  $smtpl = new Smarty;
  $smtpl->assign("tpl_path",$tpl_path);
  assignTemplate( $smtpl, "/collaborative_learning/teacher/new_project.tpl");
}
?>
