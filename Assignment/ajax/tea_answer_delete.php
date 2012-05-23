<?php
	/*author: lunsrot
	 * date: 2007/08/05
	 */
	require_once("../../config.php");
	require_once("../../session.php");

	checkMenu("/Assignment/tea_assignment.php");

	$flag = 0;
	$file = $_POST['file'];
	$no = $_POST['homework_no'];
	if(unlink($_SESSION['current_path'] . $file) != 1)
		$flag = 1;
	else
		db_query("update `homework` set answer='', ans_type='' where homework_no=$no;");
	echo $flag;
?>
