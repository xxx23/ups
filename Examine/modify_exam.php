<?php
	/* author: lunsrot
	 * date: 2007/06/30 modify
	 */
	require_once("../config.php");
	require_once("../session.php");
	require_once("exam_info.php");

	global $DB_CONN;
	$course_cd = $_SESSION['begin_course_cd'];
	$option = $_GET['option'];
	$test_no = $_GET['test_no'];

	if(empty($option)){
		$tpl = new Smarty;

		$sql = "select test_name, percentage, test_type from `test_course_setup` where begin_course_cd=$course_cd and test_no=$test_no;";
		$result = db_query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);

		$tpl->assign('test_no', $test_no);
		$tpl->assign('test_name', $row[test_name]);
		$tpl->assign('test_percentage', $row[percentage]);
		if($row[test_type] == 1)
			$tpl->assign('select', array("selected", ""));
		else
			$tpl->assign('select', array("", "selected"));

		assignTemplate($tpl, '/examine/modify_exam.tpl');
	}else{
		$test_name  = $_GET['name'];
		$test_type  = $_GET['type'];
		$percentage = $_GET['score'];
		if($test_type == 1)
			$percentage = 0;

		$number_id = $DB_CONN->getOne("select number_id from `course_percentage` where begin_course_cd=$_SESSION[begin_course_cd] and percentage_type=1 and percentage_num=$test_no;");
		db_query("update `course_percentage` set percentage=$percentage where begin_course_cd=$_SESSION[begin_course_cd] and number_id=$number_id;");
		$sql = "update `test_course_setup` set test_name='$test_name', test_type=$test_type, percentage=$percentage where test_no=$test_no and begin_course_cd=$_SESSION[begin_course_cd];";
		db_query($sql);
		header("location:./tea_view.php");
	}
?>
