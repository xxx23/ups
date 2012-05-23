<?php
	/*author: lunsrot
	 */
/*modify by lunsrot at 2007/03/20*/
$PATH = "../";
require_once($PATH . "config.php");
require_once($PATH . "session.php");
/*modify end*/
	include "ass_info.php";

	//get information from session
	$course_cd = $_SESSION['begin_course_cd'];
	//authorization
	//get information from $_GET
	$view = $_GET['view'];

	checkMenu("/Assignment/tea_assignment.php");

	if($view == "true"){
	  	$option = $_GET['option'];

		switch($option){
		  	case "create": display_update("create"); break;
			case "view": display_answer(); break;
			case "modify": display_update("modify"); break;
			default: break;
		}
	}else{
		$option = $_POST['option'];

		switch($option){
			case "create": update("create"); break;
			default: break;
		}
	}

	function display_update($str){
		global $COURSE_FILE_PATH;
		$course_cd = $_SESSION['begin_course_cd'];
		$no = $_GET['homework_no'];
	  	$tpl = new Smarty;

		if($str == "create"){
			$result = db_query("select d_dueday from `homework` where homework_no=$no;");
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$tmp = strtotime($row[d_dueday]);
			$time = getdate($tmp);
			$time['mday'] += 1;

			$tpl->assign("a_type0", "checked");
			$tpl->assign("pub0", "checked");
		}else{
			$result = db_query("select answer, public, d_dueday, ans_day, ans_type, begin_course_cd from `homework` where homework_no=$no;");
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			if($row['public']%2 == 1){
			//要公佈解答  
			  	$tmp = strtotime($row['ans_day']);
				$time = getdate($tmp);
				$tpl->assign("pub".$row['public']%2, "checked");
			}else{
			//不公佈解答
				$tmp = strtotime($row['d_dueday']);
				$time = getdate($tmp);
				$time['mday'] += 1;
				$tpl->assign("pub0", "checked");
			}

			if($row['ans_type'] != ""){
				$tpl->assign("a_type0", "checked");
				$_SESSION['current_path'] = $COURSE_FILE_PATH . $course_cd . "/homework/$no/teacher/answer/";
				$tpl->assign("file_path", urlencode($row['answer']));
				$tpl->assign("homework_no", $no);
			}else{
				$tpl->assign("a_type1", "checked");
			}
			$tpl->assign('rel_file', "1");
			download_relative_file($tpl, $COURSE_FILE_PATH, $row, $no);
			$tpl->assign("answer", $row['answer']);
		}
		$tpl->assign("ans_date", "$time[year]-$time[mon]-$time[mday]");
		$tpl->assign("ans_type", $row['ans_type']);
		$tpl->assign("homework_no", $no);

		assignTemplate($tpl, "/assignment/ans_update.tpl");
	}

	function update($str){
		global $COURSE_FILE_PATH, $DB_CONN;
		$no = $_POST['homework_no'];
		$course_cd = $_SESSION['begin_course_cd'];

		$path = answerPath($course_cd, $no);
		$answer = $_POST['content'];
		$ans_type = "";
		if($_POST['a_type'] == 1){
			removeOldAnswer($course_cd, $no);
		}else if($_FILES['a_file']['error'] != 0 && isExistAnswer($course_cd, $no) == true){
			$result = $DB_CONN->getRow("select answer, ans_type from `homework` where homework_no=$no;", DB_FETCHMODE_ASSOC);
			$answer = $result['answer'];
			$ans_type = $result['ans_type'];
		}
		else if($_FILES['a_file']['error'] != 0){
			echo "解答設定錯誤<br/>";
			exit(0);
		}else{
			removeOldAnswer($course_cd, $no);
			$answer = $_FILES['a_file']['name'];
			$ans_type = strrchr($answer, '.');
			FILE_upload($_FILES['a_file']['tmp_name'], $path, $answer);
		}

		$result = db_query("select public from `homework` where homework_no=$no;");
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$pub = (Int)($row['public']/2) * 2 + $_POST['pub'];
		$date = $_POST['ans_date'] . " 00:00:00";
		db_query("update `homework` set answer='$answer', ans_type='$ans_type', public=$pub, ans_day='$date' where homework_no=$no;");
 
		multiupload("rel_file", $path);

		header("location:./tea_view.php");
	}

	function display_answer(){
		global $COURSE_FILE_PATH;
		$no = $_GET['homework_no'];

		$tpl = new Smarty;

		$result = db_query("select homework_name, answer, begin_course_cd, ans_type from `homework` where homework_no=$no;");
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$tpl->assign("name", $row['homework_name']);
		download_relative_file($tpl, $COURSE_FILE_PATH, $row, $no);
		if($row['ans_type'] != ""){
			$_SESSION['current_path'] = $COURSE_FILE_PATH . $row['begin_course_cd'] . "/homework/$no/teacher/answer/";
			$row['answer'] = "<a href=\"/library/redirect_file.php?file_name=" . urlencode($row['answer']) . "\">".$row['answer']."</a>";
		}
		$tpl->assign("answer", $row['answer']);
		$tpl->assign("homework_no", $no);

		assignTemplate($tpl, "/assignment/tea_answer.tpl");
	}

	function download_relative_file($tpl, $FILE_PATH, $row, $no){
		//若此作業題目無任何上傳檔案則跳過此函式
		$path = $FILE_PATH . $row['begin_course_cd'] . "/homework/$no/teacher/answer/";
	  	if(is_dir($path) != 1)
			return ;

		$d = dir($path);
		while( ($entry = $d->read()) != false ){
			if( is_dir($entry) == false && $entry != $row['answer']){
			  	$file['name'] = $entry;
				$_SESSION['current_path'] = $path;
				$file['path'] = urlencode($entry);
				$tpl->append('file_data', $file);
			}
		}
	}

	function removeOldAnswer($cd, $no){
		global $DB_CONN;
		$path = answerPath($cd, $no);
		$file = $DB_CONN->getRow("select answer, ans_type from `homework` where homework_no=$no;", DB_FETCHMODE_ASSOC);
		if(empty($file['ans_type']))
			return -1;
		return unlink($path . $file['answer']);
	}

	function isExistAnswer($cd, $no){
		global $DB_CONN;
		$path = answerPath($cd, $no);
		$file = $DB_CONN->getRow("select ans_type from `homework` where homework_no=$no;", DB_FETCHMODE_ASSOC);
		if(empty($file['ans_type']))
			return false;
		return true;
	}
?>
