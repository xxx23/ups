<?php
	/*author: lunsrot
	 * date: 2008/02/15
	 */
	require_once("../config.php");
	require_once("../session.php");

	require_once("../library/delete_data.php");

	$input = $_GET;
	if(empty($input['option']))
		$input['option'] = "view";
	call_user_func($input['option'], $input);

	//template
	function view($input){
		$tpl = new Smarty;
		$tpl->assign("done", $input['done']);
		$tpl->assign("begin_course_cd", $input['begin_course_cd']);
		$tpl->assign("course_name", db_getOne("SELECT begin_course_name FROM `begin_course` WHERE begin_course_cd=$input[begin_course_cd];"));
		assignTemplate($tpl, "/course_admin/reset_course.tpl");
	}

	//function
	function reset_course($input){
		$type = $input['type'];
		for($i = 0 ; $i < count($type) ; $i++){
			call_user_func($type[$i], $input['begin_course_cd']);
		}
		header("location:./reset_course.php?done=1&begin_course_cd=" . $input['begin_course_cd']);
	}

	function news($cd){
		delete_course_news($cd);
	}
	function material($cd){
		delete_textbook($cd);
	}
	function assignment($cd){
		delete_assignment_by_course_cd($cd);
	}
	function examine($cd){
		delete_examine_by_course_cd($cd);
	}
	function survey($cd){
		delete_survey_by_course_cd($cd);
	}
	function disscuss($cd){
		delete_course_discuss_area($cd);
	}
	function track($cd){
		delete_course_learning_tracking($cd);
	}
	function grade($cd){
		delete_course_grade($cd);
	}
	function roll($cd){
		delete_course_roll_book($cd);
	}
	function student($cd){
		delete_assignment_by_course_cd($cd);
		delete_examine_by_course_cd($cd);
		delete_survey_by_course_cd($cd);
		delete_course_learning_tracking($cd);
		delete_course_roll_book($cd);
		delete_course_grade($cd);
		db_query("DELETE FROM `take_course` WHERE begin_course_cd=$cd;");
	}
	function schedule($cd){
		db_query("DELETE FROM `course_schedule` WHERE begin_course_cd=$cd;");
	}
	function assistant($cd){
		db_query("DELETE FROM `teach_begin_course` WHERE begin_course_cd=$cd AND teacher_cd IN (SELECT personal_id FROM `register_basic` WHERE role_cd=2);");
	}
?>
