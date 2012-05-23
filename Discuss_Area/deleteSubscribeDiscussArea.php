<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_GET['begin_course_cd'];		//取得課程代碼
	
	$behavior = $_GET['behavior'];						//取得行為
	$argument = $_GET['argument'];						//取得參數
	$finishPage = $_GET['finishPage'];					//取得結束的網頁

	//註冊課程代碼到SESSION	
	if( isset($begin_course_cd) == true)	$_SESSION['begin_course_cd'] = $begin_course_cd;
	else									$begin_course_cd = $_SESSION['begin_course_cd'];

	//將參數分解成討論區編號discuss_cd
	$discuss_cd_Counter = 0;
	
	$token = strtok($argument, "_");
	while ($token !== false) 
	{
		$discuss_cd_list[$discuss_cd_Counter++] = $token;

		$token = strtok("_");
	}
	$discuss_cd_Number = $discuss_cd_Counter;
	
	//刪除訂閱這些討論區
	for($discuss_cd_Counter=0; $discuss_cd_Counter<$discuss_cd_Number; $discuss_cd_Counter++)
	{
		$discuss_cd = $discuss_cd_list[$discuss_cd_Counter];

		//訂閱討論區
		deleteSubscribeOneDiscussArea($DB_CONN, $begin_course_cd, $discuss_cd, $personal_id);
	}

	header("Location: $finishPage?behavior=$behavior");
	
/**********************************************************************************/

	function deleteSubscribeOneDiscussArea($DB_CONN, $begin_course_cd, $discuss_cd, $personal_id)
	{
		//從Table discuss_subscribe刪除被訂閱的討論區
		$sql = "DELETE FROM discuss_subscribe WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND personal_id=$personal_id";	
		$sth = $DB_CONN->prepare($sql);	
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
	}
?>
