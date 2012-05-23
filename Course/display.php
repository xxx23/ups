<?php
	/*author: lunsrot
	 * date: 2007/08/02
	 */
	require_once("../config.php");
	require_once("../session.php");
	require_once("cou_info.php");

	$role = returnRole($_SESSION['role_cd']);

	if($role != 1)
		exit(0);

	global $HOME_PATH;
	$option = $_GET['option'];
	$course_cd = $_SESSION['begin_course_cd'];
	$tpl = new Smarty;
	$date = getCurTime();

	switch($option){
		case "exam": exam($tpl, $course_cd, $date); break;
		case "assign": assign($tpl, $course_cd, $date); break;
		case "survey": survey($tpl, $course_cd, $date); break;
		default: break;
	}

	assignTemplate($tpl, "/course/display.tpl");

	function exam($tpl, $cd, $date){
		global $DB_CONN;
		$exam = db_query("select test_no, test_name from `test_course_setup` where begin_course_cd=$cd;");
		$all = $DB_CONN->getOne("select count(*) from `take_course` where begin_course_cd=$cd;");
		while($row = $exam->fetchRow(DB_FETCHMODE_ASSOC)){
			$tmp = array();
			$tmp['name'] = $row['test_name'];
			$in = $DB_CONN->getOne("select count(distinct personal_id) from `test_course_ans` where test_no=$row[test_no] and begin_course_cd=$cd;");
			$tmp['percentage'] = 0;
			if($all != 0)
				$tmp['percentage'] = round(($in/$all)*100);
			$tpl->append("datas", $tmp);
		}
		$tpl->assign("type", 1);
	}

	function assign($tpl, $cd, $date){
		global $DB_CONN;
		$ass = db_query("select homework_no, homework_name from `homework` where begin_course_cd=$cd;");
		while($row = $ass->fetchRow(DB_FETCHMODE_ASSOC)){
			$tmp = array();
			$tmp['name'] = $row['homework_name'];
			$all = $DB_CONN->getOne("select count(*) from `handin_homework` where homework_no=$row[homework_no];");
			$in = $DB_CONN->getOne("select count(*) from `handin_homework` where homework_no=$row[homework_no] and work is not null;");
			$tmp['percentage'] = 0;
			if($all != 0)
				$tmp['percentage'] = round(($in/$all)*100);
			$tpl->append("datas", $tmp);
		}
		$tpl->assign("type", 2);
	}

	function survey($tpl, $cd, $date){
		global $DB_CONN;
		$sur = db_query("select survey_name, survey_no from `online_survey_setup` where survey_target=$cd and '$date'>d_survey_beg order by d_survey_end desc;");
		$datas = array();
		while($row = $sur->fetchRow(DB_FETCHMODE_ASSOC)){
			$all = $DB_CONN->getOne("select sum(survey_flag)/count(*) from `survey_student` where survey_no=$row[survey_no];");
			$tmp = array();	
			$tmp['percentage'] = 0;
			if(is_numeric($all) && $all != 0)
				$tmp['percentage'] = round($all * 100);
			$tmp['name'] = $row['survey_name'];
			array_push($datas, $tmp);
		}
		$tpl->assign("datas", $datas);
		$tpl->assign("type", 3);
	}
?>
