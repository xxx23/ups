<?php
	/* Argument:
	 *	$tpl: template file
	 *	$time: current time
	 * Purpose:
	 *	Display the <select> of year, month, date in create.tpl
	 * Return:
	 *	None 
	 */
	function displayTime($tpl, $time){
		$month = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
		$month_list = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
		$date = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31);
		$date_list = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");

		$tpl->assign("year_list", array($time['year'], $time['year']+1));
		$tpl->assign("year", array($time['year'], $time['year']+1));
		$tpl->assign("now_year", $time['year']);
		$tpl->assign("month_list", $month_list);
		$tpl->assign("month", $month);
		$tpl->assign("now_month", $time['mon']);
		$tpl->assign("date_list", $date_list);
		$tpl->assign("date", $date);
		$tpl->assign("now_date", $time['mday']);
	}

	/*author: lunsrot
	 */
	function timecmp($time1, $time2){
		if($time1 > $time2)
			return 1;
		else if ($time1 < $time2)
			return -1;
		return 0;
	}

	/*author: lunsrot
	 */
	function FILE_move($COURSE_FILE_PATH, $course_cd, $no, $location){
		$path = $COURSE_FILE_PATH . $course_cd . "/homework/$no/teacher/$location";
		createPath($path);
		exec("mv $COURSE_FILE_PATH"."$course_cd/homework/tmp/* $COURSE_FILE_PATH"."$course_cd/homework/$no/teacher/$location");
	}

	/*author: lunsrot
	 */
	function multiupload($name, $FILE_PATH){
		$c = count($_FILES[$name]['name']);
		for( $i = 0 ; $i < $c ; $i++){
			$q_file = $_FILES[$name]['name'][$i];
			if($q_file == "")
				continue;
			FILE_upload($_FILES[$name]['tmp_name'][$i], $FILE_PATH, $q_file);
		}
	}

	/*author: lunsrot
	 * date: 2007/06/28
	 */
	function answerPath($course_cd, $homework_no){
		global $COURSE_FILE_PATH;
		return $COURSE_FILE_PATH . $course_cd . "/homework/$homework_no/teacher/answer/";
	}

	/*author: lunsrot
	 * date: 2007/06/28
	 */
	function replyPath($course_cd, $homework_no, $personal_id){
		global $COURSE_FILE_PATH, $DB_CONN;
		$login_id = $DB_CONN->getOne("select login_id from `register_basic` where personal_id=$personal_id;");
		if(empty($login_id))
			return -1;
		return "$COURSE_FILE_PATH$course_cd/homework/$homework_no/student/$login_id/";
	}

	/*author: lunsrot
	 * date: 2007/06/28
	 */
	function downloadRelativeFile($tpl, $path, $file){
		if(is_dir($path) != 1)
			return -1;
		$d = dir($path);
		while(($entry = $d->read()) != false){
			if( is_dir($entry) == false && $entry != $file){
				$output['name'] = $entry;
				$output['path'] = urlencode($entry);
				$tpl->append("file_data", $output);
			}
		}
	}
?>
