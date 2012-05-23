<?php
/********************************************************************/
/* id: view_intra_group_score.php v1.0 2007/7/23 by hushpuppy Exp.  */
/* function: 合作學習 教師合作學習 評分介面 檢視組內互評結果			    */
/********************************************************************/

include "../../config.php";
require_once("../../session.php");
require_once("../lib/co_learn_lib.php");

checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

$Begin_course_cd = $_SESSION['begin_course_cd'];
//$Personal_id = $_SESSION['personal_id'];

$Homework_no = $_GET['homework_no'];
$Group_no = $_GET['group_no'];

$smtpl = new Smarty;
$smtpl->assign("group_no",$Group_no);

$sql_stu = "SELECT * FROM personal_basic pb, groups_member gm
	WHERE gm.begin_course_cd = '$Begin_course_cd' 
	and gm.homework_no = '$Homework_no'
	and gm.group_no = '$Group_no'
	and pb.personal_id = gm.student_id;
	";
//print $sql_stu;
$stu_id_array = array();
$stu_name_array = array();
$result = $DB_CONN->query($sql_stu);
if(PEAR::isError($result))	die($result->userinfo);
while( $stu_row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
	array_push($stu_id_array, $stu_row['personal_id']);
	array_push($stu_name_array, $stu_row['personal_name']);
}
//取得本組學生名單
$sql_stu = "SELECT * FROM personal_basic pb, groups_member gm
	WHERE gm.begin_course_cd = '$Begin_course_cd' 
	and gm.homework_no = '$Homework_no'
	and gm.group_no = '$Group_no'
	and pb.personal_id = gm.student_id;
	";
//print $sql_stu;
$result = $DB_CONN->query($sql_stu);
if(PEAR::isError($result))	die($result->userinfo);
while( $stu_row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
	//查得此學生評同組組員的分數
	$assess_id = $stu_row['personal_id'];
	$take_stu_score = array();
	for($i = 0 ; $i < sizeof($stu_id_array) ; $i++){
		$id = $stu_id_array[$i];
		$score_sql = "select take_student_score from take_student_score 
		where homework_no = '$Homework_no' 
		and assess_personal_id = '$assess_id' and take_student_id = '$id' and assess_type = '0'";
		$score = $DB_CONN->getOne($score_sql);
		if(PEAR::isError($score))	die($score->userinfo);
		array_push($take_stu_score,$score);
		
	}
	$tmp_array = array();
	for($i = 0 ; $i < count($take_stu_score) ; $i++){
		$tmp = array();
		$tmp['score'] = $take_stu_score[$i];
		$tmp['name'] = $stu_name_array[$i];
		array_push($tmp_array, $tmp);
	}
	$stu_row['array'] = $tmp_array;
	
	//查得此學生被組員評的分數
	$sql = "select * from take_student_score where homework_no = '$Homework_no'
		and group_no = '$Group_no' and take_student_id = '$assess_id' and assess_type = '0'";
	$score_result = $DB_CONN->query($sql);
	if(PEAR::isError($score_result))	die($score_result->userinfo);
	$sum = 0;
	$num = $score_result->numRows();
	while( $score_row = $score_result->fetchRow(DB_FETCHMODE_ASSOC) ){
		$sum += $score_row['take_student_score'];
	}
	if($num != 0)
		$avg = $sum / $num;
	
	$stu_row['average'] = $avg;
	$smtpl->append("data_list",$stu_row);
}

$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/teacher/view_intra_group_score.tpl");

?>
