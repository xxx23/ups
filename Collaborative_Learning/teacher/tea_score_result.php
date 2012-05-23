<?php
/********************************************************/
/* id: tea_score.php v1.0 2007/6/5 by hushpuppy Exp.    */
/* function: 合作學習 教師合作學習 評分介面			        */
/********************************************************/

include "../../config.php";
include("../../session.php");
checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");
include("../lib/co_learn_lib.php");



$Begin_course_cd = $_SESSION['begin_course_cd'];
$Homework_no = $_POST['homework_no'];

if(empty($Homework_no)){
	$Homework_no = $_GET['homework_no'];
	$key = $_GET['key'];
	check_get_reverse_key($Homework_no, $key, "tea");
}
/*
if($_POST['update_submit'] == 'true'){
	$stu_id = $_POST['stu_id'];
	print_r($stu_id);
}*/



$smtpl = new Smarty;
/*
//取得此homework_no的number_id
$sql = "select number_id from course_percentage 
		where percentage = '$Homework_no' and begin_course_cd = '$Begin_course_cd'";
//print $sql;
$number_id = $DB_CONN->getOne($sql);
if(PEAR::isError($number_id))	die($number_id->getMessage());*/
$percentage_num = $Homework_no;
//print $sql;
//取得本合作學習的評分方式
$sql = "select * from project_data where begin_course_cd = '$Begin_course_cd'
	and homework_no = '$Homework_no'";
$result = db_query($sql);


$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
$Score_type = $row['score_type'];
if($Score_type == 2)
	$Person_rate = $row['person_rate'];

$sql = "SELECT * FROM register_basic rb, personal_basic pb, take_course tc
		WHERE tc.begin_course_cd = '$Begin_course_cd' 
		and tc.personal_id = rb.personal_id 
		and rb.personal_id = pb.personal_id
		and rb.role_cd = '3'";
$res = db_query($sql);

	
while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
	//核准與身份確認
	if($row['allow_course'] )
	    $row['allow'] = "核准";
    else
   	    $row['allow'] = "不核准";
    if($row['status_student'] == 0)
       	$row['status'] = "旁聽生";
   	else
        $row['status'] = "正修生";
	
	$id = $row['personal_id'];
	update_score_result($row['personal_id'], $percentage_num, $Score_type, $Person_rate, $Homework_no);
	
	//取得該生成績
	$grade_sql = "select concent_grade from course_concent_grade where percentage_num = '$percentage_num'
		and begin_course_cd = '$Begin_course_cd' and student_id = '$id'";
	$score = db_getOne($grade_sql);
	
	//print $grade_sql;	
	$row['score'] = $score;
	$smtpl->append("name_list",$row);
}


$smtpl->assign("homework_no",$Homework_no);
assignTemplate( $smtpl, "/collaborative_learning/teacher/tea_score_result.tpl");

//更新此作業number_id的學生成績
function update_score_result($stu_id, $percentage_num, $Score_type, $Person_rate, $Homework_no)
{
	global $DB_CONN;
	$Begin_course_cd = $_SESSION['begin_course_cd'];
	
	//取得此學生的組別
	$sql = "select group_no from groups_member where homework_no = '$Homework_no' and student_id = '$stu_id'";
	$Group_no = db_getOne($sql);

		
	//取得此組別的分數
	$sql = "select take_group_score from take_groups_score where 
		homework_no = '$Homework_no' and take_group_no = '$Group_no' and assess_type = '1'";
	$Group_score = db_getOne($sql);

	
	//取得個人分數
	$sql = "select take_student_score from take_student_score where homework_no = '$Homework_no'
		and take_student_id = '$stu_id' and assess_type = '1'";
	$Personal_score = db_getOne($sql);

	
	//以組別計分
	if($Score_type == 0){
		$final_score = $Group_score;
	}
	//以個人計分
	else if($Score_type == 1){
		$final_score = $Personal_score;
	}
	//以組別與個人加權計分
	else{
		$person_rate = $Person_rate/100;
		$final_score = $Personal_score * $person_rate + $Group_score * (1 - $person_rate);
	}
	//更新成績table
	$sql = "update course_concent_grade set concent_grade = '$final_score' 
	  where begin_course_cd = '$Begin_course_cd' and percentage_num = '$percentage_num' and student_id = '$stu_id'";
	//print $sql;
	$result = db_query($sql);

}
?>