<?php
	/* author: lunsrot
	 * date: 2007/06/30 modify
	 * 單純的顯示頁面，讓教師可以看到此次(一次)測驗的題目列表
	 */
	require_once("../config.php");
	require_once("../session.php");
	require_once("exam_info.php");

	
	$test_no = $_GET['test_no'];
	$_SESSION['test_no'] = $test_no;
	
	$tpl = new Smarty;
	$string = array("", "選擇題", "是非題", "填充題", "簡答題");
	
	//取得測驗名稱
	$sql = "select * from `test_course_setup` where begin_course_cd=$_SESSION[begin_course_cd] and test_no=$test_no;";
	$result = db_query($sql);
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$exam_name = $row[test_name];
	//取得測驗的每一題的內容
	$sql = "select * from `test_course` where begin_course_cd=$_SESSION[begin_course_cd] and test_no=$test_no order by test_type, sequence;";
	$result = db_query($sql);
	$i = 1;
	$tpl->assign('exam_name', $exam_name);
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		$row['num'] = $i++;
		$row['type_string'] = $string[$row[test_type]];
		$row['function'] = "display_exam.php?test_no=".$test_no;
		$row['question'] = strip_tags($row['question']);
		$tpl->append('exam_data', $row);
	}
	$tpl->assign('test_no', $test_no);
	assignTemplate($tpl, "/examine/display_exam.tpl");
?>
