<?php
	/*author: lunsrot
	 * date: 2007/07/04
	 */
	require("../../config.php");
	require("../../session.php");

	$input = $_GET;
	$pid = $_SESSION['personal_id'];

	db_query("update `personal_basic` set course_div='$input[seq]' where personal_id=$pid;");
	echo "";
?>
