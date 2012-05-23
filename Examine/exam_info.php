<?php
	require_once("../config.php");
	require_once("../session.php");
	require_once("../library/lib_course_pass.php");
	global $version;
	$version = array("temp1");

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
	 * date: 2007/07/01
	 */
	function examineOperator($course_cd, $test_no, $pid, $isreply, $iscorrect, $answer){
		global $DB_CONN;
		$tpl = new Smarty;

		$tpl->assign("test_no", $test_no);
		$result = $DB_CONN->query("select * from `test_course` where begin_course_cd=$course_cd and test_no=$test_no order by sequence;");
		$i = 1;
		while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
			$output = allQuestionDisplay($row, $i++);
			$output = questionDisplay($output, $row);
			//電腦閱卷
			if($iscorrect){
				$tmp = examineCorrect($course_cd, $test_no, $pid, $output['type'], $row, $answer[ 'question_' . $output['sequence'] ]);
				$output = array_merge($output, $tmp);
			}
			$tpl->append("exam_data", $output);
		}
		$tpl->assign("isreply", $isreply);
		//$tpl->assign("iscorrect", $iscorrect);

		if($iscorrect == 1){

			//先check是不是自我評量，若是則 redirect 走
			$check_selft_exam = $DB_CONN->getOne("select test_type from `test_course_setup` where begin_course_cd=$course_cd and test_no=$test_no ;");
			if($check_selft_exam == 1) 
				header("location:stu_view.php");
			//end of check

			$grade = $DB_CONN->getOne("select sum(grade) from `test_course_ans` where begin_course_cd=$course_cd and test_no=$test_no and personal_id=$pid;");
			$tpl->assign("grade", $grade);
			if(!is_numeric($grade))
				$grade = 0;
			$number_id = $DB_CONN->getOne("select number_id from `course_percentage` where begin_course_cd=$course_cd and percentage_type=1 and percentage_num=$test_no;");
			
			$sql="SELECT COUNT(*) FROM course_concent_grade WHERE begin_course_cd=$course_cd AND number_id = $number_id AND percentage_num = $test_no AND student_id = $pid";
			$hasTest = db_getOne($sql);
			
			if($hasTest==0)
				db_query("insert into `course_concent_grade` (begin_course_cd, number_id, percentage_type, percentage_num, student_id, concent_grade) values ($course_cd, $number_id, 1, $test_no, $pid, '$grade');");
			else
				db_query("UPDATE  `course_concent_grade` SET concent_grade=$grade WHERE begin_course_cd=$course_cd AND number_id=$number_id AND percentage_type=1 AND percentage_num=$test_no AND student_id=$pid;");
			
			//判斷學生成績是否已經達到通過標準，如果有會將take course的pass設成1
			//add by Samuel @2009/07/20/*
			
			$attribute = db_getOne("SELECT attribute FROM begin_course WHERE begin_course_cd={$course_cd}");
			if($attribute == 0){//自學	
				$course_score = getScore($course_cd,$pid,0);
				$pass_score = db_getOne("SELECT criteria_total FROM begin_course WHERE begin_course_cd = '$course_cd'");
				echo "$course_score  $pass_score";
				if($course_score >= $pass_score )
					setSelfCoursePass($course_cd,$pid);
			} 

			header("location:stu_view.php");
 		}
        
        $end_time = db_getOne("SELECT UNIX_TIMESTAMP(d_test_end) FROM test_course_setup WHERE begin_course_cd='{$course_cd}' AND test_no='{$test_no}'; ");
        
        $tpl->assign('end_time',empty($end_time)?0:$end_time); 
        
        assignTemplate($tpl, "/examine/display_examine.tpl");
	}
	




	
	/*author: lunsrot
	 * date: 2007/07/01
	 */
	function allQuestionDisplay($row, $num){
		global $HOME_PATH, $COURSE_FILE_PATH;
		
		$file_path = '../'.basename($COURSE_FILE_PATH). '/';

		$out = "";
		$string = array("單選題", "複選題", "是非題", "填充題", "問答題");
		$out['num'] = $num;
		$out['sequence'] = $row['sequence'];
		$out['question'] = $row['question'];
		$out['grade'] = $row['grade'];
		$out['type'] = $row['test_type'];
		if($out['type'] == 1)
			$out['type'] = $row['is_multiple'];
		$out['type_string'] = $string[ $out['type'] ];

		$out['hasPicture'] = 0;
		if(!empty($row['file_picture_name'])){
			$out['hasPicture'] = 1;
			$out['picture'] = "$file_path{$row['begin_course_cd']}/examine/$row[file_picture_name]";
		}

		$out['hasVideo'] = 0;
		if(!empty($row['file_av_name'])){
			$out['hasVideo'] = 1;
			$out['video'] = "$file_path{$row['begin_course_cd']}/examine/$row[file_av_name]";
		}
		return $out;
	}

	/*author: lunsrot
	 * date: 2007/07/01
	 */
	function questionDisplay($output, $row){
		$function = array("select", "select", "answer", "stuff", "answer");
		return call_user_func($function[ $output['type'] ], $output, $row);
	}

	/*author: lunsrot
	 * date: 2007/07/01
	 * 選擇題
	 */
	function select($output, $row){
		$answers = "";
		for($i = 1 ; $i <= $row['selection_no'] ; $i++){
			$answer = "";
			$answer['number'] = $i;
			$answer['content'] = $row["selection" . $i];
			$answers[$i] = $answer;
		}
		$output['answers'] = $answers;
		return $output;
	}

	/*author: lunsrot
	 * date: 2007/07/01
	 * 填充題
	 */
	function stuff($output, $row){
		$answers = "";
		for($i = 1 ; $i <= $row['selection_no'] ; $i++){
			$answer = "";
			$answer['number'] = $i;
			$answers[$i] = $answer;
		}
		$output['answers'] = $answers;
		return $output;
	}

	/*author: lunsrot
	 * date: 2007/07/01
	 * 問答題、是非題，皆不需任何處理
	 */
	function answer($output, $row){
		return $output;
	}

	/*author: lunsrot
	 * date: 2007/07/02
	 */
	function examineCorrect($course_cd, $test_no, $pid, $type, $row, $answer){
		$function = array("correctSingle", "correctMultiple", "correctSingle", "correctStuff", "recordAnswer");
		return call_user_func($function[ $type ], $course_cd, $test_no, $pid, $row, $answer);
	}

	/*author: lunsrot
	 * date: 2007/07/01
	 * 單選題和是非題的閱卷方式相同
	 */
	function correctSingle($course_cd, $test_no, $pid, $row, $answer){
		$grade = 0;
		if($answer == $row['answer'])
			$grade = $row['grade'];
			
		$sql="SELECT COUNT(*) FROM test_course_ans WHERE begin_course_cd=$course_cd  AND test_no = $test_no AND personal_id = $pid AND test_bankno=$row[test_bankno] ;";
		$hasAns = db_getOne($sql);
			
		if($hasAns==0)
			db_query("insert into `test_course_ans` (answer, grade, begin_course_cd, test_no, personal_id, test_bankno) values ('$answer', '$grade', $course_cd, $test_no, $pid, $row[test_bankno]);");
		else
			db_query("UPDATE`test_course_ans` SET answer='$answer',grade='$grade' WHERE begin_course_cd=$course_cd AND test_no = $test_no AND personal_id = $pid AND test_bankno=$row[test_bankno];");
		
		return array("get_grade" => $grade, "reply" => $answer, "ans" => $row['answer']);
	}

	/*author: lunsrot
	 * date: 2007/07/01
	 * 簡答題僅需寫入回答即可
	 */
	function recordAnswer($course_cd, $test_no, $pid, $row, $answer){
		$sql="SELECT COUNT(*) FROM test_course_ans WHERE begin_course_cd=$course_cd  AND test_no = $test_no AND personal_id = $pid AND test_bankno=$row[test_bankno] ;";
		$hasAns = db_getOne($sql);
			
		if($hasAns==0)
			db_query("insert into `test_course_ans` (answer, grade, begin_course_cd, test_no, personal_id, test_bankno) values ('$answer', '$grade', $course_cd, $test_no, $pid, $row[test_bankno]);");
		else
			db_query("UPDATE `test_course_ans` SET answer='$answer',grade='$grade' WHERE begin_course_cd=$course_cd AND test_no = $test_no AND personal_id = $pid AND test_bankno=$row[test_bankno];");
		
		return array();
	}

	/*author: lunsrot
	 * date: 2007/07/03
	 * 複選題
	 */
	function correctMultiple($course_cd, $test_no, $pid, $row, $answer){
		$grade = 0;
		$tmp = explode(";", $row['answer']);
		$union = array_unique(array_merge($answer, $tmp));
		$intersect = array_intersect($answer, $tmp);
		//row['selection_no']表示回答總數，
		//減去聯集個數表示不該勾選，而學生也的確沒有勾選，加上交集表示需勾選而學生也有勾選
		$right = $row['selection_no'] - count($union) + count($intersect);
		if($row['selection_no'] > 0)
			$grade = round(($right * $row['grade']) / $row['selection_no']);
		$tmp = "";
		for($i = 0 ; $i < count($answer) ; $i++)
			$tmp .= $answer[$i] . ";";
			
		$sql="SELECT COUNT(*) FROM test_course_ans WHERE begin_course_cd=$course_cd  AND test_no = $test_no AND personal_id = $pid AND test_bankno=$row[test_bankno] ;";
		$hasAns = db_getOne($sql);
			
		if($hasAns==1)
			db_query("UPDATE `test_course_ans` SET answer='$tmp',grade='$grade' WHERE begin_course_cd=$course_cd AND test_no = $test_no AND personal_id = $pid AND test_bankno=$row[test_bankno];");
		else
			db_query("insert into `test_course_ans` (answer, grade, begin_course_cd, test_no, personal_id, test_bankno) values ('$tmp', '$grade', $course_cd, $test_no, $pid, $row[test_bankno]);");
		
			
		
		
		return array("get_grade" => $grade, "reply" => $tmp, "ans" => $row['answer']);
	}

	/*author: lunsrot
	 * date: 2007/07/03
	 * 電腦閱卷的填充題部份
	 */
	function correctStuff($course_cd, $test_no, $pid, $row, $answer){
		$grade = -1;
		$right = 0;

		if($row['if_ans_seq'] == 1){
			for($i = 1 ; $i <= $row['selection_no'] ; $i++)
				if($row['selection' . $i] == $answer[$i - 1])
					$right = $right + 1;
		}else{
			$tmp = array();
			for($i = 1 ; $i <= $row['selection_no'] ; $i++)
				$tmp[$i - 1] = $row['selection' . $i];
			$tmp = array_intersect($tmp, $answer);
			$right = count($tmp);
		}

		if($row['selection_no'] > 0)
			$grade = round(($right * $row['grade']) / $row['selection_no']);
		$tmp = "";
		for($i = 0 ; $i < count($answer) ; $i++)
			$tmp .= $answer[$i] . ";";
			
			
		$sql="SELECT COUNT(*) FROM test_course_ans WHERE begin_course_cd=$course_cd  AND test_no = $test_no AND personal_id = $pid AND test_bankno=$row[test_bankno] ;";
		$hasAns = db_getOne($sql);
			
		if($hasAns==1)
			db_query("UPDATE `test_course_ans` SET answer='$tmp',grade='$grade' WHERE begin_course_cd=$course_cd AND test_no = $test_no AND personal_id = $pid AND test_bankno=$row[test_bankno];");
		else
			db_query("insert into `test_course_ans` (answer, grade, begin_course_cd, test_no, personal_id, test_bankno) values ('$tmp','$grade', $course_cd, $test_no, $pid, $row[test_bankno]);");
			
		$rep = $ans = "";
		for($i = 1; $i <= $row['selection_no'] ; $i++){
			$rep .= $row['selection' . $i] . ";";
			$ans .= $answer[$i - 1] . ";";
		}
		return array("get_grade" => $grade, "reply" => $rep, "ans" => $ans);
	}

	/*author: lunsrot
	 * date: 2007/07/06
	 * 將檔案和個人資料夾中複製到測驗專屬的位置
	 */
	function copyFile($file_name, $pid, $course_cd, $test_no){
		global $DATA_FILE_PATH, $COURSE_FILE_PATH;
		//檢查檔案是否存在
		$file = "$DATA_FILE_PATH$pid/test_bank/$file_name";
		if(!file_exists($file))
			return -1;
		$path = "$COURSE_FILE_PATH$course_cd/examine/";
		createPath($path);
		if(!file_exists($path . $file_name)){
			copy($file,  $path . $file_name);
			chmod($path . $file_name, 0775);
		}
		return 1;
	}
	
	function get_current_content_cd($begin_course_cd) 
	{
		if( empty($begin_course_cd) or $begin_course_cd ==0 ) {
			$begin_course_cd = $_SESSION['begin_course_cd']; 
		}
		$get_content_cd = " SELECT content_cd from class_content_current where begin_course_cd=$begin_course_cd";
		$result = db_query($get_content_cd);
		if($result->numRows() != 1){
			return 0;
		}
		else{ 
			$row = $result->fetchRow();
			return $row[0];
		}
	}
	
?>
