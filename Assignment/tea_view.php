<?php
	/* author: lunsrot
	 */
/*modify by lunsrot at 2007/03/14*/
	require_once("../config.php");
	require_once("../session.php");
/*modify end*/
	include "ass_info.php";
	include "library.php";
	require_once("../library/co_learn_lib.php");

	checkMenu("/Assignment/tea_view.php");

	$course_cd = $_SESSION['begin_course_cd'];
	$tmp = gettimeofday();
	$tpl = new Smarty;
	
if ( isset($_REQUEST['remind'] )){
//啟動自動催繳
$remindsql = "update  homework set remind = {$_REQUEST['remind']}  
where homework_no ={$_REQUEST['homework_no']} and begin_course_cd = $course_cd ;";
db_query($remindsql);

}
$check_remaindsql = "select distinct homework_no from homework  
where begin_course_cd = $course_cd and remind = 1  ;";
//var_dump($check_remaindsql);
$remind_homework= flatArray(db_getAll($check_remaindsql));
//var_dump($remind_homework);

	//一般作業
	$result = listAssignment($course_cd, "all");
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		$tpl->append('ass_data', $row);
	}
		$tpl->assign('remind_homework', $remind_homework);
	//合作學習
	$result = db_query("select A.homework_no, A.homework_name, A.question, A.percentage, A.d_dueday, B.due_date from `homework` A, `project_data` B where A.begin_course_cd=$course_cd and A.is_co_learn=1 and B.begin_course_cd=A.begin_course_cd and B.homework_no=A.homework_no;");
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		$row['key'] = check_get_produce_key($row['homework_no'],"stu");
		$tpl->append("coll_data", $row);
	}
	assignTemplate($tpl, "/assignment/tea_view.tpl");
?>
