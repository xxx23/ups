<?php
	/*author: lunsrot
	 */
	require_once("../config.php");
	require_once("../session.php");
	include "library.php";
	include "ass_info.php";

	$view = $_GET['view'];

	$tmp = gettimeofday();
	if($view == "true"){			//display
		$option = $_GET['option'];
		$no = $_GET['homework_no'];

		$result = db_query("select d_dueday from `homework` where homework_no=$no;");
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		if( timecmp( $tmp['sec'], strtotime($row['d_dueday']) ) == 1 )
			$outdated = "true";

		switch($option){
			case "view_quest": viewAssignment($no, 0); break;
			case "update": display_update($no, $outdated); break;
			case "view_ans": display_reply($no, "你的"); break;
			case "ans": display_answer($no); break;
			case "comment": display_comment($no); break;
			default: break;
		}
	}else{					//hand in
		$option = $_POST['option'];

		switch($option){
			case "update": update(); break;
			default: break;
		}
	}

	function display_update($no, $outdated){
	  	global  $COURSE_FILE_PATH, $WEBROOT;
		global $HOME_PATH;
		require_once($HOME_PATH . 'library/smarty_init.php');
		//$tpl = new Smarty;
		$pid = $_SESSION['personal_id'];
		$course_cd = $_SESSION['begin_course_cd'];

		$result = db_query("select homework_name, question, late, begin_course_cd, q_type from `homework` where homework_no=$no;");
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		if( $outdated == "true" && $row['late'] == 1)
		  	$tpl->assign("outdated", "此作業已超過繳交期限<br/>");
		$tpl->assign("name", $row['homework_name']);
		$tpl->assign("no", $no);
		$tpl->assign("course_cd", $course_cd);
		$tpl->assign("math", $_GET['math']);

		$result = db_query("select work, type from `handin_homework` where begin_course_cd=$course_cd and homework_no=$no and personal_id=$pid;");
		$file = "";
		$name = db_getOne("select login_id from `register_basic` where personal_id=$pid;");
		$_SESSION['current_path'] = $COURSE_FILE_PATH . $course_cd . "/homework/$no/student/$name/";
		if($result->numRows() == 1){
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$file = $row['work'];
			if(!empty($row['type'])){
				$tpl->assign("upload1", "checked"); 
				$tpl->assign("is_upload", 1);
				$tpl->assign("file", $row['work']);
				$row['work'] = "<a href=\"".$WEBROOT."library/redirect_file.php?file_name=" . urlencode($row['work']) . "\">" . $row['work'] . "</a>";
			}else
				$tpl->assign("upload0", "checked"); 
			$tpl->assign('content', $row['work']);
		}else{
		  	$tpl->assign("upload1", "checked");
		}

		downloadRelativeFile($tpl, $_SESSION['current_path'], $file);
		if( $outdated == "true" && $row['late'] == 1 )
			assignTemplate($tpl, "/assignment/stu_assign_outdated.tpl");
		else
			assignTemplate($tpl, "/assignment/stu_assign.tpl");
	}

	//學生回答作業
	function update(){
		global $COURSE_FILE_PATH;
		$no = $_POST['homework_no'];
		$content = $_POST['content'];
		$upload = $_POST['upload'];
		$pid = $_SESSION['personal_id'];
		$course_cd = $_SESSION['begin_course_cd'];

		$tmp = gettimeofday();
		$time = getdate($tmp['sec']);
		$date = $time['year']."-".$time['mon']."-".$time['mday']." ".$time['hours'].":".$time['minutes'].":".$time['seconds'];

		$path = "$COURSE_FILE_PATH/$course_cd/homework/$no/student/";
		$name = db_getOne("select login_id from `register_basic` where personal_id=$pid;");
		createPath($path . $name);
		//upload file for answer
		if($upload == 1){
		  	$row = db_getRow("select type, work from `handin_homework` where begin_course_cd=$course_cd and homework_no=$no and personal_id=$pid;");
		  	if($_FILES['ans_file']['error'] == 0){
				deleteOldAnswer($path, $no, $pid);
				$ext = strrchr($_FILES['ans_file']['name'], '.');
				$content = $name . $ext;
				uploadFile($path . "$name/", $content);
			}else if(!empty($row['type'])){
			  	$content = $row['work'];
				$ext = strrchr($content, '.');
			}else{
				echo "請上傳檔案<br/>";
		 		exit(0);
			}
		}
		//text for answer
		else{
		  	deleteOldAnswer($path, $no, $pid);
			$f = fopen($path . "$name/$name.html", "w");
			chmod($path . "$name/$name.html", 0775);
			fwrite($f, $content);
			fclose($f);
		}
		
		multiupload("rel_file", $COURSE_FILE_PATH . $course_cd . "/homework/$no/student/$name/");

		$result = db_query("select work from `handin_homework` where homework_no=$no and personal_id=$pid;");
		db_query("update `handin_homework` set  work='$content', handin_time='$date', type='$ext' where homework_no=$no and personal_id=$pid;");
 
		header("location:./stu_assign_view.php");
	}

	//學生瀏覽自己的回答
	function display_reply($no, $str){
		global $COURSE_FILE_PATH, $WEBROOT;
		global $HOME_PATH;
		require_once($HOME_PATH . 'library/smarty_init.php');
		//$tpl = new Smarty;
		$pid = $_SESSION['personal_id'];

		$result = db_query("select homework_name from `homework` where homework_no=$no;");
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$tpl->assign('name', $row['homework_name']);

		$result = db_query("select work, type, begin_course_cd from `handin_homework` where homework_no=$no and personal_id=$pid;");
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$file = $row['work'];
		$name = db_getOne("select login_id from `register_basic` where personal_id=$pid;");
		$_SESSION['current_path'] = $COURSE_FILE_PATH . $_SESSION['begin_course_cd'] . "/homework/$no/student/$name/";
		if(!empty($row['type'])){
			$row['work'] = "<a href=\"".$WEBROOT."library/redirect_file.php?file_name=". urlencode($row['work']) . "\">" . $row['work'] . "</a>";
		}
		$tpl->assign('answer', $row['work']);
		$tpl->assign('title', $str);

		$path = replyPath($_SESSION['begin_course_cd'], $no, $pid);
		if(empty($row['type'])){
			$name = db_getOne("select login_id from `register_basic` where personal_id=$pid;");
			$file = "$name.html";
		}
		downloadRelativeFile($tpl, $path, $file);

		assignTemplate($tpl, "/assignment/answer_view.tpl");
	}

	function uploadFile($FILE_PATH, $file){
		if(is_dir($FILE_PATH) != 1)
			createPath($FILE_PATH, 0775);
		FILE_upload($_FILES['ans_file']['tmp_name'], $FILE_PATH, $file);
	}

	function display_answer($no){
		global $FILE_PATH, $DB_CONN, $COURSE_FILE_PATH, $WEBROOT;
		global $HOME_PATH;
		require_once($HOME_PATH . 'library/smarty_init.php');
		//$tpl = new Smarty;
		$course_cd = $_SESSION['begin_course_cd'];

		$result = $DB_CONN->getRow("select homework_name, answer, begin_course_cd, ans_type from `homework` where homework_no=$no;", DB_FETCHMODE_ASSOC);
		$tpl->assign("name", $result['homework_name']);
		$path = answerPath($result['begin_course_cd'], $no);
		downloadRelativeFile($tpl, $path, $result, $no);
		if($result['ans_type'] != "")
			$result['answer'] = "<a href=\"".$WEBROOT."library/redirect_file.php?file_name=" . urlencode($result['answer']) . "\">" . $result['answer'] . "</a>";
		$tpl->assign("answer", $result['answer']);
		$_SESSION['current_path'] = $COURSE_FILE_PATH . $course_cd . "/homework/$no/teacher/answer/";
		$tpl->assign("homework_no", $no);
		$tpl->assign("tpl_path", $tpl_path);

		assignTemplate($tpl, "/assignment/stu_answer.tpl");
	}

	function display_comment($no){
		global $HOME_PATH;
		require_once($HOME_PATH . 'library/smarty_init.php');
	  	//$tpl = new Smarty;

	  	$result = db_query("select A.homework_name, B.comment from `homework` A, `handin_homework` B where A.homework_no=$no and B.homework_no=A.homework_no and B.personal_id=" . $_SESSION['personal_id'] . ";");
	  	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	  	$tpl->assign("name", $row['homework_name']);
	  	$tpl->assign("comment", $row['comment']);

	  	assignTemplate($tpl, "/assignment/display_comment.tpl");
	}

	function deleteOldAnswer($path, $no, $pid){
	  	global $DB_CONN;
	  	$result = db_query("select type, work from `handin_homework` where homework_no=$no and personal_id=$pid;");
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$name = $DB_CONN->getOne("select login_id from `register_basic` where personal_id=$pid;");
		if(file_exists($path . "/$name/$name.html"))
		  	unlink($path . "/$name/$name.html");
		if(empty($row['type']))
		  	return ;
		unlink($path . "/$name/" . $row['work']);
	}
?>
