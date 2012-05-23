<?php
/*****************************************************************/
/* id: intra_group_score.php v1.0 2007/6/20 by hushpuppy Exp.    */
/* function: 合作學習學生組內互評介面							     */
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

//取得group_no
$sql = "select group_no from groups_member where homework_no = '$Homework_no' and student_id='$Personal_id'";
$Group_no = $DB_CONN->getOne($sql);
if(PEAR::isError($Group_no))	die($Group_no->userinfo);
$smtpl->assign("group_no",$Group_no);

//取得本組學生名單
$sql_stu = "SELECT * FROM personal_basic pb, groups_member gm
	WHERE gm.begin_course_cd = '$Begin_course_cd' 
	and gm.group_no = '$Group_no'
	and gm.homework_no = '$Homework_no'
	and pb.personal_id = gm.student_id;
	";
//print $sql_stu;
$stu_id_array = array();
$result = $DB_CONN->query($sql_stu);
if(PEAR::isError($result))	die($result->userinfo);
while( $stu_row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
	//print $stu_row['personal_name'];
	//print "test".$stu_row.personal_id;
	//print_r($stu_row);
	array_push($stu_id_array,$stu_row['personal_id']);
	
	//查得此學生被同組組員評分的分數
	$take_id = $stu_row['personal_id'];
	$score_sql = "select take_student_score from take_student_score 
		where homework_no = '$Homework_no' 
		and assess_personal_id = '$Personal_id' and take_student_id = '$take_id'";
	//print $score_sql;
	$score = $DB_CONN->getOne($score_sql);
	if(PEAR::isError($score))	die($score->userinfo);
	
	$stu_row['score'] = $score;
	$smtpl->append("data_list",$stu_row);
}

if(isset($_POST['evaluate'])){
	$score_array = $_POST['stu_score'];
	//print_r($score_array);
	for($i = 0 ; $i < sizeof($stu_id_array) ; $i++){
		$option = check_if_scored($stu_id_array[$i], $Personal_id, $Homework_no);
		if($option == 1)
			$sql = "update take_student_score set take_student_score = '$score_array[$i]' 
				where homework_no = $Homework_no and assess_personal_id = '$Personal_id'
				and take_student_id = '$stu_id_array[$i]'";
		else
			$sql = "insert into take_student_score 
				(begin_course_cd, homework_no, group_no, assess_personal_id, take_student_id, 
				take_student_score, assess_type) 
				values 
				('$Begin_course_cd', '$Homework_no', '$Group_no', '$Personal_id', '$stu_id_array[$i]',
				'$score_array[$i]', '0');";
		//print $sql;
		$result = $DB_CONN->query($sql);
		if(PEAR::isError($result))	die($result->userinfo);
	}
}
$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/student/intra_group_score.tpl");

//檢查此受評學生是否為第一次被此id這個人評分
function check_if_scored($take_id, $assess_id, $Homework_no)
{
	global $DB_CONN;
	$Begin_course_cd = $_SESSION['begin_course_cd'];
	$sql = "select take_student_score from take_student_score 
		where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no'
		and take_student_id = '$take_id' and assess_personal_id = '$assess_id'";
	$result = $DB_CONN->getOne($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	if(empty($result))
		return 0;
	else
		return 1;
}
?>
