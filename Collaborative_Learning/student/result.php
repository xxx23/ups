<?php
	/*author: lunsrot
	 * date: 2007/07/12
	 */
	require_once("../../config.php");
	require_once("../../session.php");
	require_once("../lib/co_learn_lib.php");

	checkMenu("/Collaborative_Learning/student/stu_main_page.php");

	global $DB_CONN;
	$input = $_GET;
	$course_cd = $_SESSION['begin_course_cd'];

	//modify by rja , check 學生還沒分組前，按"成果發表"會出錯
	$test_team_alive = $DB_CONN->getAll("select group_no from groups_member where homework_no={$_GET['homework_no']} and student_id = {$_SESSION['personal_id']};", DB_FETCHMODE_ASSOC);
	//if(PEAR::isError($test_team_alive))	die($test_team_alive->userinfo);
	if( empty($test_team_alive)){
		echo '尚未分組。' ;
		die;
	}
	//end of 分組出錯問題


	if(!empty($input['homework_no'])){
		$tpl = new Smarty;
		$no = $input['homework_no'];
		$course_cd = $_SESSION['begin_course_cd'];

		$res = $DB_CONN->getRow("select * from `homework` where homework_no=$no;", DB_FETCHMODE_ASSOC);
		$tpl->assign("homework_name", $res['homework_name']);
		$tpl->assign("homework_no", $res['homework_no']);
		$tpl->assign("d_dueday", $res['d_dueday']);
		$group_no = $DB_CONN->getOne("select group_no from `groups_member` where begin_course_cd=$course_cd and homework_no=$no and student_id=$_SESSION[personal_id];");
		$pro = $DB_CONN->getRow("select * from `info_groups` where begin_course_cd=$course_cd and homework_no=$no and group_no=$group_no;", DB_FETCHMODE_ASSOC);
		$tpl->assign("upload", $pro['upload']);
		if($pro['upload'] == 1){
			isUpload($tpl, $course_cd, $no, $group_no);
		}

		assignTemplate($tpl, "/collaborative_learning/student/result.tpl");
/*		$tpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/student/result.tpl");*/
	}else{
		$input = $_POST;
		switch($input['action']){
		case "upload": upload($input); break;
		case "delete": _delete($input); break;
		default: break;
		}
	}

	function upload($input){
		global $DB_CONN, $COURSE_FILE_PATH;
		$course_cd = $_SESSION['begin_course_cd'];
		$no = $input['homework_no'];
		$group_no = $DB_CONN->getOne("select group_no from `groups_member` where begin_course_cd=$course_cd and homework_no=$no and student_id=$_SESSION[personal_id];");
		$path = "$COURSE_FILE_PATH$course_cd/homework/$input[homework_no]/student/$group_no/";
		createPath($path);

		if($_FILES['result_upload']['error'] != 0)
			exit(0);
		$now = date("mdHis");
		$file = "result_$now" . "_" . $_FILES['result_upload']['name'];
		db_query("update `info_groups` set result_work='$file', upload='1' where begin_course_cd=$course_cd and group_no=$group_no and homework_no=$no;");
		FILE_upload($_FILES['result_upload']['tmp_name'], $path, $file);
		$key = check_get_produce_key($no, "stu");
		header("location:result.php?homework_no=$no&key=$key");
	}

	function isUpload($tpl, $course_cd, $no, $group_no){
		global $DB_CONN, $COURSE_FILE_PATH;
		$work = $DB_CONN->getOne("select result_work from `info_groups` where begin_course_cd=$course_cd and homework_no=$no and group_no=$group_no;");
		$path = "$COURSE_FILE_PATH$course_cd/homework/$no/student/$group_no/";
		$_SESSION['current_path'] = $path;
		$path = "$COURSE_FILE_PATH$course_cd/homework/$no/student/$group_no/$work";
		$time = fileatime($path);
		$date = getdate($time);
		$tpl->assign("upload_time", "$date[year]-$date[mon]-$date[mday] $date[hours]:$date[minutes]:$date[seconds]");
		$tpl->assign("file_path", urlencode($work));
		$tpl->assign("file_name", $work);
	}

	function _delete($input){
		global $DB_CONN, $COURSE_FILE_PATH;
		$course_cd = $_SESSION['begin_course_cd'];
		$no = $input['homework_no'];

		$group_no = $DB_CONN->getOne("select group_no from `groups_member` where begin_course_cd=$course_cd and homework_no=$no and student_id=$_SESSION[personal_id];");
		$work = $DB_CONN->getOne("select result_work from `info_groups` where begin_course_cd=$course_cd and homework_no=$no and group_no=$group_no;");
		$path = "$COURSE_FILE_PATH$course_cd/homework/$no/student/$group_no/$work";
		unlink($path);
		db_query("update `info_groups` set result_work='', upload='0' where begin_course_cd=$course_cd and group_no=$group_no and homework_no=$no;");

		$key = check_get_produce_key($no, "stu");
		header("location:result.php?homework_no=$no&key=$key");
	}
?>
