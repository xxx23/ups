<?php
	include "../config.php";
	include "exam_info.php";
	
	$test_no = $_GET['test_no'];
	$sequence = $_GET['sequence'];
	$url = $_GET['url'];
	
	$sql = "delete from `test_course` where test_no=$test_no and sequence=$sequence;";
	db_query($sql);
	
	header("location:./$url");
?>
