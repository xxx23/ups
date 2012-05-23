<?php
	/*author: lunsrot
	 */
/*modify by lunsrot at 2007/03/14*/
$PATH = "../";
require_once($PATH . "config.php");
require_once($PATH . "session.php");
require_once($PATH . "library/co_learn_lib.php");
/*modify end*/
	include "library.php";
	include "ass_info.php";

	checkMenu("/Assignment/stu_assign_view.php");

	$course_cd = $_SESSION['begin_course_cd'];
	$template = $_SESSION['template_path'] . $_SESSION['template'];
	$tmp = gettimeofday();
	$tpl = new Smarty;

	//一般作業
	$result = listAssignment($course_cd, "public");
	while( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
	  	if( timecmp( $tmp['sec'], strtotime($row['d_dueday']) ) == 1 && $row['late'] == 0) $row['disabled'] = "disabled";
		else $row['disabled'] = "";
		$row['pubAns'] = publicAns($row['ans_day'], $row['public']);
		$tpl->append('ass_data', $row);
	}
	//合作學習
	$result = db_query("select A.homework_no, A.homework_name, A.question, A.percentage, A.d_dueday, A.late, B.due_date from `homework` A, `project_data` B where A.begin_course_cd=$course_cd and is_co_learn=1 and B.begin_course_cd=A.begin_course_cd and B.homework_no=A.homework_no order by d_dueday;");
	while( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
		$key =  check_get_produce_key($row['homework_no'],"stu");
		$row['key'] = $key;
		$tpl->append("co_data", $row);
	}

	assignTemplate($tpl, "/assignment/stu_assign_view.tpl");

	function publicAns($ans_day, $public){
		$tmp = gettimeofday();
		if($public % 2 == 0)
			return 0;
		if(empty($ans_day) || $ans_day == "0000-00-00 00:00:00" || timecmp($tmp['sec'], strtotime($ans_day)) < 1)
			return 0;
		return 1;
	}
?>
