<?php
	/*author: lunsrot
	 *P.S. 若函式前無特別註明則作者均為lunsrot
	 */
/*modify by lunsrot at 2007/03/14*/
	require_once("../config.php");
	require_once("../session.php");
/*modify end*/
	include "ass_info.php";
	include "library.php";
	require_once("../library/co_learn_lib.php");
	include "../library/delete_data.php";

/*modify by rja at 2008/03/10*/
	require_once("../library/mail.php");
/*end of modify */

	checkMenu("/Assignment/tea_assignment.php");

	//get information from session
	$course_cd = $_SESSION['begin_course_cd'];
	//get information from $_GET
	$view = $_GET['view'];

	if($view == "true"){
		//get argument from $_GET
		$option = $_GET['option'];

		switch($option){
			case "next": display_next(); break;
			case "modify": display_update("modify"); break;
			case "view": viewAssignment($_GET['homework_no'], 1); break;
			case "delete": _delete($course_cd); break;
			default: break;
		}
	}else{
		//get argument from $_POST
		$option = $_POST['option'];

		switch($option){
		  	case "create": update("create"); break;
			case "modify": update("modify"); break;
			default: display_update("create"); break;
		}
	}

	function display_update($str){
	  	global $COURSE_FILE_PATH;
		$course_cd = $_SESSION['begin_course_cd'];
		$tpl = new Smarty;

		//新增作業
		if($str == "create"){
			$tmp = gettimeofday();
			$time = getdate($tmp['sec']);
			//預設公佈作業
			$tpl->assign("pub1", "checked");
			$tpl->assign("due0", "checked");
			$tpl->assign("q_type1", "checked");
			$tpl->assign("is_co0", "selected");
		}
		//修改作業
		else{
		  	$no = $_GET['homework_no'];
			//將homework_no存入session，以便modify database時使用
			$_SESSION['homework_no'] = $no;

		  	$result = db_query("select homework_name, d_dueday, percentage, question, late, public, q_type, begin_course_cd, is_co_learn from `homework` where homework_no=$no;");
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);

			if($row['q_type'] != ""){
				$tpl->assign('q_type1', "checked");
				$_SESSION['current_path'] = $COURSE_FILE_PATH . "$course_cd/homework/$no/teacher/question/";
				$tpl->assign('file_path', urlencode($row['question']));
			}else{
				$tpl->assign('q_type2', "checked");
			}
			$tpl->assign('homework_no', $no);
			$tpl->assign('q_type', $row['q_type']);

			$tpl->assign('name', $row[homework_name]);
			$tpl->assign('percent', $row[percentage]);
			$tpl->assign('question', $row['question']);
			$tpl->assign("due".$row['late'], "checked");
			$tpl->assign("pub".(Int)($row['public']/2), "checked");
			$tpl->assign("is_co" . $row['is_co_learn'], "selected");
			$tmp = strtotime($row[d_dueday]);
			$time = getdate($tmp);

			$tpl->assign('rel_file', "1");
			download_relative_file($tpl, $COURSE_FILE_PATH, $row, $no);
		}
		$tpl->assign("option", $str);
		$tpl->assign("due_date", "$time[year]-$time[mon]-$time[mday]");

		//數學方程式編輯器
		$tpl->assign("math", $_GET['math']);

		assignTemplate($tpl, "/assignment/ques_update.tpl");
	}

	function update($str){
	  	global $course_cd, $COURSE_FILE_PATH, $DB_CONN;
		$name = $_POST['name'];
		$percent = $_POST['percentage'];
		$date = $_POST['due_date']." 23:59:59";
		$content = $_POST['content'];
		$due = $_POST['due'];
		$pub = $_POST['pub'];
		$q_type = $_POST['q_type'];
		$ass_type = $_POST['ass_type'];
		//argument checking

		//新增作業
		if($str == "create"){
		  	if($name == "")
		    		exit(0);
			if(!checkAssignName($name, $course_cd, 0)){
				echo "名稱重複";
				echo "<span onclick=\"history.back();\" style=\"cursor:pointer;\">按此回上一頁</span>";
				exit(0);
			}

			$public = ($pub == 1) ? 2 : 0;

			$path = $COURSE_FILE_PATH . $course_cd . "/homework/";
			createPath($path . "tmp/");

			if($q_type == 1){
				if($_FILES['q_file']['error'] != 0){
					echo "檔案上傳失敗<br/>";
					echo "<span onclick=\"history.back();\" style=\"cursor:pointer;\">按此回上一頁</span>";
					exit(0);
				}
				$q_file = $_FILES['q_file']['name'];
				$ext = strrchr($q_file, '.');
				FILE_upload($_FILES['q_file']['tmp_name'], $path . "tmp/", $q_file);
				db_query("insert into homework (begin_course_cd, homework_name, question, percentage, late, d_dueday, public, q_type, is_co_learn) values ($course_cd, '$name', '$q_file', $percent, $due, '$date', $public, '$ext', $ass_type);");
			}else{
				db_query("insert into homework (begin_course_cd, homework_name, question, percentage, late, d_dueday, public, is_co_learn, q_type) values ($course_cd, '$name', '$content', $percent, $due, '$date', $public, $ass_type, '');");
			}

			$result = db_query("select homework_no from homework where begin_course_cd=$course_cd and homework_name='$name';");
			$row = $result->fetchRow();
			$_SESSION['homework_no'] = $row[0];

			//create entries in handin_homework
			$tmp = db_query("select personal_id from `take_course` where begin_course_cd=$course_cd and status_student=1 and allow_course=1;");
			while($tmp2 = $tmp->fetchRow()){
				db_query("insert into `handin_homework` (begin_course_cd, homework_no, personal_id) values ($course_cd, $_SESSION[homework_no], $tmp2[0]);");
			}
		
			//create a entry in course_percentage
			db_query("insert into `course_percentage` (begin_course_cd, percentage_type, percentage_num, percentage) values ($course_cd, 2, $row[0], $percent);");
			$number_id = db_getOne("select number_id from `course_percentage` where begin_course_cd=$course_cd and percentage_type=2 and percentage_num=$row[0];");

			//insert entry into course_concent_grade for each student
			$pids = db_query("select personal_id from `take_course` where begin_course_cd=$course_cd and status_student=1 and allow_course=1;");
			while($row = $pids->fetchRow(DB_FETCHMODE_ASSOC))
				db_query("insert into `course_concent_grade` (begin_course_cd, number_id, student_id, percentage_type, percentage_num) values ($course_cd, $number_id, $row[personal_id], 2, $_SESSION[homework_no]);");
			

			//create a file dictory
			$no = $_SESSION['homework_no'];
			createPath($path . $no . "/student");
			createPath($path . $no . "/teacher/answer");
			createPath($path . $no . "/teacher/question");

			multiupload("rel_file", $path . "tmp/");
 
			//move all file in tmp to homework_no/teacher
			FILE_move($COURSE_FILE_PATH, $course_cd, $no, "question");

			/*

				//modify by rja 
				//新增作業時，一併寄送 email 給修課學生

			 */
			//新增作業時，如果有選"公佈作業"時才寄信		
//先 check 這裡 public 要等於多少才是公佈
			if( 1||$public== 1 || $public == 3){

				//find all student's personal id
				$stuEmail= (flatArray(db_getAll("select email from `take_course`, personal_basic 
					where begin_course_cd=$course_cd and status_student=1 and allow_course=1 
					and take_course.personal_id = personal_basic.personal_id;")));


		$homeworkSubject = $_POST['name'];
		$homeworkDueDay = $_POST['due_date']." 23:59:59";

				$from= 'elearningtest@hsng.cs.ccu.edu.tw';
				$fromName= '學習平台';
				$to = $stuEmail;

				//不知道為什麼這裡要再 insert 一次，先暫時刪掉
				//db_query("insert into homework (begin_course_cd, homework_name, question, percentage, late, d_dueday, public, q_type, is_co_learn) values ($course_cd, '$name', '$q_file', $percent, $due, '$date', $public, '$ext', $ass_type);");

				$subject = "新作業通知";
				//寄信內容可以再斟酌，例如加上一些老師或課程名稱等資訊
				$message = <<<CODE
同學您好,
\n\n
老師發佈了新作業 "$homeworkSubject"，請在 $homeworkDueDay 之前完成。
\n\n
這是系統自動發出的信件，請勿回覆。
CODE;

				mailto($from , $fromName, $to, $subject, $message );

				//die('done');
			}

			/*
			//modify by rja 
			//add a calender event for teacher and all student.

			//新增作業的時候，也一併新增行事曆上對應的事件
				//後來改用了別的作法(在顯示行事曆時，順便去作業 table query)
				//這裡的 code 只是先留著，以後不用再砍掉

			//find all student's personal id
			$personalId= db_query("select personal_id from `take_course` where begin_course_cd=$course_cd and status_student=1 and allow_course=1;");
				
			$teaPersonalId= db_query("select teacher_cd from `teach_begin_course` where begin_course_cd=$course_cd ;");
			

			list($calYear, $calMonth, $calDay) = explode('-', $_POST['due_date']);
			//下面註解只是個從 calendar 那邊的程式來的範例
			//$notify = date('Y-m-d',mktime( 0, 0, 0, $month, $day - $_POST['day'], $year));
			$calNotify= $_POST['due_date'];
			$calNotifyNum=2;
			$calContent=$content;
			//insert into calender
			while($row = $personalId->fetchRow(DB_FETCHMODE_ASSOC)){
				$sql = "INSERT INTO calendar (personal_id, year, month, day, content, notify, notify_num) VALUES ('".         $row[personal_id]."','".$calYear."','".$calMonth."','".$calDay."','".$calContent."','".$calNotify."','".$calNotifyNum."' );";
				db_query($sql);
			}
			
			while($row = $teaPersonalId->fetchRow(DB_FETCHMODE_ASSOC)){
				$sql = "INSERT INTO calendar (personal_id, year, month, day, content, notify, notify_num) VALUES ('".         $row[teacher_cd]."','".$calYear."','".$calMonth."','".$calDay."','".$calContent."','".$calNotify."','".$calNotifyNum."' );";
				db_query($sql);
			}
			// end of modify by rja
			 */









			if($ass_type == 0)
				header("location:./tea_assignment.php?view=true&option=next");
			else
				header("location:../Collaborative_Learning/teacher/new_project.php");
		}
		//修改作業
		else{
		  	$no = $_SESSION['homework_no'];
			session_unregister("homework_no");

			if(!checkAssignName($name, $course_cd, $no)){
				echo "名稱重複";
				exit(0);
			}
			
			$result = db_query("select public from `homework` where homework_no=$no");
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$public = (Int)($row['public']/2) + $pub*2;

			$path = $COURSE_FILE_PATH . $course_cd . "/homework";
			if($q_type == 1){
				$row = $DB_CONN->getRow("select q_type, question from `homework` where homework_no=$no;", DB_FETCHMODE_ASSOC);
				$q_file = $_FILES['q_file']['name'];
				if($_FILES['q_file']['error'] == 0){
					deleteOldQuestion($path, $no);
					$ext = strrchr($q_file, '.');
					FILE_upload($_FILES['q_file']['tmp_name'], "$path/$no/teacher/question/", $q_file);
				}else if(!empty($row['q_type'])){
				  	$q_file = $row['question'];
					$ext = $row['q_type'];
				}else{
				  	echo "請上傳檔案<br/>";
				  	exit(0);
				}
				db_query("update `homework` set homework_name='$name', d_dueday='$date', percentage=$percent, question='$q_file', late=$due, public=$public, q_type='$ext', is_co_learn=$ass_type where homework_no=$no;");
			}else{
				deleteOldQuestion($path, $no);
				db_query("update `homework` set homework_name='$name', d_dueday='$date', percentage=$percent, question='$content', late=$due, public=$public, is_co_learn=$ass_type, q_type='' where homework_no=$no;");
			}

			$number_id = $DB_CONN->getOne("select number_id from `course_percentage` where begin_course_cd=$course_cd and percentage_type=2 and percentage_num=$no;");
			db_query("update `course_percentage` set percentage=$percent where begin_course_cd=$course_cd and number_id=$number_id;");

			multiupload("rel_file", $COURSE_FILE_PATH.$course_cd."/homework/$no/teacher/question/");




			/*

			//modify by rja 
			//add a calender event for teacher and all student.
			//修改作業的時候，也一併修改行事曆上對應的事件
				//後來改用了別的作法(在顯示行事曆時，順便去作業 table query)
				//這裡的 code 只是先留著，以後不用再砍掉


			//find all student's personal id
			$personalId= db_query("select personal_id from `take_course` where begin_course_cd=$course_cd and status_student=1 and allow_course=1;");
			$teaPersonalId= db_query("select teacher_cd from `teach_begin_course` where begin_course_cd=$course_cd ;");
			

			list($calYear, $calMonth, $calDay) = explode('-', $_POST['due_date']);
			//下面註解只是個從 calendar 那邊的程式來的範例
			//$notify = date('Y-m-d',mktime( 0, 0, 0, $month, $day - $_POST['day'], $year));
			$calNotify= $_POST['due_date'];
			$calNotifyNum=2;
			$calContent=$content;
			//insert into calender
			while($row = $personalId->fetchRow(DB_FETCHMODE_ASSOC)){
				$sql = "DELETE FROM calendar WHERE 
					personal_id = $row[personal_id] 
					AND year = $calYear 
					AND month = $calMonth
					AND day = $calDay
					AND content = $calContent ;";
				db_query($sql);
			}
			
			while($row = $teaPersonalId->fetchRow(DB_FETCHMODE_ASSOC)){
				$sql = "DELETE FROM calendar WHERE 
					personal_id = $row[teacher_id] 
					AND year = $calYear 
					AND month = $calMonth
					AND day = $calDay
					AND content = $calContent ;";
				db_query($sql);
			}

			 */






			$num = $DB_CONN->getOne("select count(*) from `project_data` where begin_course_cd=$course_cd and homework_no=$no;");
			if($ass_type == 1 && $num != 0){ 
				$key = check_get_produce_key($no,"tea");
				header("location:../Collaborative_Learning/teacher/modify_project_data.php?homework_no=$no&key=$key");
			}else if($ass_type == 1){
				$_SESSION['homework_no'] = $no;
				header("location:../Collaborative_Learning/teacher/new_project.php");
			}else
				header("location:./tea_view.php");
		}
	}

	function display_next(){
		$tpl = new Smarty;
		$no = $_SESSION['homework_no'];
		$tpl->assign("homework_no", $no);
		session_unregister("homework_no");

		assignTemplate($tpl, "/assignment/tea_next.tpl");
	}

	function _delete($course_cd){
	  	global $COURSE_FILE_PATH, $DB_CONN;
		$course_cd = $_SESSION['begin_course_cd'];
	  	$no = $_GET['homework_no'];
        delete_assignment($course_cd, $no);
        system_log("rm -Rf $COURSE_FILE_PATH" . "$course_cd/homework/$no");
		exec("rm -Rf $COURSE_FILE_PATH" . "$course_cd/homework/$no");
		header("location:./tea_view.php");
	}

	function download_relative_file($tpl, $FILE_PATH, $row, $no){
		//若此作業題目無任何上傳檔案則跳過此函式
		$path = $FILE_PATH . $row['begin_course_cd'] . "/homework/$no/teacher/question/";
	  	if(is_dir($path) != 1)
			return ;

		$d = dir($path);
		while( ($entry = $d->read()) != false ){
			if( is_dir($entry) == false && $entry != $row['question']){
			  	$file['name'] = $entry;
				$_SESSION['current_path'] = $path;
				$file['path'] = URLENCODE($entry);
				$tpl->append('file_data', $file);
			}
		}
	}

	function checkAssignName($name, $course_cd, $type){
	  	$check = isAssignExist($name, $course_cd);
		if($check != 0 && $type != $check)
		  	return false;
		return true;
	}

	function isAssignExist($name, $course_cd){
	  	$result = db_query("select homework_no from `homework` where begin_course_cd=$course_cd and homework_name='$name';");
		if($result->numRows() != 0){
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			return $row['homework_no'];
		}
		return 0;
	}

	function deleteOldQuestion($path, $no){
	  	$result = db_query("select q_type, question from `homework` where homework_no=$no");
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		if(empty($row['q_type']))
		  	return ;
  	 	unlink($path . "/" . $no . "/teacher/question/" . $row['question']);
	}
?>
