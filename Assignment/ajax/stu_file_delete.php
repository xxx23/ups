<?php
	/*author: lunsrot
	 * date: 2007/06/25
	 */
	require_once("../../config.php");
	require_once("../../session.php");

	$input = $_POST;
	$flag = 0;
	if(unlink($_SESSION['current_path'] . $input['file']) != 1)
		$flag = 1;
	else if($input['option'] == "ans")
		db_query("update `handin_homework` set work='', type='' where begin_course_cd=$_SESSION[begin_course_cd] and homework_no=$input[homework_no] and personal_id=$_SESSION[personal_id];");
	echo $flag;
?>
