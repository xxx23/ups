<?php
	/*authro: lunsrot
	 * date: 2007/07/01
	 */
	require_once("exam_info.php");
	require_once("../library/content.php");
	
	global $DB_CONN;
	$tpl = new Smarty;
	$course_cd = $_SESSION['begin_course_cd'];
	$pid = $_SESSION['personal_id'];
	$date = getCurTime();
	$tmp = gettimeofday();
    $attribute = get_course_attribute($course_cd);
    if($attribute ==0) 
		$result = db_query("select * from `test_course_setup` where begin_course_cd=$course_cd AND  is_online = 1 order by test_no;");
    else
		$result = db_query("select * from `test_course_setup` where begin_course_cd=$course_cd and '$date'>d_test_public AND is_online = 1 order by test_no;");

	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
	  $grade = $DB_CONN->getOne("Select concent_grade from `course_concent_grade` where begin_course_cd=$course_cd and student_id=$pid and number_id in (select number_id from `course_percentage` where begin_course_cd=$course_cd and percentage_type=1 and percentage_num=$row[test_no]);");
        
        if(timecmp($tmp['sec'], strtotime($row['d_test_beg'])) != 1){
			$row['disabled'] = 1;
		}else if(timecmp($tmp['sec'], strtotime($row['d_test_end'])) != 1 && isTest($pid, $course_cd, $row['test_no']) == false){
			$row['disabled'] = 2;
		}else if(timecmp($tmp['sec'], strtotime($row['d_test_end'])) != 1){
			$row['disabled'] = 3;
			$row['grade'] = $grade;
		}else if(timecmp($tmp['sec'], strtotime($row['d_test_end'])) == 1 && $row['ans_public'] == 0){
			$row['disabled'] = 3;
			$row['grade'] = $grade;
		}else{
			$row['disabled'] = 4;
			$row['grade'] = $grade;
		} 
		
		if($attribute == 0)//自學部分的判斷
		{
			if(!is_read_time_enough($course_cd,$pid))
			{	
				$row['disabled'] = 0;
			}
			else if(isTest($pid, $course_cd, $row['test_no']))
			{
				$row['grade'] = $grade;
				$ispass = isPass($course_cd,$grade);
				if($ispass && $row['ans_public'] == 0){
					$row['disabled'] = 3;
				}else if($ispass && $row['ans_public'] == 1){
					$row['disabled'] = 4;
				}else{
					$row['disabled'] = 2;
				}
			}
			else
			{
				$row['disabled'] = 2;
			}
		}
		$public = $DB_CONN->getOne("select grade_public from `test_course_setup` where begin_course_cd=$course_cd and test_no=$row[test_no];");
		if($public != 1 && is_numeric($row['grade']))
		  $row['grade'] = "N/A";
		$tpl->append("exam_data", $row);
	}

	assignTemplate($tpl, "/examine/stu_view.tpl");
	
	function is_read_time_enough($begin_course_cd, $personal_id)
	{
		//取得閱讀時數條件
		$sql = "SELECT TIME_TO_SEC(criteria_content_hour) 
				FROM begin_course
				WHERE begin_course_cd = {$begin_course_cd}";
		$read_time_limit = db_getOne($sql);
	    require_once('../library/lib_course_pass.php');
		$read_time = getReadSecond($begin_course_cd,$personal_id);		
		
		if($read_time >= $read_time_limit)
			return true;
		else 
			return false;
	}	
	
	function isTest($pid, $course_cd, $test_no){
		$tmp = db_query("select * from `test_course_ans` where begin_course_cd=$course_cd and test_no=$test_no and personal_id=$pid;");
		$num = $tmp->numRows();
		if($num != 0)
			return true;
		return false;
	}
	
	function get_course_attribute($begin_course_cd)
	{
		if(empty($begin_course_cd))
			return -1;
		$sql= "SELECT attribute FROM begin_course WHERE begin_course_cd={$begin_course_cd}";
		return db_getOne($sql);
	}
	
	function isPass($begin_course_cd,$grade)
	{
		$pass_grade = get_pass_grade($begin_course_cd);
		
		if($grade >= $pass_grade)
			return true;
		else return false;
	}
	
	function get_pass_grade($begin_course_cd)
	{
		$sql = "SELECT criteria_total  FROM begin_course WHERE begin_course_cd = {$begin_course_cd}";
		
		return ($begin_course_cd == null) ? null : db_getOne($sql); 
	}

?>
