<?php
	/*author: lunsrot
	 * date: 2007/08/23
	 */
	require_once("../config.php");
	require_once("../session.php");

	require_once("../library/delete_data.php");

	//library
	//列出該教師的所有助教
	function fetch_all_assist(){
		return "select p.personal_id, p.personal_name, p.email, p.tel, r.login_id, r.pass from `personal_basic` p, `register_basic` r where r.personal_id in (select if_aid_teacher_cd from `teach_aid` where teacher_cd=$_SESSION[personal_id]) and p.personal_id=r.personal_id;"; 
	}

	//library
	function remove_delete_list(){
		global $PERSONAL_PATH;
		$file = $PERSONAL_PATH . $_SESSION['personal_id'] . "/delete_student_list.xml";
		if(file_exists($file))
			unlink($file);
	}

	//library
	function remove_student_from_course($course_cd, $p_id){
		//學習追踪
		db_query("DELETE FROM `student_learning` WHERE begin_course_cd=$course_cd AND personal_id=$p_id;");
		//使用紀錄
		db_query("DELETE FROM `event` WHERE begin_course_cd=$course_cd AND personal_id=$p_id;");
		db_query("DELETE FROM `event_statistics` WHERE begin_course_cd=$course_cd AND personal_id=$p_id;");
		//電子報
		db_query("DELETE FROM `person_epaper` WHERE begin_course_cd=$course_cd AND personal_id=$p_id;");
		//問卷
		db_query("DELETE FROM `online_survey_response` WHERE response_no IN
			(SELECT response_no FROM `online_survey` WHERE personal_id=$p_id AND survey_no IN
				(SELECT survey_no FROM `online_survey_setup` WHERE survey_target=$course_cd)
		);");
		db_query("DELETE FROM `online_survey` WHERE personal_id=$p_id AND survey_no IN
			(SELECT survey_no FROM `online_survey_setup` WHERE survey_target=$course_cd);");
		db_query("DELETE FROM `survey_student` WHERE personal_id=$p_id AND survey_no IN
			(SELECT survey_no FROM `online_survey_setup` WHERE survey_target=$course_cd);");
		//作業、測驗、點名
		db_query("DELETE FROM `handin_homework` WHERE begin_course_cd=$course_cd AND personal_id=$p_id;");
		db_query("DELETE FROM `test_course_ans` WHERE begin_course_cd=$course_cd AND personal_id=$p_id;");
		db_query("DELETE FROM `roll_book` WHERE begin_course_cd=$course_cd AND personal_id=$p_id;");
		//成績
		db_query("DELETE FROM `course_concent_grade` WHERE begin_course_cd=$course_cd AND student_id=$p_id;");
		db_query("DELETE FROM `take_course` WHERE begin_course_cd=$course_cd AND personal_id=$p_id;");
	}
?>
