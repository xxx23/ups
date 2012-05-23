<?php
	/*author: lunsrot
	 * date: 2007/07/31
	 * 說明：依不同的角色決定他們所看到的學習溫度計內容
	 */
	require_once("../config.php");
	require_once("../session.php");
	require_once("cou_info.php");

	global $HOME_PATH;
	$role = returnRole($_SESSION['role_cd']);
	$course_cd = $_SESSION['begin_course_cd'];
	$pid = $_SESSION['personal_id'];
	$tpl = new Smarty;
	$date = getCurTime();

	if($role == 1){					//出測驗的人
		viewExamine($tpl, $course_cd, $date);
		viewAssignment($tpl, $course_cd, $date);
		viewSurvey($tpl, $course_cd, $date);
		assignTemplate($tpl, "/course/view.tpl");
	}else if($role == 2){				//回答測驗的人
		responseExamine($tpl, $course_cd, $pid, $date);
		responseAssignment($tpl, $course_cd, $pid, $date);
		responseSurvey($tpl, $course_cd, $pid, $date);
		assignTemplate($tpl, "/course/response.tpl");
	}else{
		echo "你是誰";
	}

	//製作者才會用到的功能
	function viewExamine($tpl, $course_cd, $date){
		global $DB_CONN;
		$all = $DB_CONN->getOne("select count(*) from `test_course_setup` where begin_course_cd=$course_cd and '$date'>d_test_public;");
		$in = $DB_CONN->getOne("select count(*) from `test_course_setup` where begin_course_cd=$course_cd and '$date'>d_test_public and '$date'<d_test_end;");
		response($tpl, $all, $in, "exam");
	}

	function viewAssignment($tpl, $course_cd, $date){
		global $DB_CONN;
		$all = $DB_CONN->getOne("select count(*) from `homework` where begin_course_cd=$course_cd and public>1");
		$in = $DB_CONN->getOne("select count(*) from `homework` where begin_course_cd=$course_cd and '$date'<d_dueday and public>1;");
		response($tpl, $all, $in, "assign");
	}

	function viewSurvey($tpl, $course_cd, $date){
		global $DB_CONN;
		$all = $DB_CONN->getOne("select count(*) from `online_survey_setup` where survey_target=$course_cd and '$date'>d_survey_beg;");
		$in = $DB_CONN->getOne("select count(*) from `online_survey_setup` where survey_target=$course_cd and '$date'>d_survey_beg and '$date'<d_survey_end;");
		response($tpl, $all, $in, "survey");
	}

	//回答者才會用到的功能
	function responseExamine($tpl, $course_cd, $pid, $date){
		global $DB_CONN;
		$all = $DB_CONN->getOne("select count(*) from `test_course_setup` where begin_course_cd=$course_cd and '$date'>d_test_public;");
		$result = db_query("select test_no from `test_course_setup` where begin_course_cd=$course_cd and '$date'>d_test_public and '$date'<d_test_end;");
		$in = 0;
		while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
			if(isTest($pid, $course_cd, $row['test_no']) == false)
				$in++;
		}
		response($tpl, $all, $in, "exam");
	}

	function isTest($pid, $course_cd, $test_no){
		$tmp = db_query("select * from `test_course_ans` where begin_course_cd=$course_cd and test_no=$test_no and personal_id=$pid;");
		$num = $tmp->numRows();
		if($num != 0)
			return true;
		return false;
	}

	function responseAssignment($tpl, $course_cd, $pid, $date){
		global $DB_CONN;
		$all = $DB_CONN->getOne("select count(*) from `homework` where begin_course_cd=$course_cd and public>1;");
		$in = $DB_CONN->getOne("select count(*) from `handin_homework` where homework_no in (select homework_no from `homework` where begin_course_cd=$course_cd and '$date'<d_dueday) and personal_id=$pid and public>1 and work is null;");
		response($tpl, $all, $in, "assign");
	}

	function responseSurvey($tpl, $target, $pid, $date){
		global $DB_CONN;
		$all = $DB_CONN->getOne("select count(*) from `online_survey_setup` where survey_target=$target and '$date'>d_survey_beg;");
		$in = $DB_CONN->getOne("select count(*) from `survey_student` where survey_no in (select survey_no from `online_survey_setup` where survey_target=$target and '$date'>d_survey_beg and '$date'<d_survey_end) and personal_id=$pid and survey_flag is null;");
		response($tpl, $all, $in, "survey");
	}

	function response($tpl, $all, $in, $str){
		$percent = 0;
		if($all != 0)
			$percent = round(($all - $in) / $all * 100);
		$tpl->assign($str . "_indeadline", $in);
		$tpl->assign($str . "_outdeadline", $all - $in);
		$tpl->assign($str . "_percentage", $percent);
	}
?>
