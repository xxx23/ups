<?php
	/*author: lunsrot
	 * date: 2007/07/03
	 */
	require_once("exam_info.php");

	checkMenu("/Examine/tea_view.php");

	$tpl = new Smarty;
	$input = $_POST;

	if($input['option'] == "correct"){
		$tmp = 0;
		$result = db_query("select test_bankno from `test_course` where begin_course_cd=$input[course_cd] and test_no=$input[test_no] and test_type=4;");
		while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
			$grade = $input[ 'question_' . $row['test_bankno'] ];
			db_query("update `test_course_ans` set grade=$grade where begin_course_cd=$input[course_cd] and test_no=$input[test_no] and personal_id=$input[pid] and test_bankno=$row[test_bankno];");
			$tmp = $tmp + $grade;
		}
		$tmp = $DB_CONN->getOne("select sum(grade) from `test_course_ans` where begin_course_cd=$input[course_cd] and personal_id=$input[pid] and test_no=$input[test_no];");
		db_query("update `course_concent_grade` set concent_grade=$tmp where begin_course_cd=$input[course_cd] and student_id=$input[pid] and number_id in (select number_id from `course_percentage` where begin_course_cd=$input[course_cd] and percentage_type=1 and percentage_num=$input[test_no]);");
		
		header("location:./view_grade.php?test_no=" . $input['test_no']);
	}else{
		$input = $_GET;
		$result = db_query("select A.test_bankno, A.question, A.grade, A.sequence, B.answer, B.grade as ans_grade from `test_course` A, `test_course_ans` B where A.begin_course_cd=$input[course_cd] and A.test_no=$input[test_no] and A.test_type=4 and B.test_bankno=A.test_bankno and B.personal_id=$input[pid] and B.begin_course_cd=A.begin_course_cd and B.test_no=A.test_no order by A.sequence;");
		while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false)
			$tpl->append("questions", $row);
		$tpl->assign("course_cd", $input['course_cd']);
		$tpl->assign("test_no", $input['test_no']);
		$tpl->assign("pid", $input['pid']);
		
		assignTemplate($tpl, "/examine/tea_correct.tpl");
	}
?>
