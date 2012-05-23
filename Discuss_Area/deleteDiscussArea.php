<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	require_once("library.php");
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼
	
	$behavior = $_GET['behavior'];						//取得行為
	$argument = $_GET['argument'];						//取得參數

	//將參數分解成討論區編號discuss_cd
	$discuss_cd_Counter = 0;
	
	$token = strtok($argument, "_");
	while ($token !== false) 
	{
		$discuss_cd_list[$discuss_cd_Counter++] = $token;

		$token = strtok("_");
	}
	$discuss_cd_Number = $discuss_cd_Counter;
	
	//刪除這些討論區的資料以及相關的資料
	for($discuss_cd_Counter=0; $discuss_cd_Counter<$discuss_cd_Number; $discuss_cd_Counter++)
	{
		$discuss_cd = $discuss_cd_list[$discuss_cd_Counter];
	
		//刪除ㄧ個討論區
		deleteOneDiscussArea($DB_CONN, $begin_course_cd, $discuss_cd, $COURSE_FILE_PATH);
	}
	
	header("Location: showDiscussAreaList.php?behavior=$behavior");
		
?>
