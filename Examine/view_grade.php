<?php
	/*author: lunsrot
	 * date: 2007/07/03
	 */
	require_once("../config.php");
	require_once("../session.php");
    require_once("../library/filter.php");
    global $DB_CONN;
    
    $tpl = new Smarty;
    checkAdminTeacherTa();

	$course_cd = $_SESSION['begin_course_cd'];
    $input=array();
    $input['test_no'] = required_param('test_no',PARAM_INT);
    $input['reset_stu_test']= optional_param('reset_stu_test',0,PARAM_INT);
    if($input['reset_stu_test']==1){
        $input['sid'] = required_param('sid',PARAM_INT);
        
        resetStudetnGrade($course_cd,$input['test_no'],$input['sid']);
    }

    //檢查此次測驗是否有簡答題
	$haveComment = isHaveComment($course_cd, $input['test_no']);
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
		//測驗沒有簡答題
		if($haveComment == false)
			$row['isreply'] = 0;
		$tpl->append("people", $row);
	}
	$tpl->assign("test_no", $input['test_no']);
	$tpl->assign("course_cd", $course_cd);

	assignTemplate($tpl, "/examine/view_grade.tpl");

	function isHaveComment($course_cd, $test_no){
		global $DB_CONN;
		$num = $DB_CONN->getOne("select count(*) from `test_course` where begin_course_cd=$course_cd and test_no=$test_no and test_type=4;");
		if($num != 0)
			return true;
		return false;
    }
    
    function resetStudetnGrade($course_cd,$test_no,$personal_id)
    {
        
        if( empty($course_cd) || empty($test_no) || empty($personal_id) )
            return ;
        //清除學生的測驗成績細項(各題成績)
        /*$sql_clean_test_grade = "DELETE FROM `test_course_ans` 
                                 WHERE begin_course_cd={$course_cd}
                                 AND test_no={$test_no}
                                 AND personal_id={$personal_id};";
         */
        //清除學生測驗總成績
        $sql_del_student_grade = "DELETE FROM course_concent_grade 
                                  WHERE begin_course_cd = {$course_cd}
                                  AND percentage_num = {$test_no}
                                  AND student_id = {$personal_id};";
        

        db_query($sql_clean_test_grade.
                 $sql_del_student_grade);

    }
?>
