<?php
/*author: lunsrot
 * date: 2007/05/01
 */
require_once("../config.php");
require_once("../session.php");
require_once("sur_info.php");

$option = $_POST['option'];

switch($option){
case "fillout": fillout(); break;
default: view(); break;
}

function fillout(){
	global $DB_CONN;
	$survey_no = $_POST['survey_no'];
	$pid = $_SESSION['personal_id'];
	$date = getCurTime();
	//判斷是否記名
	$is_register = $DB_CONN->getOne("select is_register from online_survey_setup where survey_no=$survey_no");	  

	//update `survey_student`中的survey_flag和mtime
	db_query("update `survey_student` set mtime='$date', survey_flag=1 where survey_no=$survey_no and personal_id=$pid;");
	//insert into `online_survey`
	db_query("insert into `online_survey` (personal_id, survey_no) values ($pid, $survey_no);");
	$response = $DB_CONN->getOne("select response_no from `online_survey` where personal_id=$pid and survey_no=$survey_no;");
	//不記名把personal_id變為-1
	if($is_register == 0)
	  	db_query("update online_survey set personal_id=-1 where personal_id='{$pid}' and survey_no='{$survey_no}';");
	$result = db_query("select * from `online_survey_content` where survey_no=$survey_no and block_id=0;");
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		$res2 = db_query("select survey_cd, survey_type, is_multiple from `online_survey_content` where survey_no=$survey_no and block_id=$row[survey_cd];");
		while(($row2 = $res2->fetchRow(DB_FETCHMODE_ASSOC)) != false){
			$answer = $_POST['survey_' . $row2['survey_cd']];
			if($row['survey_type'] == 2)
				$grade = 0;
			else if($row['is_multiple'] == 0)
				$grade = grade1($survey_no, $row2['survey_cd'], $answer);
			else{
				$grade = grade2($survey_no, $row2['survey_cd'], $answer);
				$answer = takeAnswer($answer);
			}
			//insert into `online_survey_response`
			db_query("insert into `online_survey_response` (response_no, survey_cd, response, grade) values ($response, $row2[survey_cd], '$answer', $grade);");
		}
	}
	header("location: ./stu_view.php");
}

function view(){
	global $DB_CONN;
	$survey_no = $_GET['survey_no'];
	$tpl = new Smarty;

	$tpl->assign("survey_name", $DB_CONN->getOne("select survey_name from `online_survey_setup` where survey_no=$survey_no;"));
	$groups = all_questions($survey_no);
	$tpl->assign("groups", $groups);
	$tpl->assign("survey_no", $survey_no);
	$tpl->assign("fillout", 1);
	$tpl->assign("editable", 0);

	assignTemplate($tpl, "/survey/fillout_survey.tpl");
}

//單選題
function grade1($survey_no, $survey_cd, $answer){
	global $DB_CONN;
	$str = $DB_CONN->getOne("select selection_grade from `online_survey_content` where survey_no=$survey_no and survey_cd=$survey_cd");
	$grade = substr($str, ($answer - 1)*2, 2) + 0;
	return $grade;
}

//複選題
function grade2($survey_no, $survey_cd, $answer){
	global $DB_CONN;
	$str = $DB_CONN->getOne("select selection_grade from `online_survey_content` where survey_no=$survey_no and survey_cd=$survey_cd");
	$num = count($answer);
	$grade = 0;
	for($i = 0 ; $i < $num ; $i++)
		$grade += (substr($str, ($answer[$i] - 1)*2, 2) + 0);
	return $grade;
}

//將複選題的答案從array轉成string
function takeAnswer($tmp){
	$num = count($tmp);
	$answer = "";
	for($i = 0 ; $i < $num ; $i++)
		$answer .= ($tmp[$i] . ";");
	return $answer;
}
?>
