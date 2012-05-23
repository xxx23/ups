<?php
	require_once("../config.php");
	require_once("../session.php");
	require_once("exam_info.php");
	
	global $DB_CONN;
	$begin_course_cd = $_SESSION['begin_course_cd'];
	$personal_id = getTeacherId();
	$test_no = $_SESSION['test_no'];

	$tpl = new Smarty;
	$string = array("", "選擇題", "是非題", "填充題", "簡答題");
	
	$sql = "select * from `test_course` where test_no=$test_no and begin_course_cd=$begin_course_cd order by test_type, sequence;";
	$result = db_query($sql);
	$i = 1;
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		$row['num'] = $i++;
		$row['type_string'] = $string[$row[test_type]];
		$row['function'] = "connection_page.php";
		$row['question'] = strip_tags($row['question']);
		$tpl->append('exam_data', $row);
	}

	$result = $DB_CONN->query("select content_cd from `course_content` where teacher_cd=$personal_id;");
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$tpl->assign("content_cd", $row['content_cd']);
	$tpl->assign('test_no', $test_no);

	assignTemplate($tpl, "/examine/connection_page.tpl");
?>
