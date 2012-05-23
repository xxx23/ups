<?php
	/*author: lunsrot
	 * date: 2007/07/05
	 * 用於改變測驗的成績是否公布
	 */
	require_once("../../config.php");
	require_once("../../session.php");

	global $DB_CONN;
	$input = $_GET;
	$course_cd = $_SESSION['begin_course_cd'];
	$public = $DB_CONN->getOne("select anS_public from `test_course_setup` where begin_course_cd=$course_cd and test_no=$input[test_no];");
	$public = 1 - $public;
	db_query("update `test_course_setup` set ans_public=$public where begin_course_cd=$course_cd and test_no=$input[test_no];");
	echo $public;
?>
