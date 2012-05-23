<?php 
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	update_status ( "編輯課程大綱" );

	checkMenu("/Course/tea_course_intro.php");
	//new smarty	
	//$tpl = new Smarty();
	global $HOME_PATH;
	require_once($HOME_PATH . 'library/smarty_init.php');
	//exit;
	$cur_course_cd = "";
	if(isset($_GET[course_cd]))
		$cur_course_cd = $_GET[course_cd];
	else 
		$cur_course_cd = $_SESSION[course_cd];	
	
	if($cur_course_cd == null)
	{
	  	if( $_SESSION['lang'] == "zh_tw"  || !isset($_SESSION['lang']) )
			echo "教師尚未設定課程。";
		else
			echo "The teacher has not set the course.";
		if(isset($_SESSION['role_cd']) && $_SESSION['role_cd'] == '1')
		{
			if( $_SESSION['lang'] == "zh_tw" || !isset($_SESSION['lang']) )
				echo "<br>請到<a href=\"course_manage.php\">課程管理</a>中掛載課程。";
			else
				echo "<br>Please go to <a href=\"course_manage.php\">Course Management</a>to set the course";
		}
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
		$tpl->assign("course_goal", $course_data[goal]);
		$tpl->assign("person_mention", $course_data[person_mention]);
		$tpl->assign("course_process", $course_data[course_process]);
		$tpl->assign("learning_test", $course_data[learning_test]);
		$tpl->assign("course_environment", $course_data[environment]);
		$tpl->assign("teacher_cd",$course_data[teacher_cd]);
		$tpl->assign("course_cd",$course_data[course_cd]);
		$info_file = rtrim($DATA_FILE_PATH,"/")."/".$course_data[teacher_cd]."/Course_Intro/".$course_data[course_cd]."/index.htm";
	}

	$teacher_cd = $course_data['teacher_cd'];

	if($_POST['ACTION'] == 'upload')
	{
		$distination = rtrim($DATA_FILE_PATH,"/").$teacher_cd."/Course_Intro/".$cur_course_cd;

		if(!file_exists(rtrim($DATA_FILE_PATH,'/')."/".$teacher_cd."/Course_Intro"))
  			createPath(rtrim($DATA_FILE_PATH,'/')."/".$teacher_cd."/Course_Intro");
		if(!file_exists(rtrim($DATA_FILE_PATH,'/')."/".$teacher_cd."/Course_Intro/".$cur_course_cd))
		  	createPath(rtrim($DATA_FILE_PATH,'/')."/".$teacher_cd."/Course_Intro/".$cur_course_cd);

  		if(copy($_FILES['userfile']['tmp_name'],$info_file))
  		{
    			$tpl->assign("msg","upload success");
  		}
  		else
  		{
     			$tpl->assign("msg","upload failed");
  		}
	}
	else if($_POST['ACTION'] == 'del')
	{
		if(file_exists($info_file))
		 	if(unlink($info_file))
			{
				$tpl->assign("msg","del success");
			}
			else
			{
				$tpl->assign("msg","del failed");
			}
	}

	
	
        if(file_exists($info_file))
		$tpl->assign("info_file",$WEBROOT."Data_File/".$course_data[teacher_cd]."/Course_Intro/".$course_data[course_cd]."/index.htm");
	  assignTemplate($tpl, "/course/tea_course_intro.tpl");
	 
	 
//--------function area-------------
	
?>
