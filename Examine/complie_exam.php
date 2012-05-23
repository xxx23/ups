<?php
	/*author: lunsrot
	 * date: 2007/09/14
	 */
	require_once("../config.php");
	require_once("../session.php");

	include "exam_info.php";

	$input = $_GET;
	if(empty($input['option']))	$input['option'] = "list_questions";
	call_user_func($input['option'], $input);

	//template
	//列出此次測驗的所有題目
	function list_questions($input){
		$tpl = new Smarty;
		$course_cd = $_SESSION['begin_course_cd'];
		$_SESSION['test_no'] = $test_no = $input['test_no'];

		$seq = get_sequence_list($course_cd, $input['test_no']);
		display_questions($tpl, $seq, "single", 0, $course_cd, $test_no);
		display_questions($tpl, $seq, "multi", 1, $course_cd, $test_no);
		display_questions($tpl, $seq, "yesno", 2, $course_cd, $test_no);
		$tpl->assign("test_no", $test_no);
		assignTemplate($tpl, "/examine/list_questions.tpl");
	}

	//template
	//特定題目的所有學生回答情形
	function display_question($input){
		global $DB_CONN;
		$course_cd = $_SESSION['begin_course_cd'];
		$test_no = $_SESSION['test_no'];
		$tpl = new Smarty;

		//assign question
		$tmp = $DB_CONN->getRow("select * from `test_course` where begin_course_cd=$_SESSION[begin_course_cd] and test_no=$_SESSION[test_no] and sequence=$input[sequence];", DB_FETCHMODE_ASSOC);
		$d = allQuestionDisplay($tmp, $input['sequence']);
		$d = questionDisplay($d, $tmp);
		$d['ans'] = $tmp['answer'];
		$tpl->assign("data", $d);

		//assign student answer
		$no = $DB_CONN->getOne("select test_bankno from `test_course` where begin_course_cd=$course_cd and test_no=$test_no and sequence=$input[sequence];");
		$res = db_query("select r.login_id, r.personal_id, p.personal_name from `register_basic` r, `personal_basic` p where r.personal_id=p.personal_id and r.personal_id in (select personal_id from `take_course` where begin_course_cd=$course_cd and allow_course='1' and status_student='1');");
		while($r = $res->fetchRow(DB_FETCHMODE_ASSOC)){
			$ans = $DB_CONN->getOne("select answer from `test_course_ans` where begin_course_cd=$course_cd and test_no=$test_no and test_bankno=$no and personal_id=$r[personal_id];");
			$r['answer'] = (empty($ans) && !is_numeric($ans)) ? "" : $ans;
			$tpl->append("stu", $r);
		}

		$tpl->assign("test_no", $test_no);
		assignTemplate($tpl, "/examine/display_question.tpl");
	}

	//template
	//所有學生列表
	function display_students($input){
		global $DB_CONN;
		$course_cd = $_SESSION['begin_course_cd'];
		$tpl = new Smarty;

		$result = db_query("select A.personal_id, A.login_id, B.personal_name from `register_basic` A, `personal_basic` B where A.personal_id=B.personal_id and B.personal_id in (select personal_id from `take_course` where begin_course_cd=$course_cd and allow_course='1' and status_student='1');");
		while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
			$grade = $DB_CONN->getOne("select concent_grade from `course_concent_grade` where begin_course_cd=$course_cd and student_id=$row[personal_id] and number_id in (select number_id from `course_percentage` where begin_course_cd=$course_cd and percentage_type=1 and percentage_num=$input[test_no]);");
			$row['grade'] = $grade;
			//學生是否已回答
			$row['isreply'] = 1;
			if(!is_numeric($grade) || ($grade!=0 && empty($grade))){
				$row['grade'] = "未測驗";
				$row['isreply'] = 0;
			}
			$tpl->append("people", $row);
		}
		$tpl->assign("test_no", $input['test_no']);
		$tpl->assign("course_cd", $course_cd);

		assignTemplate($tpl, "/examine/display_students.tpl");
	}

	//template
	//特定學生的回答情形
	function student_reply($input){
		global $DB_CONN;
		$course_cd = $_SESSION['begin_course_cd'];
		$test_no = $_SESSION['test_no'];
		$tpl = new Smarty;

		$result = $DB_CONN->query("select * from `test_course` where begin_course_cd=$course_cd and test_no=$test_no order by sequence;");
		$i = 1;
		while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
			$output = allQuestionDisplay($row, $i++);
			$output = questionDisplay($output, $row);
			$output['ans'] = $row['answer'];
			$output['reply'] = $DB_CONN->getOne("select answer from `test_course_ans` where begin_course_cd=$course_cd and test_no=$test_no and personal_id=$input[pid] and test_bankno=$row[test_bankno];");
			$output = extra_number_people($output, get_question_context($course_cd, $test_no, $row['sequence']));
			$tpl->append("exam_data", $output);
		}
		$tpl->assign("test_no", $test_no);
		assignTemplate($tpl, "/examine/student_reply.tpl");
	}

	//template
	//列出此選項的所有學生
	function list_select_student($input){
		$tpl = new Smarty;
		$list = get_selection_context($_SESSION['begin_course_cd'], $_SESSION['test_no'], $input['sequence'], $input['index']);
		$tpl->assign("stu", $list['student_list']);
		assignTemplate($tpl, "/examine/list_select_student.tpl");
	}

	//template
	//設計上的失誤，因複選題的答對學生計算方式和其他兩者不同，故另開一個功能
	function list_right_student($input){
		global $DB_CONN;
		$tpl = new Smarty;
		$course_cd = $_SESSION['begin_course_cd'];
		$test_no = $_SESSION['test_no'];
		$test_bankno = $DB_CONN->getOne("select test_bankno from `test_course` where begin_course_cd=$course_cd and test_no=$test_no and sequence=$input[sequence];");
		$res = db_query("select r.login_id, p.personal_name from `register_basic` r, `personal_basic` p where r.personal_id=p.personal_id and r.personal_id in (select personal_id from `test_course_ans` where begin_course_cd=$course_cd and test_no=$test_no and test_bankno=$test_bankno and answer='$input[answer];');");
		while($r = $res->fetchRow(DB_FETCHMODE_ASSOC))
			$tpl->append("stu", $r);
		assignTemplate($tpl, "/examine/list_select_student.tpl");
	}

	//library
	//各種題型的表現方式相同處可抽出成函式
	function display_questions($tpl, $seq, $str, $index, $course_cd, $test_no){
			for($i = 0 ; $i < count($seq[$index]) ; $i++){
			
			$q = get_question_context($course_cd, $test_no, $seq[$index][$i]);
			$tpl->append($str, $q);
		}
	}

	//library
	//得到單選題、複選題、是非題的sequence列表
	//output為一個array, array[0] [1] [2]分別同上順序 單 複 是
	function get_sequence_list($course_cd, $test_no){
		$output = array();
		$sql = "select sequence from `test_course` where begin_course_cd=$course_cd and test_no=$test_no and ";
		array_push($output, get_sub_sequence_list($sql . "test_type=1 and is_multiple=0;"));
		array_push($output, get_sub_sequence_list($sql . "test_type=1 and is_multiple=1;"));
		array_push($output, get_sub_sequence_list($sql . "test_type=2;"));
		return $output;
	}

	//library
	//輔助get_sequence_list
	//因為選擇單選, 複選, 是非的動作僅後半段的sql語法稍有差異，故將其他部分抽出
	function get_sub_sequence_list($sql){
		$output = array();
		$tmp  = db_query($sql);
		while($r = $tmp->fetchRow(DB_FETCHMODE_ASSOC))
			array_push($output, $r['sequence']);
		return $output;
	}

	//library
	//得到一道試題的內容
	function get_question_context($course_cd, $test_no, $seq){
		global $DB_CONN;
		$s_type = $DB_CONN->getOne("select test_type from `test_course` where begin_course_cd=$course_cd and test_no=$test_no and sequence=$seq;");
		$context = $DB_CONN->getRow("select question, test_bankno, answer, sequence from `test_course` where begin_course_cd=$course_cd and test_no=$test_no and sequence=$seq;", DB_FETCHMODE_ASSOC);
		$sum = get_num_student($course_cd, $test_no);
		$output = array();

		if($s_type > 2)
			return -1;
		//是非題
		if($s_type == 2){
			$s = 0;
			$e = 2;
		}
		//選擇題
		else{
			$s = 1;
			$e = 7;
		}
		for($i = $s ; $i < $e ; $i++){
			$tmp = get_selection_context($course_cd, $test_no, $seq, $i);
			$tmp = get_selection_percentage($tmp, $sum);
			$tmp = get_is_answer($tmp, $context['answer']);
			array_push($output, $tmp);
		}

		$output = array_merge($output, $context);
		$output = set_answer($output);
		return $output;
	}

	//library
	//得到每個選項的內容及選擇名單
	function get_selection_context($course_cd, $test_no, $seq, $index){
		global $DB_CONN;
		$output = array();

		$s = $DB_CONN->getRow("select test_bankno, test_type, is_multiple from `test_course` where begin_course_cd=$course_cd and test_no=$test_no and sequence=$seq;", DB_FETCHMODE_ASSOC);

		if($s['test_type'] == 1)
			$output['context'] = $DB_CONN->getOne("select selection$index from `test_course` where begin_course_cd=$course_cd and test_no=$test_no and sequence=$seq;");
		else if($index == 0)
			$output['context'] = "非";
		else	
			$output['context'] = "是";
		$output['no'] = $index;

		$sql = "select r.login_id, p.personal_name from `register_basic` r, `personal_basic` p where r.personal_id=p.personal_id and r.personal_id in (select personal_id from `test_course_ans` where begin_course_cd=$course_cd and test_no=$test_no and test_bankno=$s[test_bankno] and answer";
		if($s['test_type'] == 1 && $s['is_multiple'] == 1)
			$s2 = db_query($sql . " like '%$index%');");
		else
			$s2 = db_query($sql . "='$index');");

		$student_list = array();
		while($r = $s2->fetchRow(DB_FETCHMODE_ASSOC))
			array_push($student_list, $r);
		$output['student_list'] = $student_list;
		$output['num'] = count($student_list);
		return $output;
	}

	//library
	//計算有填寫測驗的總人數
	function get_num_student($course_cd, $test_no){
		global $DB_CONN;
		$sum = $DB_CONN->getOne("select count(distinct personal_id) from `test_course_ans` where begin_course_cd=$course_cd and test_no=$test_no;");
		return $sum;
	}

	//library
	//計算選項所佔的百分比
	function get_selection_percentage($input, $sum){
		if($sum == 0)					//表示本題沒有人回答，避免產生除以零的錯誤
			$input['percentage'] = 0;
		else
			$input['percentage'] = round($input['num']/$sum, 2) * 100;
		return $input;
	}

	//library
	//判斷此選項是否為答案之一 
	function get_is_answer($input, $answer){
		if(strlen($answer) == 1)
			$input['is_answer'] = ($input['no'] == $answer) ? 1 : 0;
		else
			$input['is_answer'] = (strpos($answer , "$input[no]") != false || $answer[0] == $input['no']) ? 1 : 0;
		return $input;
	}

	//library
	//將正確答案的選項複製一次或重新計算(複選題)
	function set_answer($input){
		global $DB_CONN;
		$sum = get_num_student($_SESSION['begin_course_cd'], $_SESSION['test_no']);
		if(strlen($input['answer']) == 1){
			for($i = 0 ; $i < 5 ; $i++){
				if($input[$i]['is_answer'] == 1){
					$input['right'] = $input[$i];
					break;
				}
			}
		}
		else{
			$input['right'] = array();
			$input['right']['num'] = $DB_CONN->getOne("select count(*) from `test_course_ans` where begin_course_cd=$_SESSION[begin_course_cd] and test_no=$_SESSION[test_no] and test_bankno=$input[test_bankno] and answer='$input[answer];';");
			$input['right'] = get_selection_percentage($input['right'], $sum);
		}
		return $input;
	}

	//library
	//以exam_info.php中的questionDisplay為主，原函式並無計算該選項的人數
	//故加上get_question_context中計算的人數
	function extra_number_people($input, $extra){
		if($input['type'] > 2)
			return $input;

		//是非題
		if($input['type'] == 2){
			$input['answers'][0] = $extra[0]['num'];
			$input['answers'][1] = $extra[1]['num'];
		}
		//單選題 複選題
		else{
			$num = count($input['answers']);
			for($i = 0 ; $i < $num ; $i++)
				$input['answers'][$i+1]['num'] = $extra[$i]['num'];
		}
		return $input;
	}
?>