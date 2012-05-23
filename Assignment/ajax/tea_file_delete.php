<?php
	/*author: lunsrot
	 * date: 2007/06/25
	 */
	require_once("../../config.php");
	require_once("../../session.php");

	checkMenu("/Assignment/tea_assignment.php");

	$flag = 0;
	$file = $_POST['file'];
	if(unlink($_SESSION['current_path'] . $file) != 1)
	  $flag = 1;
	echo $flag;
?>
