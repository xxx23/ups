<?php
/********************************************************/
/* id: tea_score.php v1.0 2007/6/5 by hushpuppy Exp.    */
/* function: 合作學習 教師合作學習 評分介面			        */
/********************************************************/

include('../../config.php');
include('../../session.php');
checkMenu('/Collaborative_Learning/teacher/tea_main_page.php');
include('../lib/co_learn_lib.php');

$Begin_course_cd = $_SESSION['begin_course_cd'];
$Homework_no = $_POST['homework_no'];
$Teacher_id = $_SESSION['personal_id'];

if(empty($Homework_no)){
	$Homework_no = $_GET['homework_no'];
	$key = $_GET['key'];
	check_get_reverse_key($Homework_no, $key, "tea");
}

//取得更新成績
$group_no = $_POST['group_no'];
$str = "stu_score_".$group_no;

$stu_score = $_POST[$str];
if( !empty($stu_score)){
	$stu_id = $_POST['stu_id'];	//學生id array
	update_score($stu_id, $stu_score, $Homework_no, $group_no);	
}


$smtpl = new Smarty;
$smtpl->assign("homework_no",$Homework_no);
$smtpl->assign("WEBROOT", $WEBROOT);

//查詢組別
	$sql = "select * from info_groups where 
		begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no' order by group_no";
	$res = db_query($sql);
	
	//print $sql;
	while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
		$Group_no = $row['group_no'];
		//取得本組學生名單
		$sql_stu = "SELECT * FROM personal_basic pb, groups_member gm, register_basic rb
			WHERE gm.begin_course_cd = '$Begin_course_cd' 
			and gm.group_no = '$Group_no'
			and gm.homework_no = '$Homework_no'
			and pb.personal_id = rb.personal_id
			and pb.personal_id = gm.student_id;
			";
		//print $sql_stu;
		$result = db_query($sql_stu);

		$row['stu_array'] = array();
		while( $stu_row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
			//assign分數
			$id = $stu_row['personal_id'];
			$score_sql = "select take_student_score from take_student_score 
				where homework_no = '$Homework_no' and take_student_id = '$id' 
				and assess_personal_id = '$Teacher_id'";
			//print $score_sql;
			$score = db_getOne($score_sql);
			$stu_row['score'] = $score;
			array_push($row['stu_array'], $stu_row);
		}

		//取得project_content
		$project_no = $row['project_no'];
		$content_sql = "select project_content from projectwork
			where homework_no = '$Homework_no' and project_no = '$project_no'";
		//print $content_sql;
		$project_content = db_getOne($content_sql);
		
		$row['project_content'] = $project_content;
		$smtpl->append("group_list",$row);
	}

	assignTemplate($smtpl, '/collaborative_learning/teacher/tea_person_score.tpl');

//輸入成績, input:覺生編號陣列與對應成績陣列
function update_score($stu_id, $stu_score, $Homework_no, $Group_no)
{
	global $DB_CONN;
	$Teacher_id = $_SESSION['personal_id'];
	$Begin_course_cd = $_SESSION['begin_course_cd'];
	for($i = 0 ; $i < sizeof($stu_id) ; $i++){
		$id = $stu_id[$i];
		$score = $stu_score[$i];
		//print $id.";".$score." ";
		if(stu_is_scored($id, $Teacher_id, $Homework_no) == -1){
			$sql = "insert into take_student_score 
				(begin_course_cd, homework_no, group_no, assess_personal_id, 
				take_student_id, take_student_score, assess_type)
				values
				('$Begin_course_cd', '$Homework_no', '$Group_no', '$Teacher_id', '$id', '$score', '1')";
		}
		else{
			$sql = "update take_student_score 
				set take_student_score = '$score'
				where homework_no = '$Homework_no' and assess_personal_id = '$Teacher_id'
				and take_student_id = '$id'";
		}
		//print $sql;
		$result = db_query($sql);
		
	}
	echo "<script>alert(\"已更新第'$Group_no'組成績!\");</script>";
}

//檢查此學生是否已評分，若有則傳回分數
function stu_is_scored($stu_id, $tea_id, $Homework_no )
{

	$sql = "select take_student_score from take_student_score 
		where homework_no = '$Homework_no' 
		and take_student_id = '$stu_id'
		and assess_personal_id = '$tea_id'";
	$result = db_getOne($sql);

	//print $sql;
	if(!is_numeric($result))
		return -1;
	else
		return $result;
}
?>