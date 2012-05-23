<?php
// add by Samuel @ 2010.01.24
// 程式需求： 新增教師刪除課程的介面 否則課程會愈來愈多

	include "../config.php";
	require_once("../session.php");
	session_start();

	if(isset($_POST['course_delete_list']))
	  $course_cd = $_POST['course_delete_list'];

	//取得老師的編號：
	$teacher_id = getTeacherID();

	$sql = "DELETE FROM course_basic where teacher_cd = '{$teacher_id}' and course_cd = '{$course_cd}'";
	db_query($sql);
	
	// 課程裡面原本有指定一門課程資訊來當作這一門課程的課程資訊，現在要把這個課程資訊給拿掉。
	
	$sql = "UPDATE begin_course SET course_cd = NULL WHERE course_cd = '{$course_cd}'";
	db_query($sql);
	
	//在指定一門課程給某一門課之後，course_cd也會被寫進這個session裡面，所以要把session清掉。
	unset($_SESSION['course_cd']);

	header("Location: {$WEBROOT}/Course/course_manage_personal.php");
?>
