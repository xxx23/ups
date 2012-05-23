<?php
	/*author: lunsrot
	 * date: 2007/07/03
	 */
	require_once("exam_info.php");

	global $DB_CONN, $COURSE_FILE_PATH, $HOME_PATH;
	$path = substr($COURSE_FILE_PATH, strlen($HOME_PATH) - 1);
	$tpl = new Smarty;
	$input = $_GET;
	$course_cd = $_SESSION['begin_course_cd'];
	$role_cd = $_SESSION['role_cd'];
	$test_no = $input['test_no'];

	$result = $DB_CONN->query("select * from `test_course` where begin_course_cd=$course_cd and test_no=$test_no order by sequence;");
	$i = 1;
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		$output = allQuestionDisplay($row, $i++);
		$output = questionDisplay($output, $row);
		if($output['type'] != 3)
			$output['ans'] = $row['answer'];
		else
			$output['ans'] = _stuff($row);

		$output['hasPicture'] = 0;
		if(!empty($row['file_picture_name'])){
			$output['hasPicture'] = 1;
			$output['picture'] = $path . "$row[begin_course_cd]/examine/$row[file_picture_name]";
		}

		$output['hasVideo'] = 0;
		if(!empty($row['file_av_name'])){
			$output['hasVideo'] = 1;
			$output['video'] = $path . "$row[begin_course_cd]/examine/$row[file_av_name]";
		}
		$tpl->append("exam_data", $output);
	}
	if($role_cd == 3)
		$tpl->assign("location", "stu_view.php");
	else
		$tpl->assign("location", "tea_view.php");

	assignTemplate($tpl, "/examine/viewAnswer.tpl");

	/*僅填充題的解答需另外處理*/
	function _stuff($row){
		$tmp = "";
		for($i = 1 ; $i <= $row['selection_no'] ; $i++)
			$tmp .= $row['selection' . $i] . ";";
		return $tmp;
	}
?>
