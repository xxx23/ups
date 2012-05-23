<?php
	/*author: lunsrot
 	 * date: 2007/04/03
 	 */
	require_once("../config.php");
	require_once("../session.php");
	require_once("ass_info.php");
	require_once("homework.php");

	$no = $_SESSION['homework_no'];
	//成績輸入
	$grade = $_POST['grade'];
	$personal_id = $_POST['personal_id'];
	update_grade($grade,$personal_id);

	//優良作業
	$excell = $_POST['excell'];
	//先清空所有優良作業
	db_query("update `handin_homework` set public=0 where homework_no=$no;");
	for($i = 0 ; $i < count($excell) ; $i++)
		db_query("update `handin_homework` set public=1 where homework_no=$no and personal_id=$excell[$i];");

	header("location: tea_correct.php?view=true&option=list_all&homework_no=$no");
?>
