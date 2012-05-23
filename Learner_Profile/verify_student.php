<?php
	/*author: lunsrot
	 * date: 2007/11/19
	 */
	require_once("../config.php");
	require_once("../session.php");
	require_once("../library/common.php");

	require_once("library.php");

	$input = $_POST;
	$pid = $input['pid'];
	$course_cd = $_SESSION['begin_course_cd'];
	if($input['flag'] == "-1"){
		for($i = 0 ; $i < count($pid) ; $i++)
			;
	}else if($input['flag'] == 2){
		for($i = 0 ; $i < count($pid) ; $i++)
			remove_student_from_course($course_cd, $pid[$i]);
	}else{
		for($i = 0 ; $i < count($pid) ; $i++){
		  	db_query("update `take_course` set allow_course='$input[flag]' where personal_id='".$pid[$i]."' and begin_course_cd='".$course_cd."';");
			sync_stu_course_data($course_cd,$pid[$i]);
		}
	}
	header("location:./tea_query_student.php");
?>
