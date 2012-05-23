<?php
/*author: lunsrot
 * date: 2007/05/01
 */
require_once("../config.php");
require_once("../session.php");
require_once("OnlineSurvey.class.php");

include "library.php";
//require ("../Course/s_course.php");

$course_cd = $_SESSION['begin_course_cd'];
$pid = $_SESSION['personal_id'];
$tpl = new Smarty;
$date = getCurTime();
$tmp = gettimeofday();

$result = db_query("select A.survey_no, A.survey_name, A.d_survey_beg, A.d_survey_public, A.d_survey_end, A.is_register, B.survey_flag from `online_survey_setup` A, `survey_student` B where A.survey_target=$course_cd and B.personal_id=$pid and A.survey_no=B.survey_no and A.d_survey_beg!='' order by A.d_survey_beg;");
while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
	if(timecmp($tmp['sec'], strtotime($row['d_survey_end'])) == 1)
		$row['due'] = 1;
	$tpl->append("surveys",  $row);
}

assignTemplate($tpl, "/survey/stu_view.tpl");
?>
