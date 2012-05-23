<?php
	/*author: lunsrot
	 * date: 2007/07/24
	 */
	require_once("../../config.php");
	require_once("../../session.php");
	require_once("../lib/co_learn_lib.php");

	checkMenu("/Collaborative_Learning/student/stu_main_page.php");

	global $DB_CONN;
	$input = $_GET;
	$course_cd = $_SESSION['begin_course_cd'];

	if(!empty($input['homework_no'])){
	  $tpl = new Smarty;
	  $no = $input['homework_no'];
	  $course_cd = $_SESSION['begin_course_cd'];

	  $res = $DB_CONN->getRow("select * from `homework` where homework_no=$no;", DB_FETCHMODE_ASSOC);
	  $tpl->assign("homework_no", $res['homework_no']);
	  $group_no = $DB_CONN->getOne("select group_no from `groups_member` where begin_course_cd=$course_cd and homework_no=$no and student_id=$_SESSION[personal_id];");
	  $tpl->assign("group_no", $group_no);
	  
	  $resource = showResource($course_cd, $no, $group_no);
	  $tpl->assign("relatives", $resource);

	  assignTemplate( $tpl, "/collaborative_learning/student/relative.tpl");
	}else{
	  $input = $_POST;
	  switch($input['option']){
	  case "upload": upload($input); break;
	  case "delete": _delete($input); break;
	  default: break;
	  }
	}

	function showResource($course_cd, $no, $group_no){
		global $COURSE_FILE_PATH;
		$path = "$COURSE_FILE_PATH$course_cd/homework/$no/student/$group_no/";
		$output = array();

		if(is_dir($path) != 1)
			return ;

		$d = dir($path);
		while(($entry = $d->read()) != false){
			if(is_dir($entry) == 1 || substr($entry, 0, 8) != "resource")
				continue;
			$tmp = array();
			$date = getdate(fileatime($path . $entry));
			$tmp['upload_time'] = "$date[year]-$date[mon]-$date[mday] $date[hours]:$date[minutes]:$date[seconds]";
			$tmp['file_path'] = $path . $entry;
			$_SESSION['current_path'] = $path;
			$encode_name = urlencode($entry);
			$tmp['file_name'] = $entry;
			$tmp['encode_name'] = $encode_name;
			array_push($output, $tmp);
		}
		return $output;
	}

	function upload($input){
	  global $COURSE_FILE_PATH;
	  $course_cd = $_SESSION['begin_course_cd'];
	  $no = $input['homework_no'];
	  $group_no = $input['group_no']; 
	  $path = "$COURSE_FILE_PATH$course_cd/homework/$no/student/$group_no/";
	  createPath($path);

	  for($i = 0 ; $i < count($_FILES['resource']['error']) ; $i++){
		  if($_FILES['resource']['error'][$i] != 0)
			  continue;
		  $now = date("mdHis");
		  $file = "resource_$now" . "_" . $_FILES['resource']['name'][$i];
		  FILE_upload($_FILES['resource']['tmp_name'][$i], $path, $file);
	  }
	  $key = check_get_produce_key($no, "stu");
	  header("location:relative.php?homework_no=$no&key=$key");
	}

	function _delete($input){
	  global $COURSE_FILE_PATH;
	  $course_cd = $_SESSION['begin_course_cd'];
	  $no = $input['homework_no'];
	  $group_no = $input['group_no']; 
	  $path = "$COURSE_FILE_PATH$course_cd/homework/$no/student/$group_no/";
	  createPath($path);

	  for($i = 0 ; $i < count($input['resource']) ; $i++)
		  unlink($path . $input['resource'][$i]);
	  
	  $key = check_get_produce_key($no, "stu");
	  header("location:relative.php?homework_no=$no&key=$key");
	}
?>
