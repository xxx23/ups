<?php
	/*author: lunsrot
	 * date: 2008/02/16
	 */

    require_once("../config.php");
	require_once("../session.php");

	require_once("../library/delete_data.php");

    $input = $_POST;
	call_user_func($input['option'], $input);

	//function
    function reset_course($input){
        global $COURSE_FILE_PATH;
		$course_cd = $input['check'];
		for($i = 0 ; $i < count($course_cd) ; $i++){
			//刪除資料庫相關欄位
			_delete_course_by_course_cd($course_cd[$i]);
			//刪除資料夾內所有檔案，並保留begin_course_cd的資料夾
			$dir = $COURSE_FILE_PATH . $course_cd[$i];
			if(!$dh = @opendir($dir))	continue;
			while( ($obj = readdir($dh)) ){
				if($obj=='.' || $obj=='..') continue;
				if(!@unlink($dir.'/'.$obj)) SureRemoveDir($dir.'/'.$obj, false);
			}
		}

		$tpl = new Smarty;
		assignTemplate($tpl, "/course_admin/after_reset_course.tpl");
	}

	//function
	function _delete_course($input){
        global $COURSE_FILE_PATH;
		$course_cd = $input['check'];
		for($i = 0 ; $i < count($course_cd) ; $i++){
			//刪除資料庫相關欄位
			_delete_course_by_course_cd($course_cd[$i]);
			db_query("delete from `teach_begin_course` where begin_course_cd=$course_cd[$i];");
			db_query("delete from `class_content_current` where begin_course_cd=$course_cd[$i];");
			db_query("delete from `begin_course` where begin_course_cd=$course_cd[$i];");
			//刪除資料夾內所有檔案，包含begin_course_cd的資料夾
			$dir = $COURSE_FILE_PATH . $course_cd[$i];
			SureRemoveDir($dir, true);
		}

		$tpl = new Smarty;
		assignTemplate($tpl, "/course_admin/after_reset_course.tpl");
	}

	//library
    function _delete_course_by_course_cd($course_cd){
		//與成績無關
		delete_survey_by_course_cd($course_cd);
		delete_textbook($course_cd);
		delete_course_news($course_cd);
		delete_course_learning_tracking($course_cd);
		delete_course_discuss_area($course_cd);
		delete_course_epaper($course_cd);
		delete_course_certificate($course_cd);
		//與成績相關，依序為點名、線上測驗、線上作業(含合作學習)、成績總紀錄
		delete_course_roll_book($course_cd);
		delete_examine_by_course_cd($course_cd);
		delete_assignment_by_course_cd($course_cd);
		delete_course_grade($course_cd);
		//刪除學生與課程的連結，保留教師、教材、課程說明、助教
		db_query("delete from `take_course` where begin_course_cd=$course_cd;");
		db_query("delete from `course_schedule` where begin_course_cd=$course_cd;");
	}
?>
