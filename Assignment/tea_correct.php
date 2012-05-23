<?php
	/*author: lunsrot
	 */
/*modfiy by lunsrot at 2007/03/20*/
	require_once("../config.php");
	require_once("../session.php");
/*modify end*/
	require_once("ass_info.php");
	require_once("../library/co_learn_lib.php");

	checkMenu("/Assignment/tea_assignment.php");

	global $FILE_PATH;
	$view = $_GET['view'];
	$no = $_GET['homework_no'];
	$option = $_GET['option'];

	if($view == true){
		switch($option){
			case "list_all": display_submitted($no); break;
			case "single": display_single(); break;
			case "correct": display_correct(); break;
			case "tool": display_tool(); break;
			case "context": display_context(); break;
			default: break;
		}
	}else{
		switch($option){
			case "download": download_homework($no); break;
			case "grade": grade(); break;
			default: break;
		}
	}

	function display_single(){
		global $DB_CONN;
		$tpl = new Smarty;
		$input = $_GET;
		$no = $_SESSION['homework_no'];

		$tpl->assign("pid", $input['pid']);
		$tpl->assign("homework_no", $no);

		$row = $DB_CONN->getRow("select work, type from `handin_homework` where homework_no=$no and personal_id=$input[pid] order by personal_id;", DB_FETCHMODE_ASSOC);

		$path = replyPath($_SESSION['begin_course_cd'], $no, $input['pid']);
		$_SESSION['current_path'] = $path;
		if(empty($row['type'])){
			$id = $DB_CONN->getOne("select login_id from `register_basic` where personal_id=$input[pid];") . ".html";
			$tpl->assign("answer", "<a href=\"tea_correct.php?view=true&option=correct&pid=$input[pid]\">" . $id . "</a>");
			downloadRelativeFile($tpl, $path, $id);
		}else{
			$tpl->assign("isupload", 1);
			$tpl->assign("path", urlencode($row['work']));
			$tpl->assign("answer", $row['work']);
			downloadRelativeFile($tpl, $path, $row['work']);
		}
		assignTemplate($tpl, "/assignment/student_answer.tpl");
	}

	//template 
	function display_correct(){
		global $DB_CONN;
		$tpl = new Smarty;
		$input = $_GET;
		$no = $_SESSION['homework_no'];
		$tpl->assign("pid", $input['pid']);
		$tpl->assign("homework_no", $no);
		$row = $DB_CONN->getRow("select work, type from `handin_homework` where homework_no=$no and personal_id=$input[pid] order by personal_id;", DB_FETCHMODE_ASSOC);
		assignTemplate($tpl, "/assignment/display_single.tpl");
	}

	function display_tool(){
		$tpl = new Smarty;
		$input = $_GET;

		$tpl->assign("homework_no", $input['homework_no']);
		$tpl->assign("pid", $input['pid']);
		assignTemplate($tpl, "/assignment/tool.tpl");
	}

	function display_context(){
		global $DB_CONN;
		$input = $_GET;

		$context = $DB_CONN->getOne("select work from `handin_homework` where homework_no=$input[homework_no] and personal_id=$input[pid];");
		$prefix = substr($context, 0, 6);
		if(strcmp($prefix, "<html>") != 0)
			$context = "<html><body onload=\"parent.bMain=true;\">" . $context . "</body></html>";
		echo $context;
	}

	function display_submitted($no){
		global $DB_CONN;
		$course_cd = $_SESSION['begin_course_cd'];
		$tpl = new Smarty;

		$foosql="SELECT A.personal_id, A.personal_name, B.handin_time, B.public, C.concent_grade 
			from `personal_basic` A, `handin_homework` B, `course_concent_grade` C 
			where A.personal_id=B.personal_id and B.homework_no=$no and B.personal_id in 
			(select personal_id from `take_course` where begin_course_cd=$course_cd and status_student=1) and
		   	C.begin_course_cd=$course_cd and C.percentage_type=2 and
		   	C.percentage_num=$no and C.student_id=A.personal_id order by A.personal_id asc;";
		$result = db_query($foosql);
		while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
			$row['login_id'] = db_getOne("select login_id from `register_basic` where personal_id=$row[personal_id];");
			$row['is_handin'] = isHandin($row['handin_time']);
			if(!is_numeric($row['concent_grade']))
				$row['concent_grade'] = "N/A";
			$tpl->append('ass_data', $row);
		}
		$_SESSION['homework_no'] = $no;
		$tmp = db_query("select grade_public from `handin_homework` where begin_course_cd=$course_cd and homework_no=$no;");
		$submitted = $tmp->fetchRow();
		$tpl->assign("submitted", $submitted[0]);

		assignTemplate($tpl, "/assignment/display_submitted.tpl");
	}

	function isHandin($time){
		if($time == "0000-00-00 00:00:00" || empty($time))
			return 0;
		return 1;
	}

	function download_homework($no){
		global $COURSE_FILE_PATH, $HOME_PATH;
		$result = db_query("select begin_course_cd from `homework` where homework_no=$no;");
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);

		$location = $COURSE_FILE_PATH . $row['begin_course_cd'] . "/homework/$no/";
		exec("cd $location; tar -cf $no.tar student/");
		$_SESSION['current_path'] = $location;
		header("location: ../library/redirect_file.php?file_name=$no.tar");
	}

	function grade(){
		$input = $_GET;
		$course_cd = $_SESSION['begin_course_cd'];
		db_query("update `handin_homework` set work='$input[vml]' where begin_course_cd=$course_cd and homework_no=$input[homework_no] and personal_id=$input[pid];");
		db_query("update `course_concent_grade` set concent_grade=" . $input['grade'] . " where begin_course_cd=$course_cd and percentage_num=$input[homework_no] and percentage_type=2 and student_id=$input[pid];");
		echo "<script>window.close();</script>";
	//	header("location:./tea_correct.php?view=true&option=list_all&homework_no=$input[homework_no]");
	}
?>
