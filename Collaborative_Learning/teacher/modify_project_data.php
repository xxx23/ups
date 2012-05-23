<?php
/*****************************************************************/
/* id: modify_project_data.php v1.0 2007/6/20 by hushpuppy Exp.  */
/* function: 合作學習 教師檢視與修改專案屬性介面						 */
/*****************************************************************/
include "../../config.php";
require_once("../../session.php");
require_once("../lib/co_learn_lib.php");

checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

$Homework_no_post = $_POST['homework_no'];
if(!isset($Homework_no_post)){
	$Homework_no = $_GET['homework_no'];	//由tea_project_list按下去
	$key = $_GET['key'];
	check_get_reverse_key($Homework_no, $key, "tea");
}

$Begin_course_cd = $_SESSION['begin_course_cd'];

$Project_goal = $_POST['project_goal'];
$Due_date = $_POST['sign_up_due_date'];

$Ref_doc = $_POST['ref_doc'];
//$Group_member = $_POST['group_member'];
$Group_member = $_POST['group_member'];

$Score_type = $_POST['score_type'];

$Comment = $_POST['comment'];
$Personal_rate = $_POST['person_rate'];

$Self_subject = $_POST['self_subject'];
if(isset($Group_member)){
	//取得修課人數
	$sql = "SELECT * FROM register_basic r, personal_basic p, take_course t 
		WHERE t.begin_course_cd = '$Begin_course_cd' 
		and t.personal_id = r.personal_id 
		and r.personal_id = p.personal_id 
		and r.role_cd = '3'";
	$res = $DB_CONN->query($sql);
	if(PEAR::isError($res))	die($res->getMessage());
	//分組組數為總學生數/每組人數
	//print $res->numRows();
	$Group_number = $res->numRows()/$Group_member;
	//print "group_number:".$Group_number;
}

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;

if(isset($Homework_no_post)){
if($Score_type != 2){
	$Personal_rate = '';
}
$sql = "update project_data 
		set 
		project_goal = '$Project_goal', 
		due_date = '$Due_date', 
		ref_doc = '$Ref_doc', 
		group_member = '$Group_member', 
		group_number = '$Group_number', 
		score_type = '$Score_type', 
		comment = '$Comment', 
		person_rate ='$Personal_rate',
		self_appointed = '$Self_subject' 
		where 
		begin_course_cd = '$Begin_course_cd' and 
		homework_no = '$Homework_no_post';";
$result = $DB_CONN->query($sql);
if(PEAR::isError($result))	die($result->userinfo);
$Homework_no = $Homework_no_post;

//$smtpl->assign("status","已完成修改!");
/*echo "<script>alert('已完成修改!');</script>";*/
echo "<span class=\"imp\">已完成修改!</span>";
}

$sql = "select * from project_data where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no';";
$result = $DB_CONN->query($sql);
if(PEAR::isError($result))	die($result->userinfo);

while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
	$slt = $row['score_type'];
	$subject_slt = $row['self_appointed'];
	$smtpl->append("project_data", $row);
}
$index = array(0,1,2);
$name = array('以組別計分','以個人計分','以組別與個人加權計分');
$smtpl->assign("score_type",$index);
$smtpl->assign("score_opt",$name);
$smtpl->assign("score_slt",$slt);

$subject_index = array(0,1);
$subject_name = array('不允許','允許');
$smtpl->assign("subject_type",$subject_index);
$smtpl->assign("subject_opt",$subject_name);
$smtpl->assign("subject_slt",$subject_slt);

$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/teacher/modify_project_data.tpl");

?>
