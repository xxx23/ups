<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	update_status ( "觀看課程大綱" );
	//new smarty	
	$tpl = new Smarty();
	
	$cur_course_cd = "";
	if(isset($_GET[course_cd]))
		$cur_course_cd = $_GET[course_cd];
	else 
		$cur_course_cd = $_SESSION[course_cd];	

	if($cur_course_cd == null)
	{
		echo "教師尚未設定課程。";
		exit(0);
	}
	
	$_SESSION[cur_course_cd] = 	$cur_course_cd;	
	//查出資料
	$sql = "SELECT * FROM course_basic WHERE course_cd='".$_SESSION[cur_course_cd]."'";
	$res = $DB_CONN->query($sql);
	if($res->numRows() != 0){
		$course_data = $res->fetchRow(DB_FETCHMODE_ASSOC);
		$tpl->assign("course_future", $course_data[future]);
		$tpl->assign("course_introduction", $course_data[introduction]);
		$tpl->assign("goal", $course_data[goal]);
		$tpl->assign("person_mention", $course_data[person_mention]);
		$tpl->assign("course_process", $course_data[course_process]);
		$tpl->assign("learning_test", $course_data[learning_test]);
        $tpl->assign("course_environment", $course_data[environment]);
        $tpl->assign("note",$corse_data['note']);
        $tpl->assign("outline",$course_data['outline']);
        $tpl->assign("introduction",$course_data['introduction']);
		$info_file = rtrim($DATA_FILE_PATH,"/")."/".$course_data[teacher_cd]."/Course_Intro/".$course_data[course_cd]."/index.htm";
	}


        if(file_exists($info_file))
		header("Location:".rtrim($WEBROOT,"/")."/Data_File/".$course_data[teacher_cd]."/Course_Intro/".$course_data[course_cd]."/index.htm");
	assignTemplate($tpl, "/course/stu_course_intro.tpl");
	
//--------function area-------------
	
?>
