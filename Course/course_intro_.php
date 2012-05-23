<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	update_status ( "觀看課程大綱" );
	//new smarty	
	$tpl = new Smarty();
	$sql = "SELECT role_cd FROM register_basic WHERE personal_id='".$_SESSION[personal_id]."'";	
	$role_cd = $DB_CONN->getOne($sql);
	if($role_cd == 1){
		$tpl->assign("role_path", "./tea_course_intro.php");
	}
	elseif($role_cd == 3){
		$tpl->assign("role_path", "./stu_course_intro.php");
	}

	assignTemplate($tpl, "/course/course_intro_.tpl");
	
//--------function area-------------
	
?>
