<?php
	/*author: lunsrot
	 */
	include "../config.php";
	include "../session.php";
	include "ass_info.php";

	$flag = 0;
	$file = $_POST['file'];
	if(unlink($_SESSION['current_path'] . $file) != 1)
	  $flag = 1;
	$no = $_POST['homework_no'];
	db_query("update `homework` set question='', q_type='' where homework_no=$no;");
	echo $flag;
?>
