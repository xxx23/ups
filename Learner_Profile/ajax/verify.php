<?php
	/*author: lunsrot
	 * date: 2007/11/20
	 */
	require_once("../../config.php");
	require_once("../../session.php");
      	require_once("../../library/common.php");

	global $THEME_PATH;
	$input = $_POST;
	$tpl_path = "/" . $THEME_PATH . $_SESSION['template'];
	call_user_func($input['option'], $input);

	function allow($input){
		global $DB_CONN, $tpl_path, $WEBROOT;
		$allow = 1 - $DB_CONN->getOne("select allow_course from `take_course` where personal_id=$input[pid] and begin_course_cd=$_SESSION[begin_course_cd];");
		db_query("update `take_course` set allow_course=$allow where personal_id=$input[pid] and begin_course_cd=$_SESSION[begin_course_cd];");
		//1表示核准
		if($allow == 1)	echo $WEBROOT."$tpl_path/images/icon/pass.gif";
		else echo $WEBROOT."$tpl_path/images/icon/fail.gif";
		sync_stu_course_data($_SESSION['begin_course_cd'],$input['pid']);
		return 1;
	}

	function status($input){
		global $DB_CONN, $tpl_path, $WEBROOT;
		$status = 1 - $DB_CONN->getOne("select status_student from `take_course` where personal_id=$input[pid] and begin_course_cd=$_SESSION[begin_course_cd];");
		db_query("update `take_course` set status_student=$status where personal_id=$input[pid] and begin_course_cd=$_SESSION[begin_course_cd];");
		if($status == 1)echo $WEBROOT."$tpl_path/images/icon/major.gif";
		else echo $WEBROOT."$tpl_path/images/icon/auditor.gif";
		sync_stu_course_data($_SESSION['begin_course_cd'],$input['pid']);
		return 1;
	}
?>
