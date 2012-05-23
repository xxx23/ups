<?php
/***
FILE:   
DATE:   
AUTHOR: zqq
**/
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	update_status ( "觀看開課" );

	//new smarty	
	$tpl = new Smarty();
	
	$sql = 
		"SELECT 
			bc.begin_course_cd, bc.begin_course_name, u.unit_name, bc.inner_course_cd, p.personal_name 
		FROM 
			begin_course bc, lrtunit_basic_ u, teach_begin_course tbc, personal_basic p
		WHERE
			bc.begin_course_cd=tbc.begin_course_cd and
			tbc.teacher_cd='".$_SESSION[personal_id]."'  and
			p.personal_id='".$_SESSION[personal_id]."'  and
			bc.begin_unit_cd=u.unit_cd and
			bc.begin_coursestate='0' 
		ORDER BY bc.begin_course_cd ASC ";	
	$result = $DB_CONN->query($sql);
	$num = 0;
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
	  //新進課程
		$row['num'] = $num++;
		//$row['code_path'] = "../Course_Admin/check_begin_course.php";
		$tpl->append('new_course_data', $row);				
	}		
	//輸出頁面
	assignTemplate($tpl, "/course_admin/show_teacher_begin_course.tpl");				
?>
