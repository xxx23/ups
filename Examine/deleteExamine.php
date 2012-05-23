<?php
	/*author: lunsrot
	 * date: 2007/06/30
	 */
	require_once("../config.php");
	require_once("../session.php");

	include "../library/delete_data.php";

	checkMenu("/Examine/tea_view.php");

	global $DB_CONN;
	$input = $_GET;
	$course_cd = $_SESSION['begin_course_cd'];

	for($i = 0 ; $i < count($input['test_no']) ; $i++){
		$test_no = $input['test_no'][$i];
		delete_examine($course_cd, $test_no);
		//刪除檔案，未實作
	}

	header("location:./tea_view.php");
?>
