<?php
/********************************************************/
/* id: tea_score.php v1.0 2007/6/5 by hushpuppy Exp.    */
/* function: 合作學習 教師合作學習 評分介面			        */
/********************************************************/

include "../../config.php";
require_once("../../session.php");
require_once("../lib/co_learn_lib.php");

checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

$Begin_course_cd = $_SESSION['begin_course_cd'];
$Homework_no = $_POST['homework_no'];
$Personal_id = $_SESSION['personal_id'];

if(empty($Homework_no)){
	$Homework_no = $_GET['homework_no'];
	$key = $_GET['key'];
	check_get_reverse_key($Homework_no, $key, "tea");
}

$smtpl = new Smarty;
$smtpl->assign("homework_no",$Homework_no);

//更新成績
if($_POST['update'] == 'true'){
	$Group_score_array = $_POST['group_score'];
	update_group_score($Group_score_array, $Homework_no, $Personal_id);
}

//查詢組別
$sql = "select * from info_groups where 
	begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no' order by group_no";
$res = db_query($sql);

//print $sql;
$Group_no_array = array();
while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
	$Group_no = $row['group_no'];
	//查詢此組分數
	$score_sql = "select take_group_score from take_groups_score where homework_no = '$Homework_no'
		and assess_personal_id = '$Personal_id' and take_group_no = '$Group_no' and assess_type = '1'";
	$score = $DB_CONN->getOne($score_sql);
	if(PEAR::isError($score))	die($score->getMessage());
	$row['group_score'] = $score;
	
	array_push($Group_no_array, $Group_no);
	
	$smtpl->append("group_list",$row);
}
	//取得下載檔案path
	if( $COURSE_FILE_PATH[strlen($COURSE_FILE_PATH)-1] == '/');
	else
        $COURSE_FILE_PATH = $COURSE_FILE_PATH.'/';
	$path = $COURSE_FILE_PATH.$Begin_course_cd."/homework/".$Homework_no;

$smtpl->assign("WEBROOT", $WEBROOT);
assignTemplate($smtpl, "/collaborative_learning/teacher/tea_group_score.tpl");

//檢察此組別是否已被此老師評分過
function is_group_scored($Group_no, $Homework_no, $Personal_id)
{
	global $DB_CONN;
	$sql = "select take_group_score from take_groups_score where homework_no = '$Homework_no'
		and assess_personal_id = '$Personal_id' and take_group_no = '$Group_no'";
	$res = db_getOne($sql);

	//print $sql;
	if(!is_numeric($res))
		return -1;
	else
		return 1;
}

//照順序更新成績, input: 組別成績
function update_group_score($Group_score_array, $Homework_no, $Personal_id)
{
	$Begin_course_cd = $_SESSION['begin_course_cd'];
	//查詢組別
	$sql = "select * from info_groups where 
		begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no' order by group_no";
	$res = db_query($sql);
	$count = 0;
	while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
		$group_score = $Group_score_array[$count];
		$group_no = $row['group_no']; 
		if(is_group_scored($group_no, $Homework_no, $Personal_id) == -1)
			$sql = "insert into take_groups_score
				(begin_course_cd, homework_no, group_no, assess_personal_id, take_group_no, take_group_score, assess_type)
				values
				('$Begin_course_cd', '$Homework_no', '$group_no', '$Personal_id', '$group_no', '$group_score', '1')";
		else
			$sql = "update take_groups_score set
				take_group_score = '$group_score' where
				homework_no = '$Homework_no' and assess_personal_id = '$Personal_id' 
				and take_group_no = '$group_no'";
		db_query($sql);
		$count++;
	}
}
?>
