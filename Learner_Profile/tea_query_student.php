<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	require_once($RELEATED_PATH . "library/common.php");
	require_once($HOME_PATH . 'library/smarty_init.php');
	//new smarty
	//$tpl = new Smarty();
	
	if("allow" == $_GET[action]){
		($_GET[allow]== 1)?$allow_course=0:$allow_course=1;
		$sql = "UPDATE take_course SET allow_course='$allow_course' WHERE personal_id='".$_GET[personal_id]."' and begin_course_cd='".$_SESSION[begin_course_cd]."'";
		$res = db_query($sql);
		sync_stu_course_data($_SESSION['begin_course_cd'],$_GET['personal_id']);
	}
	else if("status" == $_GET[action]){
		($_GET[status]== 1)?$status_student=0:$status_student=1;
		$sql = "UPDATE take_course SET status_student='$status_student' WHERE personal_id='".$_GET[personal_id]."' and begin_course_cd='".$_SESSION[begin_course_cd]."'";
		$res = db_query($sql);
		sync_stu_course_data($_SESSION['begin_course_cd'],$_GET['personal_id']);
	}
	

    // 拿資料不要一次拿全部齁= =，幫修正了
	$sql = "SELECT r.personal_id, r.login_id, p.personal_name, p.email, p.personal_home, t.allow_course, t.status_student FROM register_basic r, personal_basic p, take_course t WHERE t.begin_course_cd='".$_SESSION[begin_course_cd]."' AND  t.personal_id=r.personal_id  AND r.personal_id = p.personal_id AND r.role_cd='3' ORDER BY login_id";
	$res = db_query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
		//allow_course: 1表示核准 0表示不核准
		//status_student: 1表示正修生 0表示旁聽生
		$user[] = $row;
	}	

	// 顯示 匯入的結果	
	$tpl->assign("user", $user);
	
	//輸出頁面
	assignTemplate($tpl, "/learner_profile/tea_query_student.tpl");
		
	//----------------function area ------------------
?>
