<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	update_status ( "編輯課程進度" );
	//new smarty	
	$tpl = new Smarty();
	//查出這門課的 課程行程
	$sql = "SELECT * FROM course_schedule WHERE begin_course_cd=$_SESSION[begin_course_cd]";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());	
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
		//查出教師
		$teacher_name = getTeacherNameByTeacherCd($DB_CONN, $row[teacher_cd]);
		
		$schedule_data[schedule_index] = $row[schedule_index];
		$schedule_data[course_schedule_day] = $row[course_schedule_day];
		$schedule_data[subject] = $row[subject];
		$schedule_data[course_type] = $row[course_type];
		$schedule_data[teacher_name] = $teacher_name;
		$schedule_data[course_activity] = $row[course_activity];		
		
		$tpl->append('schedule_data', $schedule_data);
	}
	//assign course name
	$tpl->assign("course_name", getCourseNameByCourseCd( $DB_CONN, $_SESSION[course_cd]));
	//assign type
	
	//assign position
	
	//assign unit
	$schedule_unit = getScheduleUnitByCourseCd( $DB_CONN, $_SESSION[course_cd]);
	$tpl->assign("unit_ids", array('月', '週', '天', '次', '時'));
	$tpl->assign("unit_names",array('月', '週', '天', '次', '時'));
	$tpl->assign("unit_id", $schedule_unit);
	$tpl->assign("schedule_unit", $schedule_unit);
	//assign teacher select
	$teach_teacher = getCourseAllTeacherByBeginCourseCd( $DB_CONN, $_SESSION[begin_course_cd]);
	$tpl->assign("teach_teacher_ids", $teach_teacher[teacher_cd]);
	$tpl->assign("teach_teacher_names",$teach_teacher[teacher_name]);
	$tpl->assign("teach_teacher_id", $teach_teacher[teacher_cd][0]);
				
	//assign date

	//display
	assignTemplate($tpl, "/course/tea_course_schedule.tpl");		
	
//--------function area-------------
function getCourseNameByCourseCd( $DB, $course_cd){
	$sql = "SELECT course_name FROM course_basic WHERE course_cd='".$course_cd."'";
	return $DB->getOne($sql);
}

function getTeacherNameByTeacherCd( $DB, $teacher_cd ){
	$sql = "SELECT personal_name FROM personal_basic WHERE personal_id='".$teacher_cd."'";
	return $DB->getOne($sql);
}

function getScheduleUnitByCourseCd( $DB, $course_cd){
	//先從course_basic 查出 課程時程 (月、週、天、次、時)
	$sql = "SELECT schedule_unit FROM course_basic WHERE course_cd='".$course_cd."'";
	return $DB->getOne($sql);
}

function getCourseAllTeacherByBeginCourseCd( $DB, $begin_course_cd){
	$sql = "SELECT tb.teacher_cd, p.personal_name FROM teach_begin_course tb, personal_basic p WHERE tb.begin_course_cd='$begin_course_cd' and tb.teacher_cd=p.personal_id ORDER BY tb.teacher_cd ASC";
	$res = $DB->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	//$loop = count($res);
	$i=0;
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){		
		$teacher[teacher_cd][$i] = $row[teacher_cd];
		$teacher[teacher_name][$i] = $row[personal_name];
		$i++;
	}
	return $teacher;
}
	
?>
