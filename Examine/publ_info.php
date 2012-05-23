<?php
	include_once "../Examine/exam_info.php";

	global $hour, $hour_list, $minute, $minute_list;	
	$hour = array(0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23);
	$hour_list = array("00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23");
	$minute = array(0, 15, 30, 45);
	$minute_list = array("00", "15", "30", "45");

	function setTime($DB_CONN, $begin_course_cd, $test_no, $str, $col){
		$date = $_GET[$str."_date"];
		$hour = $_GET[$str."_hour"];
		$minute = $_GET[$str."_minute"];

		$str = $date." ".$hour.":".$minute;
		$sql = "update test_course_setup set $col='$str' where begin_course_cd=$begin_course_cd and test_no=$test_no;";
		$result = $DB_CONN->query($sql);
	}
	function displayTime($tpl, $time, $str, $char){
		global $hour, $hour_list, $minute, $minute_list;	
		$tpl->assign($str."_date", "$time[year]-$time[mon]-$time[mday]");
		$tpl->assign($str."_hour", $hour);
		$tpl->assign($char."hour_list", $hour_list);
		$tpl->assign($char."now_hour", $time['hours']);
		$tpl->assign($str."_minute", $minute);
		$tpl->assign($char."minute_list", $minute_list);
	}
?>
